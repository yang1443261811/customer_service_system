@extends('layouts.admin')

@section('css')
    <style>
        table tr td {
            color: rgba(0, 0, 0, .65)
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
                    <h3 class="box-title">用户列表</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="padding:0 10px;">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>用户名</th>
                            <th>受理客服</th>
                            <th>会话状态</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>

                        @if($data->isEmpty())
                            <tr>
                                <td colspan="4" style="text-align: center">没有查询到数据</td>
                            </tr>
                        @else
                            @foreach($data as $item)
                                <tr data-row-key="{{$item->id}}">
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->kf->name}}</td>
                                    <td>
                                        @if($item->status == 1)
                                            <span class="label label-success">新会话</span>
                                        @elseif($item->status == 2)
                                            <span class="label label-warning">处理中</span>
                                        @else
                                            <span class="label label-danger">已完成</span>
                                        @endif
                                    </td>
                                    <td><span class="badge bg-red">{{$item->created_at}}</span></td>
                                    <td class="action-bar">
                                        <span><a href="/dialog/details/{{$item->id}}" class="edit-btn">查看</a></span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li><a href="#">«</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">»</a></li>
                    </ul>
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