<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="/font_Icon/iconfont.css">
    <link rel="stylesheet" type="text/css" href="/css/chat.css">
    <style>
        .labFace {
            cursor: pointer;
        }
    </style>
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
                        <button id="chat-biaoqing" class="btn-default-styles face">
                            <i class="iconfont icon-biaoqing"></i>
                        </button>
                        <label id="chat-tuxiang" title="发送图片" for="inputImage" class="btn-default-styles">
                            <input type="file" onchange="sendImageHandler(this)" accept="image/jpg,image/jpeg,image/png"
                                   name="file" id="inputImage" class="hidden">
                            <i class="iconfont icon-tuxiang"></i>
                        </label>
                        <input type="hidden" id="face-box">
                        <button id="chat-fasong" class="btn-default-styles"><i class="iconfont icon-fasong"></i>
                        </button>
                    </div>
                    <div class="biaoqing-photo">
                        <ul>
                            <li><img src="/img/arclist/1.gif" iconText="[em_1]" class="labFace"></li>
                            <li><img src="/img/arclist/2.gif" iconText="[em_2]" class="labFace"></li>
                            <li><img src="/img/arclist/3.gif" iconText="[em_3]" class="labFace"></li>
                            <li><img src="/img/arclist/4.gif" iconText="[em_4]" class="labFace"></li>
                            <li><img src="/img/arclist/5.gif" iconText="[em_5]" class="labFace"></li>
                            <li><img src="/img/arclist/6.gif" iconText="[em_6]" class="labFace"></li>
                            <li><img src="/img/arclist/7.gif" iconText="[em_7]" class="labFace"></li>
                            <li><img src="/img/arclist/8.gif" iconText="[em_8]" class="labFace"></li>
                            <li><img src="/img/arclist/9.gif" iconText="[em_9]" class="labFace"></li>
                            <li><img src="/img/arclist/10.gif" iconText="[em_10]" class="labFace"></li>
                            <li><img src="/img/arclist/11.gif" iconText="[em_11]" class="labFace"></li>
                            <li><img src="/img/arclist/12.gif" iconText="[em_12]" class="labFace"></li>
                            <li><img src="/img/arclist/13.gif" iconText="[em_13]" class="labFace"></li>
                            <li><img src="/img/arclist/14.gif" iconText="[em_14]" class="labFace"></li>
                            <li><img src="/img/arclist/15.gif" iconText="[em_15]" class="labFace"></li>
                            <li><img src="/img/arclist/16.gif" iconText="[em_16]" class="labFace"></li>
                            <li><img src="/img/arclist/17.gif" iconText="[em_17]" class="labFace"></li>
                            <li><img src="/img/arclist/18.gif" iconText="[em_18]" class="labFace"></li>
                            <li><img src="/img/arclist/19.gif" iconText="[em_19]" class="labFace"></li>
                            <li><img src="/img/arclist/20.gif" iconText="[em_20]" class="labFace"></li>
                            <li><img src="/img/arclist/21.gif" iconText="[em_21]" class="labFace"></li>
                            <li><img src="/img/arclist/22.gif" iconText="[em_22]" class="labFace"></li>
                            <li><img src="/img/arclist/23.gif" iconText="[em_23]" class="labFace"></li>
                            <li><img src="/img/arclist/24.gif" iconText="[em_24]" class="labFace"></li>
                            <li><img src="/img/arclist/25.gif" iconText="[em_25]" class="labFace"></li>
                            <li><img src="/img/arclist/26.gif" iconText="[em_26]" class="labFace"></li>
                            <li><img src="/img/arclist/27.gif" iconText="[em_27]" class="labFace"></li>
                            <li><img src="/img/arclist/28.gif" iconText="[em_28]" class="labFace"></li>
                            <li><img src="/img/arclist/29.gif" iconText="[em_29]" class="labFace"></li>
                            <li><img src="/img/arclist/30.gif" iconText="[em_30]" class="labFace"></li>
                            <li><img src="/img/arclist/31.gif" iconText="[em_31]" class="labFace"></li>
                            <li><img src="/img/arclist/32.gif" iconText="[em_32]" class="labFace"></li>
                            <li><img src="/img/arclist/33.gif" iconText="[em_33]" class="labFace"></li>
                            <li><img src="/img/arclist/34.gif" iconText="[em_34]" class="labFace"></li>
                            <li><img src="/img/arclist/35.gif" iconText="[em_35]" class="labFace"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
<script type="text/javascript" src="/js/jquery.qqFace.js"></script>
<script src="/js/common.js"></script>
<script>
    window.wo_id = '';//工单id
    window.uid = '{{$uid}}';
    window.name = '{{$name}}';
    window.avatar = '{{$avatar}}';
    window.to_id = '';
    window.to_name = '';
    window.group_id = '{{$uid}}';
    window.client_id = '';
    window.token = '{{csrf_token()}}';
    window.hasWorkOrder = false;

    //获取用户的工单,如果没有获取到那么用户发送消息的时候需要为本次会话创建一个新的工单
    getWorkOrder(uid);

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
            $.get('chatLog/clientHaveRead/' + data.wo_id).done(function (res) {
                console.log(res);
            })
        }

        if (response.message_type === 'connectSuccess') {
            window.client_id = response.client_id;
            $.post('/server/joinGroup/' + client_id, {'group_id': group_id, '_token': token})
                .done(function (res) {
                    console.log(res);
                })
        }
    };

    //发送文字信息
    $("#chat-fasong").click(sendTextHandler);

    //发送表情
    $(".labFace").click(sendEmojiHandler);

</script>

</body>
</html>
