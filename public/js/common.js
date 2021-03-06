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
    var _html = makeChatMessage(text, 1, avatar, 'left');
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
  var _html = makeChatMessage(emoji, 3, avatar, 'left');
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
    var dom = makeChatMessage(res.url, 2, avatar, 'left');
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
  //如果用户还没有创建工单那么就创建一个新的工单
  if (window.state === 0) {
    createDialog();
  }
  
  var data = {
    'chat_id': chat_id,
    'from_id': uid,
    'from_name': name,
    'from_avatar': avatar,
    'kf_id': kf_id,
    'content': content,
    'type': contentType,
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
 * 获取工单
 * @param uid 客户的uid
 */
function getDialog(uid) {
  $.get('/chatLog/get/' + uid, function (response) {
    //如果没有获取到直接返回
    if (!response.chat_id) {
      return false;
    }
    
    window.chat_id = response.chat_id;
    window.kf_id = response.kf_id;
    window.state = 1;
    
    //将工单的聊天记录显示出来
    var _html = '';
    $.each(response.chatRecord, function (index, item) {
      //如果消息来源客户那么消息显示在聊天窗口右侧
      var point = item.from_id === uid ? 'left' : 'right';
      _html += makeChatMessage(item.content, item.type, item.from_avatar, point);
    });
    
    $(".chatBox-content-demo").append(_html);
    //聊天框默认最底部
    positionBottom();
  })
}

//创建新的会话
function createDialog() {
  $.ajax({
    url: '/dialog/create',
    type: 'POST',
    async: false,
    data: {'uid': uid, 'name': name, 'avatar': avatar, '_token': token}
  }).done(function (res) {
    if (res.success) {
      window.chat_id = res.chat_id;
      window.state = 1;
    } else {
      console.log('工单创建失败');
    }
    
  }).fail(function (res) {
    console.log(res.responseJSON.message);
  });
  
}


/**
 * 为一条消息构建dom
 * @param content 消息的内容
 * @param type 消息的类型 1是文字消息 2是图片消息 3是表情消息
 * @param avatar      消息发送者的头像
 * @param point       消息显示在聊天窗口的左侧还是右侧
 * @returns {string}
 */
function makeChatMessage(content, type, avatar, point) {
  var time = (new Date()).toLocaleString().split('/').join('-');
  
  if (parseInt(type) === 2) {
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

function new_message_process(data) {
  //保存消息来源用户的信息,回复消息时会用到
  kf_id = data.id;
  kf_name = data.name;
  //构建消息标签然后插入dom中
  var dom = makeChatMessage(data.content, data.type, data.avatar, 'right');
  $(".chatBox-content-demo").append(dom);
  //聊天框默认最底部
  positionBottom();
  //将接收到的消息标记为已读
  $.get('chatLog/haveRead/' + data.chat_id);
}

function connect_success_process(client_id) {
  window.client_id = client_id;
  var api = '/server/join/' + uid + '/' + client_id;
  $.get(api, function (res) {
    //nothing to do
  });
}