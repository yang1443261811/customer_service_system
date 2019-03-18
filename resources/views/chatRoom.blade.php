@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="/css/admin-chat.css">
@endsection


@section('content')
    <!-- Your Page Content Here -->
    <div class="row no-padding">
        <div class="col-md-3" style="padding-bottom: 0;margin: 0">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user-2" style="margin-bottom:0;">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-default no-padding">
                    <ul class="nav row no-margin no-padding users-status-list">
                        <li class="active col-sm-6 no-padding" type="myself"><a class="no-margin">当前对话</a></li>
                        <li class="col-sm-6 no-padding" type="getNew"><a class="no-margin">排队列表</a></li>
                    </ul>
                </div>
                <div class="box-footer box-comments">
                    <div class="box-comment">
                        <!-- User image -->
                        <img class="img-circle img-sm" src="/img/user1-128x128.jpg" alt="User Image">

                        <div class="comment-text">
                            <span class="username">小明<span class="pull-right badge bg-red">842</span></span>
                            <!-- /.username -->
                            It is a long established fact that a reader will be
                        </div>
                        <!-- /.comment-text -->
                    </div>
                    <div class="box-comment">
                        <!-- User image -->
                        <img class="img-circle img-sm" src="/img/user1-128x128.jpg" alt="User Image">
                        <div class="comment-text">
                            <span class="username">小芳<span class="pull-right badge bg-red">842</span></span>
                            <!-- /.username -->
                            It is a long established fact that a reader will be
                        </div>
                        <!-- /.comment-text -->
                    </div>
                    <div class="box-comment">
                        <!-- User image -->
                        <img class="img-circle" src="/img/user1-128x128.jpg" alt="User Image">
                        <div class="comment-text">
                            <span class="username">小杨<span class="pull-right badge bg-red">842</span></span>
                            <!-- /.username -->
                            It is a long established fact that a reader will be
                        </div>
                        <!-- /.comment-text -->
                    </div>
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        <div class="col-md-6" style="padding: 0;margin: 0;">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="box box-primary direct-chat direct-chat-primary" style="margin-bottom:0;">
                <div class="box-header with-border">
                    <h3 class="box-title">Direct Chat</h3>

                    <div class="box-tools pull-right">
                                <span data-toggle="tooltip" title="" class="badge bg-light-blue"
                                      data-original-title="3 New Messages">3</span>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title=""
                                data-widget="chat-pane-toggle" data-original-title="Contacts">
                            <i class="fa fa-comments"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                    class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">

                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer editor" style="margin: 0;padding-top: 0">
                    <div class="shade hidden"></div>
                    <div class="box-header">
                        <div class="box-tools" style="position: absolute; left:0;margin: 0;">
                            <div id="show"></div>
                            <label for="inputImage" class="image-label">
                                <input type="file" accept="image/jpg,image/jpeg,image/png" name="file" id="inputImage"
                                       class="hidden upload">
                                <i class="fa fa-photo"></i>
                            </label>

                            <button type="button" class="btn btn-box-tool face"><i class="fa  fa-meh-o"></i></button>
                        </div>
                        <h3 class="box-title"></h3>
                    </div>
                    <form action="javascript:;">
                        <textarea id="text_in" class="edit-ipt disable" placeholder="编辑信息"></textarea>

                        <div class="input-group pull-right">
                            <button type="submit" class="btn btn-primary btn-flat send">Send</button>
                        </div>
                    </form>
                </div>
                <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
        </div>
        <div class="col-md-3" style="padding-bottom: 0">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom" style="margin-bottom:0">
                <ul class="nav nav-tabs">
                    <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="false">访客信息</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">黑名单</a></li>
                    <li class="active"><a href="#tab_3" data-toggle="tab" aria-expanded="true">快捷回复</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="tab_1">
                        <b>How to use:</b>

                        <p>Exactly like the original bootstrap tabs except you should use
                            the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
                        A wonderful serenity has taken possession of my entire soul,
                        like these sweet mornings of spring which I enjoy with my whole heart.
                        I am alone, and feel the charm of existence in this spot,
                        which was created for the bliss of souls like mine. I am so happy,
                        my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
                        that I neglect my talents. I should be incapable of drawing a single stroke
                        at the present moment; and yet I feel that I never was a greater artist than now.
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        The European languages are members of the same family. Their separate existence is a
                        myth.
                        For science, music, sport, etc, Europe uses the same vocabulary. The languages only
                        differ
                        in their grammar, their pronunciation and their most common words. Everyone realizes why
                        a
                        new common language would be desirable: one could refuse to pay expensive translators.
                        To
                        achieve this, it would be necessary to have uniform grammar, pronunciation and more
                        common
                        words. If several languages coalesce, the grammar of the resulting language is more
                        simple
                        and regular than that of the individual languages.
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane active" id="tab_3">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                        when an unknown printer took a galley of type and scrambled it to make a type specimen
                        book.
                        It has survived not only five centuries, but also the leap into electronic typesetting,
                        remaining essentially unchanged. It was popularised in the 1960s with the release of
                        Letraset
                        sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                        software
                        like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
    </div>

@endsection


@section('js')
    <script type="text/javascript" src="/js/jquery-browser.js"></script>
    <script type="text/javascript" src="/js/jquery.qqFace.js"></script>
    <script type="text/javascript" src="/js/chat.js"></script>
    <script>
        //当前用户相关信息
        window.ow_id = '';
        window.from_id = '{{auth()->id()}}';
        window.from_name = '{{auth()->user()->name}}';
        window.from_avatar = '/img/icon03.png';
        window.to_id = '';
        window.to_name = '';
        window.client_id = '';
        window.token = '{{csrf_token()}}';

        var socket = new WebSocket("ws://" + "127.0.0.1:8282");

        socket.onopen = function (e) {
            if (e.target.readyState === 1) {
                console.log('连接成功' + e.target.readyState);
            }
        };

        //监听消息
        socket.onmessage = function (e) {
            var response = JSON.parse(e.data);
            var data = response.data;

            //如果有新消息就追加到dom中展示出来
            if (response.message_type === 'chatMessage') {
                //如果是图片消息
                if (parseInt(data.content_type) === 2) {
                    data.content = '<img src="' + data.content + '" style="width: 200px;height: auto">';
                }
                //构建消息标签然后插入dom中
                var _html = msgFactory(data.content, data.avatar, 'right');
                $(".direct-chat-messages").append(_html);

                //聊天框默认最底部
                positionBottom();

                //将接收到的消息标记为已读
                $.get('/chatLog/haveRead/' + data.message_id, function (res) {
                    console.log(res);
                })
            }

            //如果socket连接成功保存自己的client_id
            if (response.message_type === 'connectSuccess') {
                window.client_id = response.client_id;
            }
        };

        //获取客户列表
        getWorkOrderList('/workOrder/myself');
        //获取当前对话或者排队列表
        $('.users-status-list li').click(function () {
            if ($(this).hasClass('active')) {
                return;
            }

            //选中效果
            $('.users-status-list li').removeClass('active');
            $(this).addClass('active');

            var action = $(this).attr('type');
            var apiUrl = '/workOrder/' + action;
            getWorkOrderList(apiUrl);
        });
        //发送文字消息
        $('.send').click(sendTextHandler);
        //发送表情消息
        $('.editor').on('click', '.labFace', sendFaceHandler);
        //发送图片消息
        $('.upload').change(sendImageHandler);
        //点击客户列表进入聊天窗口
        $('.box-comments').on('click', '.box-comment', intoChatRoom);
        //光标定位到编辑区
        $("#text_in").get(0).focus();
        //初始化表情插件
        $('.face').qqFace({
            id: 'facebox',
            assign: 'text_in',
            path: '/img/arclist/'	//表情存放的路径
        });

    </script>
@endsection