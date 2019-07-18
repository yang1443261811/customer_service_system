@extends('layouts.admin')

@section('css')
    <style>
        table tr td {
            color: rgba(0, 0, 0, .65)
        }

        table .action-bar {
            vertical-align: bottom !important;
        }

        table .action-bar span {
            display: inline-block;
            height: auto;
            overflow: hidden;
        }

        table .action-bar a {
            display: inline-block;
            color: #1890ff;
            cursor: pointer;
        }

        table tr td input {
            box-sizing: border-box;
            margin: 0;
            font-variant: tabular-nums;
            list-style: none;
            font-feature-settings: "tnum";
            position: relative;
            display: inline-block;
            width: 100%;
            height: 32px;
            padding: 4px 11px;
            color: rgba(0, 0, 0, .65);
            font-size: 14px;
            line-height: 1.5;
            background-color: #fff;
            background-image: none;
            border: 1px solid #d9d9d9;
            border-radius: 4px;
            transition: all .3s;
        }

        input::-webkit-input-placeholder {
            color: #aab2bd;
        }

        .btn-dashed {
            color: rgba(0, 0, 0, .65);
            background-color: #fff;
            border: 1px dashed #d9d9d9;
            height: 32px;
            width: 100%;
            margin-bottom: 10px;
            margin-top: 5px;
            border-radius: 4px;
            outline: none;
        }

        .btn-dashed:hover {
            border-color: #1890ff;
            color: #1890ff;
        }

        .ant-divider, .ant-divider-vertical {
            position: relative;
            top: -.06em;
            display: inline-block;
            width: 1px;
            height: .9em;
            margin: 0 6px !important;
            vertical-align: middle;
        }

        .ant-divider {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            color: rgba(0, 0, 0, .65);
            font-size: 14px;
            font-variant: tabular-nums;
            line-height: 1.5;
            list-style: none;
            font-feature-settings: "tnum";
            background: #e8e8e8;
        }

        .pagination {
            margin: 0;
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
    <div class="box">
        <div class="box-header with-border">
            <div class="pull-left">
                <form action="/eventLog/event_log" method="get">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <input type="text" name="keyword" class="form-control pull-right" placeholder="Search" value="{{$keyword}}">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="pull-right">
                <form action="/eventLog/event_log" method="get" class="form-inline">
                    <div class="form-group input-group-sm">
                        <select class="form-control" name="media">
                            <option value="">媒体源</option>
                            @foreach($media_list as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                                {{--@if(!empty($game_id) && $game_id == $game['id'])--}}
                                {{--<option value="{{$media}}" selected>$media</option>--}}
                                {{--@else--}}
                                {{--<option value="{{$game['id']}}">{{$game['alias'] ?: $game['app_name']}}</option>--}}
                                {{--@endif--}}
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group input-group-sm">
                        <select class="form-control" name="event_name">
                            <option value="">事件</option>
                            @foreach($events as $id => $name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group input-group-sm">
                        <button type="submit" class="btn btn-primary btn-sm">
                            查询
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="padding:0 10px;">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>APP ID</th>
                    <th>UID</th>
                    <th>媒体源</th>
                    <th>事件名称</th>
                    <th>事件值</th>
                    <th>事件时间</th>
                    <th>操作</th>
                </tr>

                @if($data->isEmpty())
                    <tr>
                        <td colspan="4" style="text-align: center">没有查询到数据</td>
                    </tr>
                @else
                    @foreach($data as $item)
                        <tr>
                            <td style="width: 50px;">{{$item->id}}</td>
                            <td>{{$item->app_id}}</td>
                            <td>{{$item->advertising_id}}</td>
                            <td>{{$item->media_source}}</td>
                            <td>{{$item->event_name}}</td>
                            <td>{{$item->event_value}}</td>
                            <td><span class="badge bg-red">{{$item->event_time}}</span></td>
                            <td class="action-bar">
                                <span>
                                    <a class="edit-btn">编辑</a>
                                    <div class="ant-divider ant-divider-vertical"></div>
                                    <a class="remove-btn">删除</a>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix text-center">
            {{--分页导航--}}
            {{--{!! $links !!}--}}
            {{ $data->appends([
                'keyword' => $keyword,
                'media' => $media,
                'event_name' => $event_name,
            ])->links() }}
        </div>
    </div>
@endsection

@section('js')
    <script>

    </script>
@endsection