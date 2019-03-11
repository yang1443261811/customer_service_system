<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" type="text/css" href="font_Icon/iconfont.css">
    <link rel="stylesheet" type="text/css" href="css/chat.css">

</head>
<body>

<div class="chatContainer">
    <div class="chatBtn">
        <i class="iconfont icon-xiaoxi1"></i>
    </div>
    <div class="chat-message-num">10</div>
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
                    <div><img src="img/icon01.png" alt="头像"/></div>
                    <div class="chat-name">
                        <p>蓝莓酒</p>
                    </div>
                    <div class="message-num"></div>
                </div>
                <div class="chat-list-people">
                    <div><img src="img/icon03.png" alt="头像"/></div>
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
    window.uid = '{{auth()->id()}}';
    window.name = '{{auth()->user()->name}}';
    window.avatar = '/img/icon03.png';
    window.to_id = '';
    window.to_name = '';
    window.token = '{{csrf_token()}}';

    //    ws = new WebSocket("ws://" + document.domain + ":2346");
    window.ws = new WebSocket("ws://" + "127.0.0.1:8282");

    ws.onopen = function (e) {
        //如果连接成功执行初始化
        if (e.target.readyState === 1) {
            var text = {'message_type': 'init', 'data': {'uid': uid}};
            ws.send(JSON.stringify(text));
        }
        console.log(e.target.readyState);
    };

    ws.onmessage = function (e) {
        var response = JSON.parse(e.data);

        //如果有新消息就追加到dom中展示出来
        if (response.message_type === 'chatMessage') {
            //保存消息来源用户的信息,回复消息时会用到
            to_id = response.data.id;
            to_name = response.data.name;
            var dom = makeChatMessage(response.data.content, response.data.avatar, 'left');
            $(".chatBox-content-demo").append(dom);

            //聊天框默认最底部
            $(document).ready(function () {
                $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
            });

            console.log(response.data)
        }
    };

    $.get('/customer/lists').done(function (response) {
        var dom = '';
        $.each(response, function (key, item) {
            dom += ' <div class="chat-list-people" data-uid = ' + item.uid + '><div><img src="' + item.avatar + '" alt="头像"/></div>' +
                '<div class="chat-name"><p>' + item.name + '</p></div>' +
                '<div class="message-num">10</div>' +
                '</div>';
        });

        $('.chatBox-list').append(dom);
        console.log(response[0])
    });

    /**
     * 通过websocket推送消息到服务端
     *
     * @param string word 消息内容
     */
    function sendMessage(word) {
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
                'content': word
            }
        };

        ws.send(JSON.stringify(msg));
        console.log('send success');
    }

    //进聊天页面
    $('body').on('click', '.chat-list-people', function () {
        to_id = $(this).attr('data-uid');
        to_name = $(this).find('.chat-name p').html();

        showChatRecord(to_id);

        var n = $(this).index();

        $(".chatBox-head-one").toggle();
        $(".chatBox-head-two").toggle();
        $(".chatBox-list").fadeToggle();
        $(".chatBox-kuang").fadeToggle();

        //传名字
        $(".ChatInfoName").text(to_name);
        //传头像
        $(".ChatInfoHead>img").attr("src", $(this).find('img').attr("src"));

        //聊天框默认最底部
        $(document).ready(function () {
            $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
        });
    });

    function showChatRecord(uid) {
        $.get('/chatLog/' + uid + '/get').done(function (response) {
            var dom = '';
            $.each(response, function (index, item) {
                //如果消息来源客户那么消息显示在聊天窗口右侧
                var point = item.from_id === to_id ? 'left' : 'right';
                dom += makeChatMessage(item.content, item.from_avatar, point);
            });

            $(".chatBox-content-demo").append(dom);

            //聊天框默认最底部
            $(document).ready(function () {
                $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
            });
        });
    }

    //返回列表
    $(".chat-return").click(function () {
        $(".chatBox-head-one").toggle(1);
        $(".chatBox-head-two").toggle(1);
        $(".chatBox-list").fadeToggle(1);
        $(".chatBox-kuang").fadeToggle(1);
    });

    //发送信息
    $("#chat-fasong").click(function () {
        var content = $(".div-textarea").html().replace(/[\n\r]/g, '<br>');
        if (content !== "") {
            var dom = makeChatMessage(content, avatar, 'right');
            $(".chatBox-content-demo").append(dom);

            //发送后清空输入框
            $(".div-textarea").html("");
            //聊天框默认最底部
            $(document).ready(function () {
                $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
            });

            sendMessage(content);
        }
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

    $(".emoji-picker-image").each(function () {
        $(this).click(function () {
            var bq = $(this).parent().html();
            console.log(bq);
            var dom = makeChatMessage(bq, avatar, 'right');
            $(".chatBox-content-demo").append(dom);
            //发送后关闭表情框
            $(".biaoqing-photo").toggle();
            //聊天框默认最底部
            $(document).ready(function () {
                $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
            });
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
                var dom = makeChatMessage('<img src="' + res + '">', avatar, 'right');
                $(".chatBox-content-demo").append(dom);

                //聊天框默认最底部
                $(document).ready(function () {
                    $("#chatBox-content-demo").scrollTop($("#chatBox-content-demo")[0].scrollHeight);
                });

                //将消息推送到服务端;
                sendMessage(res);
            })
            .fail(function (res) {
                console.log(res.responseJSON.message);
            });
    }

    /**
     * 为一条消息构建dom
     *
     * @param string word 消息的内容
     * @param avatar      消息发送者的头像
     * @param point       消息显示在聊天窗口的左侧还是右侧
     * @returns {string}
     */
    function makeChatMessage(word, avatar, point) {
        var time = (new Date()).toLocaleString().split('/').join('-');

        if (point === 'right') {
            return '<div class="clearfloat"> <div class="author-name"> <small class="chat-date">' + time + '</small></div>' +
                '<div class="right"><div class="chat-message">' + word + '</div>' +
                '<div class="chat-avatars"><img src="' + avatar + '" alt="头像"></div></div></div>';

        } else {
            return '<div class="clearfloat"><div class="author-name"><small class="chat-date">' + time + '</small></div>' +
                '<div class="left"><div class="chat-avatars"><img src="' + avatar + '" alt="头像"></div>' +
                '<div class="chat-message">' + word + '</div></div></div>';
        }
    }


</script>

</body>
</html>
