/**
 * Created by BL on 2019/4/9.
 * 聊天页面,快捷回复相关的js操作
 */
//创建快捷回复
function createFastReply() {
  var title = $('#reply_title').val();
  var content = $('#reply_content').val();
  
  if (!title || !content) {
    layer.msg('标题跟内容不能为空');
    return false;
  }
  
  $.ajax({
    type: 'post',
    url: '/fastReply/create',
    data: {title: title, word: content, _token: token},
    success: function (res) {
      if (res) {
        layer.msg('添加成功', {icon: 1});
        $('.addReply').before('<span class="label bg-green send-fast-reply" word="' + content + '" key="' + res + '">' + title + '<i class="fa fa-fw fa-remove"></i></span>');
        window.setTimeout(layer.closeAll, 2000);
      } else {
        layer.msg('添加失败');
      }
    },
    error: function (res) {
      if (res.status === 422) {
        $.each(res.responseJSON.errors, function (key, value) {
          layer.msg(value[0]);
          return false;
        });
      } else {
        layer.msg('添加失败');
      }
    }
  })
}

//创建快捷回复.弹出框
function popupForm() {
  var _html = '<div class="addReplyForm"><div><label for="reply_title" class="control-label">标签:</label>';
  _html += '<input type="text" id="reply_title"></div>';
  _html += ' <div><label for="reply_content" class="control-label">内容:</label>';
  _html += '<textarea name="" id="reply_content"></textarea></div>';
  _html += '<div style="text-align: right"><button type="button" class="btn btn-info btn-sm save_reply">确定</button>';
  _html += '<button type="button" class="btn btn-default btn-sm cancelPopup">取消</button></div></div>';
  //自定页
  layer.open({
    type: 1,
    title: '新增快捷回复',
    area: ['420px', '300px'], //宽高
    content: _html
  });
}

//获取所有快捷回复
function getFastReply() {
  $.get('/fastReply/get', function (res) {
    var _html = '';
    $.each(res, function (index, item) {
      _html += '<span class="label bg-green send-fast-reply" title="应用" word="' + item.word + '" key="' + item.id + '">' + item.title + '<i class="fa fa-fw fa-remove"></i></span>'
    });
    
    $('.fastReply-box').prepend(_html);
  })
}

//删除快捷回复
function removeFastReply() {
  var that = $(this);
  var id = that.parents('span').attr('key');
  layer.confirm('确认删除？', {
    btn: ['确定', '取消'] //按钮
  }, function () {
    $.get('/fastReply/delete/' + id, function () {
      that.parents('span').remove();
      layer.msg('删除成功', {icon: 1});
    });
  });
}
