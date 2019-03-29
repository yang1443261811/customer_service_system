lock();

//获取工单列表
function getWorkOrderList(apiUrl) {
    //获取客户列表
    $.get(apiUrl).done(function (response) {
        var _html = '';
        $.each(response, function (key, item) {
            //如果最后的回复是图片将图片资源替换成文字
            var lastWord = (item.lastReply.content_type === 2) ? '图片' : item.lastReply.content;
            var data = JSON.stringify({uid: item.uid, wo_id: item.id, address: item.address});
            _html += '<div class="box-comment" data = ' + data + '>';
            _html += '<img class="img-circle img-sm" src="' + item.avatar + '"><div class="comment-text">';
            _html += '<span class="username">' + item.name + '';
            _html += item.server_msg_unread_count > 0 ? '<span class="pull-right badge bg-red">' + item.server_msg_unread_count + '</span>' : '';
            _html += '</span>' + lastWord + '</div></div>';
        });

        $('.box-comments').html(_html);
    });
}

//点击客户进入聊天窗口
function intoChatRoom() {
    //保存客户的uid
    var data = $(this).attr('data');
    data = JSON.parse(data);
    to_id = data.uid;
    //保存工单的ID
    wo_id = data.wo_id;
    $('.user_id').html(data.uid);
    $('.address').html(data.address);
    //初始化客服与用户的的连接
    $.ajax({
        type: "post",
        url: '/server/joinGroup/' + client_id,
        data: {'group_id': to_id, '_token': token}
    });

    //客户列表选中效果
    $('.box-comment').removeClass('active');
    $(this).addClass('active');
    //删除未读消息数量标签
    $(this).find('.badge').remove();
    //使聊天窗口的编辑区可编辑
    unLock();
    //获取聊天记录
    showChatRecord(wo_id);
}

/**
 * 获取聊天记录
 * @param wo_id 工单id
 */
function showChatRecord(wo_id) {
    $.get('/chatRecord/get/' + wo_id, function (response) {
        var _html = '';
        $.each(response, function (index, item) {
            //如果是图片的话,构建一个图片标签
            if (parseInt(item.content_type) === 2) {
                item.content = '<img src="' + item.content + '" style="width: 200px;height: auto">';
            }
            //如果消息来源于客户那么消息显示在聊天窗口右侧
            var point = item.from_id == to_id ? 'left' : 'right';

            _html += msgFactory(item.content, item.from_avatar, item.from_name, item.created_at, point);
        });

        $(".direct-chat-messages").html(_html);

        //聊天框默认最底部
        scrollToEnd();
    })
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
        'wo_id': wo_id,
        'from_id': kf_id,
        'from_name': kf_name,
        'from_avatar': kf_avatar,
        'to_id': to_id,
        'to_name': to_name,
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
                $('.fastReply-box').prepend('<span class="addReply label bg-green" word="' + content + '" key="' + res + '">' + title + '</span>');
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

function getFastReply() {
    $.get('/fastReply/get', function (res) {
        var _html = '';
        $.each(res, function (index, item) {
            _html += '<span class="label bg-green" title="应用" word="' + item.word + '" key="' + item.id + '">' + item.title + '<i class="fa fa-fw fa-remove"></i></span>'
        });

        $('.fastReply-box').prepend(_html);
    })
}

//消息显示框定位到最底部
function scrollToEnd() {
    $(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);
}

//给编辑区加上遮罩使其不能编辑
function lock() {
    var parentHeight = $('.shade').parent().height() + 9;
    $('.shade').css('min-height', parentHeight);
    $('.shade').removeClass('hidden');
}

//去除编辑区的遮罩使其可以编辑
function unLock() {
    $('.shade,.screen').addClass('hidden');
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
