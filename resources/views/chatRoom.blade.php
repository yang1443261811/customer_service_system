@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="/css/admin-chat.css">
    <style>
        body {
            margin: 0;
            color: rgba(0, 0, 0, .65);
            font-size: 14px;
            font-family: -apple-system, BlinkMacSystemFont, Segoe UI, PingFang SC, Hiragino Sans GB, Microsoft YaHei, Helvetica Neue, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
            font-variant: tabular-nums;
            line-height: 1.5;
            background-color: #fff;
            font-feature-settings: "tnum";
        }

        .user-info span {
            display: inline-block;
            padding: 5px 0;
        }

        .user-info li {
            padding-left: 0;
            border: 0;
        }

        .user-info li span:first-child {
            text-align: right;
            width: 60px;
            font-weight: 600;
        }

        .comment-text img {
            width: 20px !important;
            height: 20px !important;
        }

        .box-comments {
            overflow: auto !important;
        }
    </style>
@endsection


@section('content')
    <!-- Your Page Content Here -->
    <div class="row no-padding" style="height: 100%;">
        <div class="col-md-3" style="padding-bottom: 0;margin: 0;overflow: auto;height: 100%">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user-2" style="margin-bottom:0;height: 95%;">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-default no-padding">
                    <ul class="nav row no-margin no-padding users-status-list">
                        <li class="active col-sm-6 no-padding" type="myself"><a class="no-margin">当前对话</a></li>
                        <li class="col-sm-6 no-padding" type="getNew"><a class="no-margin">排队列表</a></li>
                    </ul>
                </div>
                <div class="box-footer box-comments" style="overflow: auto;height: 94%">
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
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        <div class="col-md-6" style="padding: 0;margin: 0;height: 95%;">
            <div class="shade"></div>
            <!-- DIRECT CHAT PRIMARY -->
            <div class="box box-primary direct-chat direct-chat-primary" style="margin-bottom:0;height: 100%">
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
                <div class="box-body" style="height: 70%;">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages" style="height:100%">

                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer editor" style="margin: 0;padding-top: 0;height: 20%;">
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
                            <button type="submit" class="btn btn-default send">发送</button>
                        </div>
                    </form>
                </div>
                <!-- /.box-footer-->
            </div>
            <!--/.direct-chat -->
        </div>
        <div class="col-md-3" style="padding-bottom: 0;height: 95%;position: relative;">
            <div class="screen"></div>
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom" style="margin-bottom:0;height: 100%">
                <ul class="nav nav-tabs">
                    <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="false">用户信息</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">黑名单</a></li>
                    <li class="active"><a href="#tab_3" data-toggle="tab" aria-expanded="false">快捷回复</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content" style="height: 90%;">
                    <div class="tab-pane" id="tab_1" style="height: 100%;">
                        <ul class="list-group user-info">
                            <li class="list-group-item">
                                <span><i class="fa fa-fw fa-user"></i>&#12288;ID&nbsp;:</span>
                                <span class="user_id"></span>
                            </li>
                            <li class="list-group-item">
                                <span><i class="fa fa-fw fa-street-view"></i>在线&nbsp;:</span>
                                <span></span>
                            </li>
                            <li class="list-group-item">
                                <span><i class="fa fa-fw fa-map-marker"></i>位置&nbsp;:</span>
                                <span class="address"></span>
                            </li>
                        </ul>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2" style="height: 100%;">
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
                    <div class="tab-pane active fastReply-box" id="tab_3" style="height: 100%;">
                        <span class='addReply label bg-green' title="新增"><i class="fa fa-fw fa-plus"></i></span>
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
    <script src="https://cdn.staticfile.org/layer/2.3/layer.js"></script>
    <script type="text/javascript" src="/js/jquery.qqFace.js"></script>
    <script type="text/javascript" src="/js/chat.js"></script>
    <script>
        window.wo_id = '';//工单ID
        window.uid = '{{auth()->id()}}';//客服的ID
        window.name = '{{auth()->user()->name}}';//客服的名称
        window.avatar = '/img/icon03.png';
        window.to_id = '';//客户的ID
        window.to_name = '';//客户的名称
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
            switch (response.message_type) {
                case 'new_message' :
                    new_message_process(data);
                    break;
                case 'connect_success' :
                    connect_success_process(response.client_id);
                    break;
                default :
                    console.log('未知的消息类型');
            }
        };

        var current_page, total_page;
        //新增快捷回复的弹窗
        $('.addReply').click(popupForm);
        //创建快捷回复
        $(document).on('click', '.save_reply', createFastReply);
        //获取快捷回复列表
        getFastReply();
        //删除快捷回复
        $('.fastReply-box').on('click', '.fa-remove', removeFastReply);
        //发送快捷回复
        $('.fastReply-box').on('click', '.send-fast-reply', sendFastReply);
        //发送文字消息
        $('.send').click(sendTextHandler);
        //发送表情消息
        $('.editor').on('click', '.labFace', sendFaceHandler);
        //发送图片消息
        $('.upload').change(sendImageHandler);
        //点击客户列表进入聊天窗口,并获取聊天记录
        $('.box-comments').on('click', '.box-comment', intoChatRoom);
        //聊天记录上拉加载更多
        $('.direct-chat-messages').scroll(loadMore);
        //获取工单列表
        getWorkOrderList('/workOrder/myself');
        //获取当前对话或者排队列表
        $('.users-status-list li').click(function () {
            if (!$(this).hasClass('active')) {
                //选中效果
                $('.users-status-list li').removeClass('active');
                $(this).addClass('active');
                var action = $(this).attr('type');
                var apiUrl = '/workOrder/' + action;
                getWorkOrderList(apiUrl);
            }
        });
        //初始化表情插件
        $('.face').qqFace({
            id: 'facebox',
            assign: 'text_in',
            path: '/img/arclist/'	//表情存放的路径
        });
        //取消弹窗
        $(document).on('click', '.cancelPopup', function () {
            layer.closeAll();
        });
    </script>
@endsection