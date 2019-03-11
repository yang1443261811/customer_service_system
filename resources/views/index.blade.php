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
    <div class="chat-message-num">10</div>
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
                            <input type="file" onchange="selectImg(this)" accept="image/jpg,image/jpeg,image/png"
                                   name="file" id="inputImage" class="hidden">
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
    window.token = '{{csrf_token()}}';

    //展示聊天记录
    showChatRecord(uid);

    //    ws = new WebSocket("ws://" + document.domain + ":2346");
    window.ws = new WebSocket("ws://" + "127.0.0.1:8282");

    ws.onopen = function (e) {
        //如果连接成功执行初始化
        if (e.target.readyState === 1) {
            ws.send(JSON.stringify({'message_type': 'checkIn', 'data': {'uid': uid, 'group_id': uid}}));
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
        }
    };

    //发送文字信息
    $("#chat-fasong").click(function () {
        var content = $(".div-textarea").html().replace(/[\n\r]/g, '<br>');
        if (content === "") {
            return false;
        }

        //清空输入框
        $(".div-textarea").html("");
        //构建消息标签然后插入dom中
        var dom = makeChatMessage(content, 1, avatar, 'left');
        $(".chatBox-content-demo").append(dom);
        //聊天框默认最底部
        positionBottom();
        //通过websocket将消息推送到服务端
        pushMessage(content, 1);
        //保存消息
        storeMessage(content, 1);
    });

    //发送表情
    $("#chat-biaoqing").click(function () {
        $(".biaoqing-photo").toggle();
    });

    $(document).click(function () {
        $(".biaoqing-photo").css("display", "none");
    });

    $("#chat-biaoqing").click(function (event) {
        event.stopPropagation();//阻止事件
    });
    //发送表情
    $(".emoji-picker-image").each(function () {
        $(this).click(function () {
            var bq = $(this).parent().html();
            //构建消息标签然后插入dom中
            var dom = makeChatMessage(bq, 3, avatar, 'left');
            $(".chatBox-content-demo").append(dom);
            //发送后关闭表情框
            $(".biaoqing-photo").toggle();
            //聊天框默认最底部
            positionBottom();
            //将消息内容推送到服务端
            pushMessage(bq, 3);
            //保存消息
            storeMessage(bq, 3);
        })
    });

    //发送图片
    function selectImg(e) {
        if (!e.files || !e.files[0]) {
            return;
        }

        var image = e.files[0];
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
        })
            .done(function (res) {
                //构建消息标签然后插入dom中
                var dom = makeChatMessage(res.url, 2, avatar, 'left');
                $(".chatBox-content-demo").append(dom);
                //聊天框默认最底部
                positionBottom();
                //将消息推送到服务端;
                pushMessage(res.url, 2);
                //保存消息
                storeMessage(res.url, 2);

            })
            .fail(function (res) {
                console.log(res.responseJSON.message);
            });
    }

    /**
     * 通过websocket推送消息到服务端
     * @param int contentType 消息类型 1是文字消息 2是图片消息 3是表情消息
     * @param string word 消息内容
     */
    function pushMessage(word, contentType) {
        //socket连接成功才能发送消息
        if (ws.readyState !== 1) {
            return false;
        }

        var msg = {
            'message_type': 'chatMessage',
            'data': {
                'from_id': uid,
                'from_name': name,
                'from_avatar': avatar,
                'to_id': to_id,
                'to_name': to_name,
                'content': word,
                'content_type': contentType
            }
        };

        ws.send(JSON.stringify(msg));
        console.log('send success');
    }

    /**
     * 保存消息类容
     * @param string content 消息的类容
     * @param int contentType 消息的类型 1是文字消息 2是图片消息 3是表情消息
     */
    function storeMessage(content, contentType) {
        var data = {
            'from_id': uid,
            'from_name': name,
            'from_avatar': avatar,
            'to_id': to_id,
            'to_name': to_name,
            'content': content,
            'content_type': contentType,
            '_token': token
        };

        $.post('/chatLog/store', data, function (res) {
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

    //聊天框默认定位到最底部
    function positionBottom() {
        $(document).ready(function () {
            $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
        });
    }

    /**
     * 展示聊天记录
     * @param string word 消息内容
     */
    function showChatRecord(uid) {
        $.get('/chatLog/' + uid + '/get')
            .done(function (response) {
                var dom = '';
                //循环构建消息标签然后插入dom中
                $.each(response, function (index, item) {
                    //如果消息来源客户那么消息显示在聊天窗口右侧
                    var point = item.from_id === uid ? 'left' : 'right';
                    dom += makeChatMessage(item.content, item.content_type, item.from_avatar, point);
                });

                //将消息插入dom中
                $(".chatBox-content-demo").append(dom);
                //聊天框默认最底部
                positionBottom();
            });
    }

    /**
     * 为一条消息构建dom
     * @param string content 消息的内容
     * @param string content_type 消息的类型 1是文字消息 2是图片消息 3是表情消息
     * @param avatar      消息发送者的头像
     * @param point       消息显示在聊天窗口的左侧还是右侧
     * @returns {string}
     */
    function makeChatMessage(content, content_type, avatar, point) {
        var time = (new Date()).toLocaleString().split('/').join('-');
        if (content_type === 2) {
            content = '<img src="' + content + '">';
        } else if (content_type === 3) {

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

</script>

</body>
</html>
