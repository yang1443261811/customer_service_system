//获取工单列表
function getWorkOrderList(apiUrl) {
    //获取客户列表
    $.get(apiUrl).done(function (response) {
        var _html = '';
        $.each(response, function (key, item) {
            //如果最后的回复是图片将图片资源替换成文字
            var lastWord = (item.lastReply.content_type === 2) ? '图片' : item.lastReply.content;
            var data = JSON.stringify({uid: item.uid, id: item.id, address: item.address, name: item.name, status: item.status});
            _html += '<div class="box-comment" data = ' + data + '>';
            _html += '<img class="img-circle img-sm" src="' + item.avatar + '"><div class="comment-text">';
            _html += '<span class="username">' + item.name + '';
            _html += item.server_msg_unread_count > 0 ? '<span class="pull-right badge bg-red">' + item.server_msg_unread_count + '</span>' : '';
            _html += '</span><span class="last-word">' + lastWord + '</span></div></div>';
        });

        $('.box-comments').html(_html);
    });
}

//点击客户进入聊天窗口
function intoChatRoom() {
    //保存客户的uid
    currentWorkOrder = JSON.parse($(this).attr('data'));
    $('.user_id').html(currentWorkOrder.uid);
    $('.address').html(currentWorkOrder.address);
    $('.direct-chat .nickname').html(currentWorkOrder.name);
    //客户列表选中效果
    $('.box-comment').removeClass('active');
    $(this).addClass('active');
    //删除未读消息数量标签
    $(this).find('.badge').remove();
    //使聊天窗口的编辑区可编辑
    unLock();
    //清空聊天记录
    $(".direct-chat-messages").html('');
    //获取聊天记录
    showChatRecord(currentWorkOrder.id, 1, true);
}

/**
 * 获取聊天记录
 * @param wo_id 工单id
 * @param page  当前页
 * @param scroll_to_end 聊天框是否定位到顶部
 */
function showChatRecord(wo_id, page, scroll_to_end) {
    $.get('/chatRecord/get/' + wo_id + '?page=' + page, function (response) {
        var _html = '';
        current_page = response.current_page;
        total_page = response.last_page;
        $.each(response.data, function (index, item) {
            //如果是图片的话,构建一个图片标签
            if (parseInt(item.content_type) === 2) {
                item.content = '<img src="' + item.content + '" style="width: 200px;height: auto">';
            }
            //如果消息来源于客户那么消息显示在聊天窗口右侧
            var point = item.from_id == currentWorkOrder.uid ? 'left' : 'right';
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
function loadMore() {
    var scrollTop = $(this).scrollTop();
    if (scrollTop === 0) {
        if (current_page + 1 > total_page) {
            return false;
        }

        showChatRecord(currentWorkOrder.id, current_page + 1, false);
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
        'wo_id': currentWorkOrder.id,
        'from_id': kf_id,
        'from_name': kf_name,
        'from_avatar': kf_avatar,
        'to_id': currentWorkOrder.uid,
        'content': content,
        'content_type': contentType,
        '_token': token
    };

    $.post('/server/send_by_kf/' + client_id, data, function (res) {
        var err = res ? '保存成功' : '保存失败';
        console.log(err);
    }).complete(function (res) {
        if (res.status !== 200) {
            $.each(res.responseJSON.errors, function (key, value) {
                console.log(value[0]);
                return false;
            });
        }
    })
}

//创建快捷回复
function createFastReply() {
    var title = $('#reply_title').val();
    var content = $('#reply_content').val();

    if (!title || !content) {
        layer.msg('标题跟内容不能为空');
        return false;
    }

    $.ajax({
        type: 'post',
        url: '/fastReply/create',
        data: {title: title, word: content, _token: token},
        success: function (res) {
            if (res) {
                layer.msg('添加成功', {icon: 1});
                $('.addReply').before('<span class="label bg-green send-fast-reply" word="' + content + '" key="' + res + '">' + title + '<i class="fa fa-fw fa-remove"></i></span>');
                window.setTimeout(layer.closeAll, 2000);
            } else {
                layer.msg('添加失败');
            }
        },
        error: function (res) {
            if (res.status === 422) {
                $.each(res.responseJSON.errors, function (key, value) {
                    layer.msg(value[0]);
                    return false;
                });
            } else {
                layer.msg('添加失败');
            }
        }
    })
}

//创建快捷回复.弹出框
function popupForm() {
    var _html = '<div class="addReplyForm"><div><label for="reply_title" class="control-label">标签:</label>';
    _html += '<input type="text" id="reply_title"></div>';
    _html += ' <div><label for="reply_content" class="control-label">内容:</label>';
    _html += '<textarea name="" id="reply_content"></textarea></div>';
    _html += '<div style="text-align: right"><button type="button" class="btn btn-info btn-sm save_reply">确定</button>';
    _html += '<button type="button" class="btn btn-default btn-sm cancelPopup">取消</button></div></div>';
    //自定页
    layer.open({
        type: 1,
        title: '新增快捷回复',
        area: ['420px', '300px'], //宽高
        content: _html
    });
}

//获取所有快捷回复
function getFastReply() {
    $.get('/fastReply/get', function (res) {
        var _html = '';
        $.each(res, function (index, item) {
            _html += '<span class="label bg-green send-fast-reply" title="应用" word="' + item.word + '" key="' + item.id + '">' + item.title + '<i class="fa fa-fw fa-remove"></i></span>'
        });

        $('.fastReply-box').prepend(_html);
    })
}

//删除快捷回复
function removeFastReply() {
    var that = $(this);
    var id = that.parents('span').attr('key');
    layer.confirm('确认删除？', {
        btn: ['确定', '取消'] //按钮
    }, function () {
        $.get('/fastReply/delete/' + id, function () {
            that.parents('span').remove();
            layer.msg('删除成功', {icon: 1});
        });
    });
}

function new_message_process(data) {
    $('.box-comments .box-comment').each(function () {
        var attr = JSON.parse($(this).attr('data'));
        if (data.wo_id == attr.id) {
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
            $(this).index() > 5 && $(this).parent().prepend($(this));

            return false;
        }
    });

    //如果新消息的工单不是当前工单直接返回
    if (data.wo_id != currentWorkOrder.id) {
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
    $.get('/chatRecord/haveRead/' + data.wo_id)
}

function connect_success_process(client_id) {
    window.client_id = client_id;
    //用户加入到聊天服务中
    $.post('/server/join/' + client_id, {'uid': kf_id, '_token': token})
}

//工单处理完成
function workOrderEnd() {
    $.get('/workOrder/completed/' + currentWorkOrder.id, function (res) {
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
