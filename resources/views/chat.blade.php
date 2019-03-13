<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" type="text/css" href="/font_Icon/iconfont.css">
    <link rel="stylesheet" type="text/css" href="/css/chat.css">

</head>
<body>

<div class="chatContainer">
    <div class="chatBtn">
        <i class="iconfont icon-xiaoxi1"></i>
    </div>
    {{--<div class="chat-message-num">10</div>--}}
    <div class="chatBox" ref="chatBox">
        <div class="chatBox-head">
            <div class="chatBox-head-one">
                Conversations
                <div class="chat-close" style="margin: 10px 10px 0 0;font-size: 14px">关闭</div>
            </div>
            <div class="chatBox-head-two">
                <div class="chat-return">返回</div>
                <div class="chat-people">
                    <div class="ChatInfoHead">
                        <img src="" alt="头像"/>
                    </div>
                    <div class="ChatInfoName">这是用户的名字，看看名字到底能有多长</div>
                </div>
                <div class="chat-close">关闭</div>
            </div>
        </div>
        <div class="chatBox-info">
            <div class="chatBox-list" ref="chatBoxlist">
                <div class="chat-list-people">
                    <div><img src="/img/icon01.png" alt="头像"/></div>
                    <div class="chat-name">
                        <p>蓝莓酒</p>
                    </div>
                    <div class="message-num"></div>
                </div>
                <div class="chat-list-people">
                    <div><img src="/img/icon03.png" alt="头像"/></div>
                    <div class="chat-name">
                        <p>樱花酒</p>
                    </div>
                    <div class="message-num"></div>
                </div>
            </div>
            <div class="chatBox-kuang" ref="chatBoxkuang">
                <div class="chatBox-content">
                    <div class="chatBox-content-demo" id="chatBox-content-demo">

                    </div>
                </div>
                <div class="chatBox-send">
                    <div class="div-textarea" contenteditable="true"></div>
                    <div>
                        <button id="chat-biaoqing" class="btn-default-styles">
                            <i class="iconfont icon-biaoqing"></i>
                        </button>
                        <label id="chat-tuxiang" title="发送图片" for="inputImage" class="btn-default-styles">
                            <input type="file" onchange="sendImageHandler(this)" accept="image/jpg,image/jpeg,image/png" name="file" id="inputImage" class="hidden">
                            <i class="iconfont icon-tuxiang"></i>
                        </label>
                        <button id="chat-fasong" class="btn-default-styles"><i class="iconfont icon-fasong"></i>
                        </button>
                    </div>
                    <div class="biaoqing-photo">
                        <ul>
                            <li><span class="emoji-picker-image" style="background-position: -9px -18px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -40px -18px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -71px -18px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -102px -18px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -133px -18px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -164px -18px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -9px -52px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -40px -52px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -71px -52px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -102px -52px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -133px -52px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -164px -52px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -9px -86px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -40px -86px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -71px -86px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -102px -86px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -133px -86px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -164px -86px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -9px -120px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -40px -120px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -71px -120px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -102px -120px;"></span>
                            </li>
                            <li><span class="emoji-picker-image" style="background-position: -133px -120px;"></span>
                            </li>
                            <li><span class="emoji-picker-image" style="background-position: -164px -120px;"></span>
                            </li>
                            <li><span class="emoji-picker-image" style="background-position: -9px -154px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -40px -154px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -71px -154px;"></span></li>
                            <li><span class="emoji-picker-image" style="background-position: -102px -154px;"></span>
                            </li>
                            <li><span class="emoji-picker-image" style="background-position: -133px -154px;"></span>
                            </li>
                            <li><span class="emoji-picker-image" style="background-position: -164px -154px;"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
<script src="/js/common.js"></script>
<script>
    //当前用户相关信息
    window.uid = '{{auth()->id()}}';
    window.name = '{{auth()->user()->name}}';
    window.avatar = '/img/icon03.png';
    window.to_id = '';
    window.to_name = '';
    window.client_id = '';
    window.token = '{{csrf_token()}}';

    //    ws = new WebSocket("ws://" + document.domain + ":2346");
    window.ws = new WebSocket("ws://" + "127.0.0.1:8282");

    ws.onopen = function (e) {
        if (e.target.readyState === 1) {
            console.log('连接成功' + e.target.readyState);
        }
    };

    //监听消息
    ws.onmessage = function (e) {
        var response = JSON.parse(e.data);
        var data = response.data;

        //如果有新消息就追加到dom中展示出来
        if (response.message_type === 'chatMessage') {
            //构建消息标签然后插入dom中
            var dom = makeChatMessage(data.content, data.content_type, data.avatar, 'left');
            $(".chatBox-content-demo").append(dom);
            //聊天框默认最底部
            positionBottom();
            //将接收到的消息标记为已读
            $.get('chatLog/haveRead/' + data.message_id).done(function (res) {
                console.log(res);
            })
        }

        //如果socket连接成功保存自己的client_id
        if (response.message_type === 'connectSuccess') {
            window.client_id = response.client_id;
        }
    };

    //获取客户列表
    $.get('/customer/lists').done(function (response) {
        var _html = '';
        $.each(response, function (key, item) {
            _html += ' <div class="chat-list-people" data-uid = ' + item.uid + '><div><img src="' + item.avatar + '" alt="头像"/></div>';
            _html += '<div class="chat-name"><p>' + item.name + '</p></div>';
            _html += item.unread > 0 ? '<div class="message-num">'+item.unread+'</div>' : '';
            _html += '</div>';
        });

        $('.chatBox-list').append(_html);
    });

    //进聊天页面
    $('body').on('click', '.chat-list-people', function () {
        $(".chatBox-head-one").toggle();
        $(".chatBox-head-two").toggle();
        $(".chatBox-list").fadeToggle();
        $(".chatBox-kuang").fadeToggle();
        to_id = $(this).attr('data-uid');
        to_name = $(this).find('.chat-name p').html();
        //初始化客服与用户的的连接
        $.post('/server/joinGroup/' + client_id, {'group_id': to_id, '_token': token})
            .done(function (res) {
                console.log(res);
            });
        //获取聊天记录
        showChatRecord(to_id, 'kf');
        //传名字
        $(".ChatInfoName").text(to_name);
        //传头像
        $(".ChatInfoHead>img").attr("src", $(this).find('img').attr("src"));
        //聊天框默认最底部
        positionBottom();
    });

    //返回列表
    $(".chat-return").click(function () {
        $(".chatBox-head-one").toggle(1);
        $(".chatBox-head-two").toggle(1);
        $(".chatBox-list").fadeToggle(1);
        $(".chatBox-kuang").fadeToggle(1);
    });

    //发送文本消息处理
    $("#chat-fasong").click(sendTextHandler);

    //发送表情消息
    $(".emoji-picker-image").each(function () {
        $(this).click(sendEmojiHandler);
    });
</script>

</body>
</html>