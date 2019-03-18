var chatRoomHeight, chatRecordHeight;
autoChatRoomHeight();

$(window, ".wrapper").resize(function () {
    autoChatRoomHeight();
});

lock();

function autoChatRoomHeight() {
    var neg = $('.main-header').outerHeight() + $('.main-footer').outerHeight();
    var window_height = $(window).height();
    var sidebar_height = $(".sidebar").height();
    if (window_height >= sidebar_height) {
        chatRoomHeight = window_height - neg - 80;
        $(".nav-tabs-custom, .widget-user-2, .direct-chat").css('min-height', chatRoomHeight);
    } else {
        chatRoomHeight = sidebar_height - 80;
        $(".nav-tabs-custom, .widget-user-2, .direct-chat").css('min-height', chatRoomHeight);
    }

    var editorHeight = $('.editor').height();
    chatRecordHeight = chatRoomHeight - 60 - editorHeight;
    $('.direct-chat-messages').css('min-height', chatRecordHeight);
}

//获取工单列表
function getWorkOrderList(apiUrl) {
    //获取客户列表
    $.get(apiUrl).done(function (response) {
        var _html = '';
        $.each(response, function (key, item) {
            _html += '<div class="box-comment" data-uid = ' + item.from_id + ' wo_id=' + item.id + '>';
            _html += '<img class="img-circle img-sm" src="' + item.from_avatar + '"><div class="comment-text">';
            _html += '<span class="username">' + item.from_name + '';
            _html += item.unread > 0 ? '<span class="pull-right badge bg-red">' + item.unread + '</span>' : '';
            _html += '</span>It is a long established fact</div></div>';
        });

        $('.box-comments').html(_html);
    });
}

//点击客户进入聊天窗口
function intoChatRoom() {
    //获取客户uid
    to_id = $(this).attr('data-uid');
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
    showChatRecord(to_id);
}

/**
 * 获取聊天记录
 * @param uid 客户的uid
 */
function showChatRecord(uid) {
    var param = {'uid': uid, 'from': 'kf', '_token': token};
    $.post('/chatLog/get', param, function (response) {
        var _html = '';
        $.each(response, function (index, item) {
            //如果是图片的话,构建一个图片标签
            if (parseInt(item.content_type) === 2) {
                item.content = '<img src="' + item.content + '" style="width: 200px;height: auto">';
            }
            //如果消息来源于客户那么消息显示在聊天窗口右侧
            var point = item.from_id == uid ? 'right' : 'left';

            _html += msgFactory(item.content, item.from_avatar, point);
        });

        $(".direct-chat-messages").html(_html);
        //聊天框默认最底部
        positionBottom();
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
        var _html = msgFactory(image, from_avatar, 'left');
        $(".direct-chat-messages").append(_html);
        //聊天消息显示框定位到最底部
        positionBottom();
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
    var elem = msgFactory(text, from_avatar, 'left');
    $('.direct-chat-messages').append(elem);
    positionBottom();
    storeMessage(text, 1);
}

//发送表情消息处理
function sendFaceHandler() {
    var faceText = $(this).attr('labFace');
    var labFace = $(this).parent().html();
    var elem = msgFactory(labFace, from_avatar, 'left');
    $('.direct-chat-messages').append(elem);
    positionBottom();
    storeMessage(labFace, 3);
}

/**
 * 为一条消息构建dom标签
 * @param content 消息的内容
 * @param avatar  发送消息人的头像
 * @param point   消息显示在消息窗口的左侧还是右侧
 */
function msgFactory(content, avatar, point) {
    point = (point === 'right') ? 'right' : '';
    var _html = '';
    _html += '<div class="direct-chat-msg ' + point + '"><div class="direct-chat-info clearfix">';
    _html += '<span class="direct-chat-name ">Alexander Pierce</span>';
    _html += '<span class="direct-chat-timestamp">23 Jan 2:00 pm</span></div>';
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
        'from_id': from_id,
        'from_name': from_name,
        'from_avatar': from_avatar,
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
function positionBottom() {
    $(document).ready(function () {
        $(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);
    });
}

//给编辑区加上遮罩使其不能编辑
function lock() {
    var parentHeight = $('.shade').parent().height() + 15;
    $('.shade').css('min-height', parentHeight);
    $('.shade').removeClass('hidden');
}

//去除编辑区的遮罩使其可以编辑
function unLock() {
    $('.shade').addClass('hidden');
}


function replace_em(str) {
    console.log('call fun');
    str = str.replace(/</g, '<；');
    str = str.replace(/>/g, '>；');
    str = str.replace(/ /g, '<；br/>；');
    str = str.replace(/\[em_([0-9]*)\]/g, '<img src="face/$1.gif" border="0" />');
    return str;
}
