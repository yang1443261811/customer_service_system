//获取工单列表
function getDialogList(apiUrl, page, $fun) {
    //获取客户列表
    $.get(apiUrl + '?page=' + page).done(function (response) {
        var _html = '';
        users_current_page = response.current_page;
        users_total_page = response.last_page;
        $.each(response.data, function (key, item) {
            //如果最后的回复是图片将图片资源替换成文字
            var lastWord = (item.content_type === 2) ? '图片' : item.content;

            var data = JSON.stringify({
                id: item.id,
                uid: item.uid,
                name: item.name,
                status: item.status,
                address: item.address,
            });

            _html += '<div class="box-comment" data = ' + data + '>';
            _html += '<img class="img-circle img-sm" src="' + item.avatar + '"><div class="comment-text">';
            _html += '<span class="username">' + item.name + '';
            _html += item.server_msg_unread_count > 0 ? '<span class="pull-right badge bg-red">' + item.server_msg_unread_count + '</span>' : '';
            _html += '</span><span class="last-word">' + lastWord + '</span></div></div>';
        });

        $fun(_html);
    });
}

//点击客户进入聊天窗口
function intoChatRoom() {
    //保存客户的uid
    currentDialog = JSON.parse($(this).attr('data'));
    $('.user-info .user_id').html(currentDialog.uid);
    $('.user-info .address').html(currentDialog.address);
    $('.direct-chat .nickname').html(currentDialog.name);
    //客户列表选中效果
    $('.box-comment').removeClass('active');
    $(this).addClass('active');
    //删除未读消息数量标签
    $(this).find('.badge').remove();
    //使聊天窗口的编辑区可编辑
    unLock();
    //清空聊天记录
    $(".direct-chat-messages").html('');
    //保存当前选中工单的dom
    currentDialog.dom = $(this);
    //获取聊天记录
    showChatRecord(currentDialog.id, 1, true);
}

/**
 * 获取聊天记录
 * @param chat_id 工单id
 * @param page  当前页
 * @param scroll_to_end 聊天框是否定位到顶部
 */
function showChatRecord(chat_id, page, scroll_to_end) {
    $.get('/chatRecord/get/' + chat_id + '?page=' + page, function (response) {
        var _html = '';
        chat_log_current_page = response.current_page;
        chat_log_total_page = response.last_page;
        $.each(response.data, function (index, item) {
            //如果是图片的话,构建一个图片标签
            if (parseInt(item.content_type) === 2) {
                item.content = '<img src="' + item.content + '" style="width: 200px;height: auto">';
            }
            //如果消息来源于客户那么消息显示在聊天窗口右侧
            var point = item.from_id == currentDialog.uid ? 'left' : 'right';
            _html += msgFactory(item.content, item.from_avatar, item.from_name, item.created_at, point);
        });

        var scrollHeight = $('.direct-chat-messages')[0].scrollHeight;
        //将聊天记录插入到dom中
        $(".direct-chat-messages").prepend(_html);
        var newScrollHeight = $('.direct-chat-messages')[0].scrollHeight;
        //聊天框下拉条定位
        (scroll_to_end === true)
            ? scrollToEnd()
            : $('.direct-chat-messages').scrollTop(newScrollHeight - scrollHeight);
    })
}

//上拉加载更多
function loadMoreChatLog() {
    var scrollTop = $(this).scrollTop();
    if (scrollTop === 0) {
        if (chat_log_current_page + 1 <= chat_log_total_page) {
            showChatRecord(currentDialog.id, chat_log_current_page + 1, false);
        }
    }
}

//客户列表下拉加载更多
function loadMoreUser() {
    var height = $(this).height();
    if ($(this).scrollTop() + height === $(this)[0].scrollHeight) {
        if (users_current_page + 1 <= users_total_page) {
            if ($(this).hasClass('queue')) {
                getDialogList('/dialog/get/1', users_current_page + 1, function (html) {
                    $('.box-comments').eq(1).append(html)
                });
            } else {
                getDialogList('/dialog/get/2', users_current_page + 1, function (html) {
                    $('.box-comments').eq(0).append(html)
                });
            }
        }
    }
}
//发送图片消息处理
function sendImageHandler(e) {
    var image = e.target.files[0];
    if (!image) {
        return;
    }

    var formData = new FormData();
    formData.append('image', image);
    formData.append('_token', token);

    $.ajax({
        url: '/chatLog/upload',
        type: 'POST',
        cache: false,
        data: formData,
        processData: false,
        contentType: false

    }).done(function (res) {
        //构建图片消息标签然后插入dom中
        var image = '<img src="' + res.url + '" style="height: 100px; width: 100px">';
        var _html = msgFactory(image, kf_avatar, kf_name, getDate(), 'right');
        $(".direct-chat-messages").append(_html);
        //聊天消息显示框定位到最底部
        scrollToEnd();
        //保存消息
        storeMessage(res.url, 2);

    }).fail(function (res) {
        console.log(res.responseJSON.message);
    });
}

//发送文字消息处理
function sendTextHandler() {
    var text = $('#text_in').val();
    if (!text) {
        return false;
    }
    $('#text_in').val('');
    var elem = msgFactory(text, kf_avatar, kf_name, getDate(), 'right');
    $('.direct-chat-messages').append(elem);
    scrollToEnd();
    storeMessage(text, 1);
}

//发送表情消息处理
function sendFaceHandler() {
    var faceText = $(this).attr('labFace');
    var labFace = $(this).parent().html();
    var elem = msgFactory(labFace, kf_avatar, kf_name, getDate(), 'right');
    $('.direct-chat-messages').append(elem);
    scrollToEnd();
    storeMessage(labFace, 3);
}

//发送快捷回复
function sendFastReply() {
    var word = $(this).attr('word');
    var elem = msgFactory(word, kf_avatar, kf_name, getDate(), 'right');
    $('.direct-chat-messages').append(elem);
    scrollToEnd();
    storeMessage(word, 1);
}

/**
 * 为一条消息构建dom标签
 * @param content 消息的内容
 * @param avatar  发送消息人的头像
 * @param nickname 发送消息人的昵称
 * @param time     发送消息的时间
 * @param point   消息显示在消息窗口的左侧还是右侧
 */
function msgFactory(content, avatar, nickname, time, point) {
    var _html = '';
    _html += '<div class="direct-chat-msg ' + point + '"><div class="direct-chat-info clearfix">';
    _html += '<span class="direct-chat-name ">' + nickname + '</span>';
    _html += '<span class="direct-chat-timestamp">' + time + '</span></div>';
    _html += '<img class="direct-chat-img" src="' + avatar + '" alt="Message User Image">';
    _html += '<div class="direct-chat-text">' + content + '</div></div>';

    return _html;
}

/**
 * 存储消息内容
 * @param content 消息的内容
 * @param contentType 消息的类型 1是文字消息 2是图片消息 3是表情消息
 */
function storeMessage(content, contentType) {
    var data = {
        'chat_id': currentDialog.id,
        'from_id': kf_id,
        'from_name': kf_name,
        'from_avatar': kf_avatar,
        'to_id': currentDialog.uid,
        'content': content,
        'type': contentType,
        'status': currentDialog.status,
        '_token': token
    };

    $.post('/server/send_by_kf/' + client_id, data, function (res) {
        var err = res ? '保存成功' : '保存失败';
        if (!res) {
            return false;
        }
        //如果当前消息所属的工单是排队列表中的工单,那么将这个工单的dom动态的插入到当前对话列表
        if (currentDialog.dom.parents('.box-comments').hasClass('queue') && currentDialog.dom) {
            $('.box-comments:first').prepend(currentDialog.dom.clone());
            currentDialog.dom = '';
        }

    }).complete(function (res) {
        if (res.status !== 200) {
            $.each(res.responseJSON.errors, function (key, value) {
                console.log(value[0]);
                return false;
            });
        }
    })
}

function new_message_process(data) {
    $('.box-comments .box-comment').each(function () {
        var attr = JSON.parse($(this).attr('data'));
        if (data.chat_id == attr.id) {
            //累加未读消息的数量,如果用户标签里存在未读消息数量标签,就累加标签的计数,如果没有就插入一个新的未读消息标签
            if ($(this).find('.badge').length !== 0) {
                var total = parseInt($(this).find('.badge').html()) + 1;
                $(this).find('.badge').html(total);
            } else {
                $(this).find('.username').append('<span class="pull-right badge bg-red">1</span>');
            }

            //如果发送的消息是一张图片就显示成文字提示
            var elem = data.content_type == 2 ? '图片' : data.content;
            $(this).find('.last-word').html(elem);

            //如果新消息所属的工单的排列位置大于5就将工单置顶到顶部
            if ($(this).index() > 5) {
                $(this).parent().prepend($(this))
            }

            return false;
        }
    });

    //如果新消息的工单不是当前工单直接返回
    if (data.chat_id != currentDialog.id) {
        return false;
    }

    //如果是图片消息
    if (parseInt(data.content_type) === 2) {
        data.content = '<img src="' + data.content + '" style="width: 200px;height: auto">';
    }
    //构建消息标签然后插入dom中
    var _html = msgFactory(data.content, data.avatar, data.name, getDate(), 'left');
    $(".direct-chat-messages").append(_html);
    //聊天框默认最底部
    scrollToEnd();
    //将接收到的消息标记为已读
    $.get('/chatRecord/haveRead/' + data.chat_id)
}

function connect_success_process(client_id) {
    window.client_id = client_id;
    //用户加入到聊天服务中
    var api = '/server/join/' + kf_id + '/' + client_id;
    $.get(api, function(res) {
        //nothing to do
    });
}

//工单处理完成
function dialogEnd() {
    $.get('/dialog/completed/' + currentDialog.id, function (res) {
        if (res) {
            $('.box-comments .active').remove();
            lock();
        } else {
            layer.msg('操作失败');
        }
    });
}

//消息显示框定位到最底部
function scrollToEnd() {
    $(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);
}

//去除编辑区的遮罩使其可以编辑
function unLock() {
    $('.shade,.screen').addClass('hidden');
}

//增加遮罩使编辑区不可编辑
function lock() {
    $('.shade,.screen').removeClass('hidden');
}

// 获取日期
function getDate() {
    var d = new Date(new Date());

    return d.getFullYear() + '-' + digit(d.getMonth() + 1) + '-' + digit(d.getDate())
        + ' ' + digit(d.getHours()) + ':' + digit(d.getMinutes()) + ':' + digit(d.getSeconds());
}

//补齐数位
var digit = function (num) {
    return num < 10 ? '0' + (num | 0) : num;
};


function replace_em(str) {
    console.log('call fun');
    str = str.replace(/</g, '<；');
    str = str.replace(/>/g, '>；');
    str = str.replace(/ /g, '<；br/>；');
    str = str.replace(/\[em_([0-9]*)\]/g, '<img src="face/$1.gif" border="0" />');
    return str;
}
