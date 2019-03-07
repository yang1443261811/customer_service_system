@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8" style="background: #f1b0b7; margin: 0 auto; text-align: center;padding:50px">
            <input type="text" class="word">
            <input type="submit" class='send' value="提交">
            <ul class="record">

            </ul>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            window.client_id = '';
            window.uid = {{auth()->id()}};
            window.to_id = uid === 1 ? 2 : 1;
            window.to_name = '杨静';
            window.from_id = {{auth()->id()}};
            window.from_name = '{{auth()->user()->name}}';
            window.from_avatar = '123.png';
            //    ws = new WebSocket("ws://" + document.domain + ":2346");
            window.ws = new WebSocket("ws://" + "127.0.0.1:8282");

            ws.onopen = function (e) {
                console.log(e);
            };

            ws.onmessage = function (e) {
                var response = JSON.parse(e.data);

                if (response.message_type === 'connectSuccess') {
                    var text = {'message_type': 'init', 'data': {'uid': uid}};
                    ws.send(JSON.stringify(text));
                }

                if (response.message_type === 'chatMessage') {
                    var dom = '<li>' + response.data.content + '</li>';
                    $('.record').append(dom);
                    console.log(response.data)
                }
            };

            $('.send').click(function (e) {
                var word = $('.word').val();
                var msg = {
                    'message_type': 'chatMessage',
                    'data': {
                        'from_id': uid,
                        'from_name': from_name,
                        'from_avatar': from_avatar,
                        'to_id': to_id,
                        'to_name': to_name,
                        'content': word,
                    }
                };

                console.log(ws.readyState);
                if (ws.readyState === 1) {
                    console.log('send success');
                    ws.send(JSON.stringify(msg))
                }

                //清空输入框
                $('.word').val('')
            });
        });

    </script>
@endsection