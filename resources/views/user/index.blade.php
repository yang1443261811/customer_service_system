@extends('layouts.admin')

@section('css')
    <style>
        table tr td {
            color: rgba(0, 0, 0, .65)
        }

        table .action-bar span {
            display: inline-block;
            height: auto;
            overflow: hidden;
        }

        table .action-bar a {
            display: inline-block;
            padding-right: 15px;
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
                <div class="box-header with-border">
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
                <div class="box-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <th style="width: 10px">ID</th>
                            <th>用户名</th>
                            <th>email</th>
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
                                    <td style="width: 50px;">{{$item->id}}</td>
                                    <td style="width: 25%">{{$item->name}}</td>
                                    <td style="width: 25%">{{$item->email}}</td>
                                    <td><span class="badge bg-red">{{$item->created_at}}</span></td>
                                    <td class="action-bar">
                                        <span><a class="edit-btn">编辑</a><a class="remove-btn">删除</a></span>
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

        $('.table .edit-btn').click(function () {
            var tr = $(this).parents('tr');
            var word = $(this).html();
            if (word === '编辑') {
                var old_name = tr.find('td').eq(1).html();
                var old_email = tr.find('td').eq(2).html();
                tr.find('td').eq(1).html('<input type="text" class="name" value="' + old_name + '" placeholder="用户名" autocomplete="off"/>');
                tr.find('td').eq(2).html('<input type="text" class="email" value="' + old_email + '" placeholder="用户邮箱" autocomplete="off"/>');
                $(this).html('保存');
            }

            if (word === '保存') {
                var new_name = tr.find('.name').val();
                var new_email = tr.find('.email').val();
                var id = tr.attr('data-row-key');
                if (!new_email || !new_email) {
                    layer.msg('请填写完整用户信息', {icon: 2, time: 1000});
                    return false;
                }

                var that = $(this);
                $.post('/user/update/' + id, {name: new_name, email: new_email, _token: token})
                    .done(function (res) {
                        if (res) {
                            tr.find('td').eq(1).html(new_name);
                            tr.find('td').eq(2).html(new_email);
                            layer.msg('success', {icon: 1, time: 1000, shade: [0.3, '#fff']});
                            that.html('编辑');
                        } else {
                            layer.msg('修改失败', {icon: 2, time: 1000});
                        }
                    })
                    .fail(function (res) {
                        if (res.status === 422) {
                            var err = res.responseJSON.errors;
                            var keys = Object.keys(err);
                            layer.msg(err[keys[0]][0], {icon: 2, time: 2000});
                        }
                    });
            }
        });

        $('.table .remove-btn').click(function () {
            console.log(123);
            layer.tips('Hi，我是tips', '吸附元素选择器，如#id');
        })
    </script>
@endsection