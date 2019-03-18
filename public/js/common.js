/**
 * Created by BL on 2019/3/8.
 */
screenFuc();
function screenFuc() {
    var topHeight = $(".chatBox-head").innerHeight();//聊天头部高度
    //屏幕小于768px时候,布局change
    var winWidth = $(window).innerWidth();
    if (winWidth <= 768) {
        var totalHeight = $(window).height(); //页面整体高度
        $(".chatBox-info").css("height", totalHeight - topHeight);
        var infoHeight = $(".chatBox-info").innerHeight();//聊天头部以下高度
        //中间内容高度
        $(".chatBox-content").css("height", infoHeight - 46);
        $(".chatBox-content-demo").css("height", infoHeight - 46);

        $(".chatBox-list").css("height", totalHeight - topHeight);
        $(".chatBox-kuang").css("height", totalHeight - topHeight);
        $(".div-textarea").css("width", winWidth - 106);
    } else {
        $(".chatBox-info").css("height", 495);
        $(".chatBox-content").css("height", 448);
        $(".chatBox-content-demo").css("height", 448);
        $(".chatBox-list").css("height", 495);
        $(".chatBox-kuang").css("height", 495);
        $(".div-textarea").css("width", 260);
    }
}
(window.onresize = function () {
    screenFuc();
})();

//未读信息数量为空时
var totalNum = $(".chat-message-num").html();
if (totalNum === "") {
    $(".chat-message-num").css("padding", 0);
}
$(".message-num").each(function () {
    var wdNum = $(this).html();
    if (wdNum === "") {
        $(this).css("padding", 0);
    }
});


//打开/关闭聊天框
$(".chatBtn").click(function () {
    $(".chatBox").toggle(10);
});

$(".chat-close").click(function () {
    $(".chatBox").toggle(10);
});

//返回列表
$(".chat-return").click(function () {
    console.log('return');
});

//发送表情
$("#chat-biaoqing").click(function () {
    $(".biaoqing-photo").toggle();
});
$(document).click(function () {
    $(".biaoqing-photo").css("display", "none");
});
//
$("#chat-biaoqing").click(function (event) {
    event.stopPropagation();//阻止事件
});

//滚动条自动定位到最底端
function positionBottom() {
    $(document).ready(function () {
        $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
    });
}

//发送文本消息
function sendTextHandler() {
    var text = $(".div-textarea").html().replace(/[\n\r]/g, '<br>');
    if (text !== "") {
        //构建消息标签然后插入dom中
        var _html = makeChatMessage(text, 1, from_avatar, 'left');
        $(".chatBox-content-demo").append(_html);
        //发送后清空输入框
        $(".div-textarea").html("");
        //聊天框默认最底部
        positionBottom();
        //保存消息
        storeMessage(text, 1);
    }
}

//发送表情消息
function sendEmojiHandler() {
    var emoji = $(this).parent().html();
    //构建消息标签然后插入dom中
    var _html = makeChatMessage(emoji, 3, from_avatar, 'left');
    $(".chatBox-content-demo").append(_html);
    //发送后关闭表情框
    $(".biaoqing-photo").toggle();
    //聊天框默认最底部
    positionBottom();
    //保存消息
    storeMessage(emoji, 3);
}

//发送图片消息
function sendImageHandler(e) {
    var image = e.files[0];
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
        //构建消息标签然后插入dom中
        var dom = makeChatMessage(res.url, 2, from_avatar, 'left');
        $(".chatBox-content-demo").append(dom);
        //聊天框默认最底部
        positionBottom();
        //保存消息
        storeMessage(res.url, 2);

    }).fail(function (res) {
        console.log(res.responseJSON.message);
    });
}

/**
 * 存储消息类容
 * @param content 消息的类容
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

    $.post('/server/send/' + client_id, data, function (res) {
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


/**
 * 获取聊天记录
 * @param uid 客户的uid
 * @param from 请求来源于客服人员还是用户
 */
function showChatRecord(uid, from) {
    $.post('/chatLog/get', {'uid': uid, 'from': from, '_token': token}, function (response) {
        var _html = '';
        $.each(response, function (index, item) {
            //如果消息来源客户那么消息显示在聊天窗口右侧
            var point = item.from_id === uid ? 'left' : 'right';
            _html += makeChatMessage(item.content, item.content_type, item.from_avatar, point);
        });

        $(".chatBox-content-demo").append(_html);
        //聊天框默认最底部
        positionBottom();
    })
}


/**
 * 为一条消息构建dom
 * @param content 消息的内容
 * @param content_type 消息的类型 1是文字消息 2是图片消息 3是表情消息
 * @param avatar      消息发送者的头像
 * @param point       消息显示在聊天窗口的左侧还是右侧
 * @returns {string}
 */
function makeChatMessage(content, content_type, avatar, point) {
    var time = (new Date()).toLocaleString().split('/').join('-');

    if (parseInt(content_type) === 2) {
        content = '<img src="' + content + '">';
    }

    if (point === 'right') {
        return '<div class="clearfloat"> <div class="author-name"> <small class="chat-date">' + time + '</small></div>' +
            '<div class="right"><div class="chat-message">' + content + '</div>' +
            '<div class="chat-avatars"><img src="' + avatar + '" alt="头像"></div></div></div>';

    } else {
        return '<div class="clearfloat"><div class="author-name"><small class="chat-date">' + time + '</small></div>' +
            '<div class="left"><div class="chat-avatars"><img src="' + avatar + '" alt="头像"></div>' +
            '<div class="chat-message">' + content + '</div></div></div>';
    }
}