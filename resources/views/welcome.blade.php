<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body>
<div style="width: 500px; height:500px; background: #f1b0b7; margin: 0 auto; text-align: center;padding-top:50px">
    <form action="javascript:;">
        <input type="text" class="word">
        <input type="submit" class='send' value="提交">
    </form>
    <ul class="record">

    </ul>
</div>
</body>
<script src="/js/jquery.min.js"></script>
<script>
    window.client_id = '';
    window.uid =  (new Date()).getTime();
    console.log(uid);
    //    ws = new WebSocket("ws://" + document.domain + ":2346");
    ws = new WebSocket("ws://" + "127.0.0.1:8282");

    ws.onopen = function (e) {
        console.log(e);
    };

    ws.onmessage = function (e) {
        var response = JSON.parse(e.data);

        if (response.message_type === 'connectSuccess') {
            client_id = response.client_id;

            var word = {'message_type': 'init', 'data': {'uid': uid}};

            ws.send(JSON.stringify(word));
        }

        if (response.message_type === 'chatMessage') {
            console.log(response.data)
        }
    };

    $('form').submit(function (e) {
        e.preventDefault();
        console.log('click');
//        var word = $('word').val();
        var msg = {
            'message_type': 'chatMessage',
            'data': {
                'from_name': '慕容雪村',
                'from_avatar': '1122.png',
                'from_id': 1314,
                'to_id': 1314,
                'content': $('.word').val()
            }
        };

        if (ws.readyState === 1) {
            console.log('send success');
            ws.send(JSON.stringify(msg))
        }

    });


    //添加事件监听
    //    ws.addEventListener('open', function () {
    //        ws.send(message)
    //    });

</script>
</html>
