@extends('layouts.admin')

@section('css')
    <style>
        table tr td {
            color: rgba(0, 0, 0, .65)
        }
        .direct-chat-messages .right .direct-chat-text {
            text-align: right;
        }
    </style>
@endsection

@section('content-header')
    <h1>
        <small>Optional description</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> 用户管理</a></li>
        <li class="active">用户列表</li>
    </ol>
@endsection

@section('content')
    <!-- Your Page Content Here -->
    <div class="row no-padding">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">会话详情</h3>
                    <div class="box-tools">
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-green">客户名称</span>
                                <h5 class="description-header"></h5>
                                <span class="description-text">{{$data->name}}</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-yellow">客户ID</span>
                                <h5 class="description-header"></h5>
                                <span class="description-text">{{$data->uid}}</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block border-right">
                                <span class="description-percentage text-green">受理客服</span>
                                <h5 class="description-header"></h5>
                                <span class="description-text">{{$data->kf->name}}</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-3 col-xs-6">
                            <div class="description-block">
                                <span class="description-percentage text-red">会话状态</span>
                                <h5 class="description-header"></h5>
                                <span class="description-text">{{[1 => '新会话', 2 => '处理中', 3 => '处理完成'][$data->status]}}</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                    </div>
                    <!-- /.row -->
                    <div class="row with-border">
                        <div class="direct-chat-messages" style="height:535px">
                            @foreach($data['messages'] as $item)
                                <div class="direct-chat-msg {{$item->from_id == $data->kf_id ? 'right' : ''}}">
                                    <div class="direct-chat-info clearfix">
                                        <span class="direct-chat-name {{$item->from_id == $data->kf_id ? 'pull-right' : 'pull-left'}}">客户</span>
                                        <span class="direct-chat-timestamp {{$item->from_id == $data->kf_id ? 'pull-left' : 'pull-right'}}">{{$item->created_at}}</span>
                                    </div>
                                    <img class="direct-chat-img" src="{{$item->from_avatar}}">
                                    <div class="direct-chat-text">{{$item->content}}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script src="https://cdn.staticfile.org/layer/2.3/layer.js"></script>
    <script>
        var token = '{{csrf_token()}}';


    </script>
@endsection