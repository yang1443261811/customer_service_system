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

        .ant-popover-message {
            font-size: 14px;
            padding: 4px 0 12px;
        }

        .fa-info-circle {
            color: orange;
        }

        .btn-yes, .btn-no {
            height: 24px;
            padding: 0 7px;
            font-size: 14px;
            border-radius: 4px;
            line-height: 1.499;
            position: relative;
            display: inline-block;
            font-weight: 400;
            white-space: nowrap;
            text-align: center;
            background-image: none;
            box-shadow: 0 2px 0 rgba(0, 0, 0, .015);
            cursor: pointer;
            transition: all .3s cubic-bezier(.645, .045, .355, 1);
            color: rgba(0, 0, 0, .65);
            background-color: #fff;
            border: 1px solid #d9d9d9;
        }

        .btn-no {
            margin-right: 8px;
        }

        .btn-no:hover {
            border-color: #1890ff;
            color: #1890ff;
            background: white;
        }

        .btn-yes {
            background-color: #1890ff;
            border-color: #1890ff;
            color: white;
            outline: none;
        }

        .btn-yes:hover {
            color: white;
        }

        .popover-inner-content {
            padding: 12px 16px;
            color: rgba(0, 0, 0, .65);
            text-align: center;
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
                    <button type="button" class="add-btn btn-dashed"><i class="fa fa-fw fa-plus"></i><span>新增成员</span>
                    </button>
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
                                        <span><a class="operate-btn">编辑</a><a class="operate-btn">删除</a></span>
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
        <div class="assist-box hidden">
            <div class="popover-inner-content">
                <div class="ant-popover-message"><i class="fa fa-fw fa-info-circle"></i>是否要删除此行？</div>
                <div class="popover-buttons">
                    <button type="button" class="btn btn-sm btn-default btn-no">取 消</button>
                    <button type="button" class="btn btn-yes btn-sm">确 定</button>
                </div>
            </div>
            <table>
                <tr class="create-user-form">
                    <td style="width: 50px;"></td>
                    <td style="width: 25%"><input type="text" name="name" placeholder="成员姓名" autocomplete="off"/></td>
                    <td style="width: 25%"><input type="text" name="email" placeholder="邮箱" autocomplete="off"/></td>
                    <td><input type="text" name="password" placeholder="登陆密码" autocomplete="off"/></td>
                    <td class="action-bar">
                        <span><a class="operate-btn">保存</a><a class="operate-btn">取消</a></span>
                    </td>
                </tr>
            </table>
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
                var td_1 = tr.find('td').eq(1);
                var td_2 = tr.find('td').eq(2);
                td_1.html('<input type="text" class="name" value="' + td_1.html() + '" placeholder="用户名" autocomplete="off"/>');
                td_2.html('<input type="text" class="email" value="' + td_2.html() + '" placeholder="用户邮箱" autocomplete="off"/>');
                $(this).html('保存');
            }

            if (word === '保存') {
                var name = tr.find('.name').val();
                var email = tr.find('.email').val();
                if (!name || !email) {
                    layer.msg('请填写完整用户信息', {icon: 2, time: 1000});
                    return false;
                }

                var id = tr.attr('data-row-key');
                var that = $(this);

                $.ajax({
                    type: 'post',
                    url: '/user/update/' + id,
                    data: {name: name, email: email, _token: token}

                }).done(function (res) {
                    if (res) {
                        tr.find('td').eq(1).html(name);
                        tr.find('td').eq(2).html(email);
                        layer.msg('success', {icon: 1, time: 1000, shade: [0.3, '#fff']});
                        that.html('编辑');
                    } else {
                        layer.msg('修改失败', {icon: 2, time: 1000});
                    }

                }).fail(function (res) {
                    if (res.status === 422) {
                        var err = res.responseJSON.errors;
                        var keys = Object.keys(err);
                        layer.msg(err[keys[0]][0], {icon: 2, time: 2000});
                    }
                });
            }
        });

        var selected_row_index, data_row_key;
        $('.table .remove-btn').click(function () {
            data_row_key = $(this).parents('tr').attr('data-row-key');
            selected_row_index = $(this).parents('tr').index();
            var content = $('.assist-box .popover-inner-content').prop('outerHTML');

            layer.tips(content, this, {tips: [1, 'white'], time: 5000});
        });

        $(document).on('click', '.popover-inner-content .btn-no', function () {
            layer.closeAll();
        });

        $(document).on('click', '.popover-inner-content .btn-yes', function () {
            $.get('/user/delete/' + data_row_key, function (res) {
                res ? $('.table tr').eq(selected_row_index).remove() : layer.msg('删除失败', {icon: 2});
            });

            layer.closeAll();
        });

        $('.add-btn').click(function () {
            var _html = $('.assist-box .create-user-form').prop('outerHTML');
            $('.table tbody').prepend(_html);
        });

        $('.table').on('click', '.cancel-save', function () {
            $(this).parents('tr').remove();
        });

        $('.table').on('click', '.save-user-btn', function () {
            var user = {};
            var parent = $(this).parents('tr');
            user.name = parent.find('input[name=name]').val();
            user.email = parent.find('input[name=email]').val();
            user.password = parent.find('input[name=password]').val();
            if (!(user.name && user.email && user.password)) {
                layer.msg('请完善用户信息', {icon: 2, time: 1000});
                return false;
            }

            parent.find('td').eq(1).html(user.name);
            parent.find('td').eq(2).html(user.email);
            parent.find('td').eq(3).html('20181296');
            $('.table tbody').append(parent);
            layer.msg('成功', {icon: 1})
        })
    </script>
@endsection