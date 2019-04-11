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

@section('content-header')
    <h1>
        <small>Optional description</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li class="active">对话窗口</li>
    </ol>
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
                        <li class="active col-sm-6 no-padding"><a class="no-margin">当前对话</a></li>
                        <li class="col-sm-6 no-padding"><a class="no-margin">排队列表</a></li>
                    </ul>
                </div>
                <div class="box-footer box-comments" style="overflow: auto;height: 94%">

                </div>
                <div class="box-footer box-comments hidden queue" style="overflow: auto;height: 94%">

                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        <div class="col-md-6" style="padding: 0;margin: 0;height: 95%;">
            <div class="shade"></div>
            <!-- DIRECT CHAT PRIMARY -->
            <div class="box box-primary direct-chat direct-chat-primary" style="margin-bottom:0;height: 100%">
                <div class="box-header with-border">
                    <h3 class="box-title nickname"></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
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
                    <form action="javascript:;" style="height: 80%;">
                        <textarea id="text_in" class="edit-ipt disable form-control" placeholder="编辑信息"></textarea>

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
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">用户信息</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">黑名单</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">快捷回复</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content" style="height: 90%;">
                    <div class="tab-pane active" id="tab_1" style="height: 100%;">
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
                        <div class="finish-box">
                            <button class="finish-btn btn btn-danger btn-sm">处理完成</button>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2" style="height: 100%;">

                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane fastReply-box" id="tab_3" style="height: 100%;">
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
    <script type="text/javascript" src="/js/fastReply.js"></script>
    <script>
        window.kf_id = '{{auth()->id()}}';//客服的ID
        window.kf_name = '{{auth()->user()->name}}';//客服的名称
        window.kf_avatar = '/img/kf.png';
        window.client_id = '';
        window.token = '{{csrf_token()}}';
        window.currentWorkOrder = ''; //当前工单的信息

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

        var chat_log_current_page, chat_log_total_page, users_current_page, users_total_page;
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
        $('.direct-chat-messages').scroll(loadMoreChatLog);
        //用户列表下拉加载更多
        $('.box-comments').scroll(loadMoreUser);
        //获取工单列表
        getWorkOrderList('/workOrder/get/2', 1, function (html) {
            $('.box-comments').eq(0).html(html)
        });
        //工单处理完成
        $('.tab-pane .finish-btn').click(workOrderEnd);
        //获取当前对话或者排队列表
        $('.users-status-list li').click(function () {
            if (!$(this).hasClass('active')) {
                //选中效果
                $('.users-status-list li').removeClass('active');
                $(this).addClass('active');
                var index = $(this).index();
                $('.box-comments').removeClass('hidden');
                $('.box-comments').eq(index - 1).addClass('hidden');
                if (index === 1) {
                    getWorkOrderList('/workOrder/get/1', 1, function (html) {
                        $('.box-comments').eq(1).html(html)
                    });
                }
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