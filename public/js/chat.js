var chatRoomHeight, chatRecordHeight;
// autoChatRoomHeight();

$(window, ".wrapper").resize(function () {
    // autoChatRoomHeight();
});

lock();

// function autoChatRoomHeight() {
//     var neg = $('.main-header').outerHeight() + $('.main-footer').outerHeight();
//     var window_height = $(window).height();
//     var sidebar_height = $(".sidebar").height();
//     if (window_height >= sidebar_height) {
//         chatRoomHeight = window_height - neg - 80;
//         $(".nav-tabs-custom, .widget-user-2, .direct-chat").css('height', chatRoomHeight);
//     } else {
//         chatRoomHeight = sidebar_height - 80;
//         $(".nav-tabs-custom, .widget-user-2, .direct-chat").css('height', chatRoomHeight);
//     }
//
//     var editorHeight = $('.editor').height();
//     chatRecordHeight = chatRoomHeight - 60 - editorHeight;
//     $('.direct-chat-messages').css('height', chatRecordHeight);
// }

//获取工单列表
function getWorkOrderList(apiUrl) {
    //获取客户列表
    $.get(apiUrl).done(function (response) {
        var _html = '';
        $.each(response, function (key, item) {
            //如果最后的回复是图片将图片资源替换成文字
            var lastWord = (item.lastReply.content_type === 2) ? '图片' : item.lastReply.content;
            _html += '<div class="box-comment" data-uid = ' + item.uid + ' wo_id=' + item.id + '>';
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
    to_id = $(this).attr('data-uid');
    //保存工单的ID
    wo_id = $(this).attr('wo_id');
    //初始化客服与用户的的连接
    $.ajax({
        url: '/server/joinGroup/' + client_id,
        type: "post",
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
        console.log(res);
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
    $('.shade').addClass('hidden');
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
