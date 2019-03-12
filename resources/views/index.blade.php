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
    <div class="chat-message-num">{{$unread > 0 ? $unread : ''}}</div>
    <div class="chatBox" ref="chatBox">
        <div class="chatBox-head">
            <div class="chatBox-head-two" style="display: block;">
                <div class="chat-return">返回</div>
                <div class="chat-people">
                    <div class="ChatInfoHead">
                        <img src="{{$avatar}}" alt="头像">
                    </div>
                    <div class="ChatInfoName">{{$name}}</div>
                </div>
                <div class="chat-close">关闭</div>
            </div>
        </div>
        <div class="chatBox-info">
            <div class="chatBox-kuang" ref="chatBoxkuang" style="display: block">
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
    window.uid = '{{$uid}}';
    window.name = '{{$name}}';
    window.avatar = '{{$avatar}}';
    window.to_id = '';
    window.to_name = '';
    window.group_id = '{{$uid}}';
    window.client_id = '';
    window.token = '{{csrf_token()}}';

    //展示聊天记录
    showChatRecord(uid, 'user');

    //    ws = new WebSocket("ws://" + document.domain + ":2346");
    window.ws = new WebSocket("ws://" + "127.0.0.1:8282");

    ws.onopen = function (e) {
        //如果连接成功执行初始化
        if (e.target.readyState === 1) {
            console.log('socket连接成功');
        }
    };

    ws.onmessage = function (e) {
        var response = JSON.parse(e.data);
        var data = response.data;
        //如果有新消息就追加到dom中展示出来
        if (response.message_type === 'chatMessage') {
            //保存消息来源用户的信息,回复消息时会用到
            to_id = data.id;
            to_name = data.name;
            //构建消息标签然后插入dom中
            var dom = makeChatMessage(data.content, data.content_type, data.avatar, 'right');
            $(".chatBox-content-demo").append(dom);
            //聊天框默认最底部
            positionBottom();
            //将接收到的消息标记为已读
            $.get('chatLog/haveRead/' + data.message_id).done(function (res) {
                console.log(res);
            })
        }

        if (response.message_type === 'connectSuccess') {
            window.client_id = response.client_id;
            $.post('/server/joinGroup/' + client_id, {'group_id': uid, '_token': token})
                .done(function (res) {
                    console.log(res);
                })
        }
    };

    //发送文字信息
    $("#chat-fasong").click(sendTextHandler);

    //发送表情
    $(".emoji-picker-image").click(sendEmojiHandler);

</script>

</body>
</html>
