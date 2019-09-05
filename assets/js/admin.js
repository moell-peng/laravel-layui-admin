;!function (win) {

  var Admin = function () {

  };

  Admin.prototype.paginate = function (count, curr, limit, limits) {
    layui.laypage.render({
      elem: 'page',
      count: count,
      curr: curr,
      limit: limit,
      limits: limits ? limits : [15, 30, 40, 50],
      layout: ['count', 'prev', 'page', 'next', 'limit', 'refresh', 'skip'],
      jump: function(obj, first){
        if(!first){
          location.href= window.location.pathname + '?' + $("#search-form").serialize() + '&page='+obj.curr+'&limit='+obj.limit;
        }
      }
    });
  };

  Admin.prototype.tableDataDelete = function (url, th, isRefresh) {
    layui.layer.confirm('你确认删除吗？', {
      btn: ['删除', '取消']
    }, function () {
      $.ajax({
        type: "DELETE",
        url: url,
        success: function() {
          if (isRefresh) {
            window.location = window.location.href
            return false;
          }
          $(th).parent().parent().parent().remove();
          layui.layer.close();
          layui.layer.msg("删除成功", {time: 2000, icon: 6})
        },
      });
    }, function () {
      layui.layer.close();
    });
  };

  Admin.prototype.openLayerForm = function (url, title, method, width, height, noRefresh, formId) {
    var formId = formId ? formId : "#layer-form";
    $.get(url, function(view) {
      layui.layer.open({
        type: 1,
        title: title,
        anim: 2,
        shadeClose: true,
        content: view,
        success: function() {
          layui.form.render();
        },
        area:[
          width ? width : '50%',
          height ? height : '500px'
        ],
        btn: ['确认', '重置'],
        yes: function (index, layero) {
          var formObj = $(formId);
          $.ajax({
            type: method ? method : 'POST',
            url: formObj.attr("action"),
            dataType: "json",
            data: formObj.serialize(),
            success: function(response) {
              if (response.status === 'success') {
                layui.layer.close(index);
                layui.layer.msg(response.message, {time: 2000, icon: 6})
                if (!noRefresh) {
                  window.location = window.location.href
                }
              } else {
                layui.layer.msg(response.message, {time: 3000, icon: 5})
              }
            },
          });
        },
        btn2: function (index, layero) {
          $(formId)[0].reset();
          return false;
        }
      });
    });
  };

  win.admin = new Admin();
}(window);

layui.config({
  base: "/vendor/laravel-layui-admin/js/"
});

layui.use("jquery", function() {
  $ = layui.jquery;

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) {
      var status = XMLHttpRequest.status;
      var responseText = XMLHttpRequest.responseText;
      var msg = '不好，有错误';
      switch (status) {
        case 400:
          msg = responseText != '' ? responseText : '失败了';
          break;
        case 401:
          msg = responseText != '' ? responseText : '你没有权限';
          break;
        case 403:
          msg =  '你没有权限执行此操作!';
          break;
        case 404:
          msg = '你访问的操作不存在';
          break;
        case 406:
          msg = '请求格式不正确';
          break;
        case 410:
          msg = '你访问的资源已被删除';
          break;
        case 422:
          var errors = $.parseJSON(XMLHttpRequest.responseText);

          if (errors instanceof Object) {
            var m = '';
            $.each(errors, function(index, item) {
              if (item instanceof Object) {
                $.each(item, function(index, i) {
                  m = m + i + '<br>';
                });
              } else {
                m = m + item + '<br>';
              }
            });
            msg = m;
          }
          break;
        case 429:
          msg = '超出访问频率限制';
          break;
        case 500:
          msg = '500 INTERNAL SERVER ERROR';
          break;
        default:
          return true;
      }

      layer.msg(msg, {time: 3000, icon: 5});
    }
  });
});