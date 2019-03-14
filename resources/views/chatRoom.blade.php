@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="/css/jquery.mCustomScrollbar.min.css"/>
    <link rel="stylesheet" href="/css/jquery.emoji.css"/>
    <style type="text/css">
        .comment-text {
            margin-left: 50px !important;
        }

        .users-status-list .active {
            border-top: 3px solid #3c8dbc;
            border-radius: 3px;
        }

        .users-status-list .active a {
            color: #3c8dbc;
        }

        .users-status-list li {
            text-align: center;
            cursor: pointer;
        }

        .users-status-list li a {
            color: black;
        }

        textarea {
            overflow-y: auto;
            font-weight: normal;
            font-size: 14px;
            overflow-x: hidden;
            word-break: break-all;
            font-style: normal;
            outline: none;
            padding: 5px;
            border: none;
            height: 100px;
            width: 100%
        }

        #facebox {
            padding: 5px;
            background-color: #fff;
            border: 1px solid #bfbfbf;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.176);
        }

        .image-label {
            font-size: 20px;
            cursor: pointer;
            color: #97a0b3;
            vertical-align: text-bottom;
            padding: 0;
            margin: 0
        }

        .face {
            font-size: 20px;
            vertical-align: text-bottom;
            padding: 0;
            margin: 0;
            margin-left: 5px
        }
        textarea::-webkit-input-placeholder{
            color:#e6e6e6;
        }
        textarea::-moz-placeholder{   /* Mozilla Firefox 19+ */
            color:#e6e6e6;
        }
        textarea:-moz-placeholder{    /* Mozilla Firefox 4 to 18 */
            color:#e6e6e6;
        }
        textarea:-ms-input-placeholder{  /* Internet Explorer 10-11 */
            color:#e6e6e6;
        }
    </style>
@endsection


@section('content')
    <!-- Your Page Content Here -->
    <div class="row no-padding">
        <div class="col-md-3" style="padding-bottom: 0">
            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user-2" style="margin-bottom:0">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-default no-padding">
                    <ul class="nav row no-margin no-padding users-status-list">
                        <li class="col-sm-6 no-padding"><a class="no-margin">当前对话</a></li>
                        <li class="active col-sm-6 no-padding"><a class="no-margin">排队列表</a></li>
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
        <div class="col-md-6" style="padding-bottom: 0">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="box box-primary direct-chat direct-chat-primary" style="margin-bottom:0">
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
                        <!-- Message. Default to the left -->
                        <div class="direct-chat-msg">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                            </div>
                            <img class="direct-chat-img" src="/img/user1-128x128.jpg" alt="Message User Image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">Is this template really for free? That's unbelievable!</div>
                        </div>

                        <div class="direct-chat-msg right">
                            <div class="direct-chat-info clearfix">
                                <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                            </div>
                            <img class="direct-chat-img" src="/img/user3-128x128.jpg" alt="Message User Image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">You better believe it!</div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer editor" style="padding-top:0">
                    <div class="box-header">
                        <div class="box-tools" style="position: absolute; left:0;">
                            <div id="show"></div>
                            <label for="inputImage" class="image-label">
                                {{--<input type="file" onchange="sendImageHandler(this)" accept="image/jpg,image/jpeg,image/png" name="file" id="inputImage" class="hidden">--}}
                                <input type="file" accept="image/jpg,image/jpeg,image/png" name="file" id="inputImage" class="hidden upload">
                                <i class="fa fa-photo"></i>
                            </label>

                            <button type="button" class="btn btn-box-tool face"><i class="fa  fa-meh-o"></i></button>
                        </div>
                        <h3 class="box-title"></h3>
                    </div>
                    <form action="javascript:;">
                        <textarea id="text_in" class="edit-ipt" placeholder="编辑信息"></textarea>

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
    <script>
        $(function () {
            window.token = '{{csrf_token()}}';
            var chatRoomHeight, chatRecordHeight;
            autoChatRoomHeight();

            $('.send').click(sendTextHandler);
            $('.editor').on('click', '.labFace', sendFaceHandler);
            $('.upload').change(sendImageHandler);
            $("#text_in").get(0).focus();

            $(window, ".wrapper").resize(function () {
                autoChatRoomHeight();
            });

            $('.face').qqFace({
                id: 'facebox',
                assign: 'text_in',
                path: '/img/arclist/'	//表情存放的路径
            });

            function replace_em(str) {
                str = str.replace(/</g, '<；');
                str = str.replace(/>/g, '>；');
                str = str.replace(/ /g, '<；br/>；');
                str = str.replace(/[em_([0-9]*)]/g, '<img src="face/$1.gif" border="0" />');
                return str;
            }

            function autoChatRoomHeight() {
                var neg = $('.main-header').outerHeight() + $('.main-footer').outerHeight();
                var window_height = $(window).height();
                var sidebar_height = $(".sidebar").height();
                if (window_height >= sidebar_height) {
                    chatRoomHeight = window_height - neg - 80;
                    $(".nav-tabs-custom, .widget-user-2, .direct-chat").css('min-height', chatRoomHeight);
                } else {
                    chatRoomHeight = sidebar_height - 80;
                    $(".nav-tabs-custom, .widget-user-2, .direct-chat").css('min-height', chatRoomHeight);
                }

                var editorHeight = $('.editor').height();
                chatRecordHeight = chatRoomHeight - 60 - editorHeight;
                $('.direct-chat-messages').css('min-height', chatRecordHeight);
            }

            function sendTextHandler() {
                var text = $('#text_in').val();
                var elem = makeMessageHtml(text, 'left');
                $('.direct-chat-messages').append(elem);
                positionBottom();
                console.log(text);
            }

            function sendFaceHandler() {
                var faceText = $(this).attr('labFace');
                var labFace = $(this).parent().html();
                var elem = makeMessageHtml(labFace, 'left');
                $('.direct-chat-messages').append(elem);
                positionBottom();
                console.log(faceText);
                console.log(labFace);
            }

            //发送图片消息
            function sendImageHandler(e) {
                var image = e.target.files[0];
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
                    console.log(res);
                    //构建消息标签然后插入dom中
                    var image = '<img src="'+res.url+'" style="height: 100px; width: 100px">';
                    var _html = makeMessageHtml(image, 'left');
                    $(".direct-chat-messages").append(_html);
                    positionBottom();
                    //聊天框默认最底部
//                    positionBottom();
                    //保存消息
//                    storeMessage(res.url, 2);

                }).fail(function (res) {
                    console.log(res.responseJSON.message);
                });
            }

            function positionBottom() {
                $(document).ready(function () {
                    $(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);
                });
            }

            function makeMessageHtml(content, point) {
                var _html = '';
                _html += '<div class="direct-chat-msg"><div class="direct-chat-info clearfix">';
                _html += '<span class="direct-chat-name pull-left">Alexander Pierce</span>';
                _html += '<span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span></div>';
                _html += '<img class="direct-chat-img" src="/img/user1-128x128.jpg" alt="Message User Image">';
                _html += '<div class="direct-chat-text">' + content + '</div></div>';

                return _html;
            }
        });

    </script>
@endsection