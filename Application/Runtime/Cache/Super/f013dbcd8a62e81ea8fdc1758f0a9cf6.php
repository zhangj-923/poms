<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>欢迎页面-L-admin1.0</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport"
        content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
  <link rel="shortcut icon" href="/Data/admin/favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" href="/Data/admin/css/font.css">
  <link rel="stylesheet" href="/Data/admin/css/xadmin.css">
  <script src="/Data/admin/js/jquery.min.js"></script>
  <script type="text/javascript" src="/Data/admin/lib/layui/layui.js" charset="utf-8"></script>
  <script type="text/javascript" src="/Data/admin/js/xadmin.js"></script>
  <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
  <!--[if lt IE 9]>
  <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
  <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body>
<div class="x-body layui-anim layui-anim-up">
  <form class="layui-form">
    <div class="layui-form-item">
      <label for="garden_id" class="layui-form-label">
        <span class="x-red">*</span>所属园区
      </label>
      <div class="layui-input-inline">
        <select class="layui-select" id="garden_id" name="garden_id" lay-filter="garden" lay-verify="required" disabled>
          <option value="">请选择</option>
        </select>
      </div>
    </div>
    <div class="layui-form-item">
      <label for="building_name" class="layui-form-label">
        <span class="x-red">*</span>楼宇名称
      </label>
      <div class="layui-input-inline">
        <input type="text" id="building_name" name="building_name" required
               autocomplete="off" class="layui-input" lay-verify="required">
      </div>
    </div>
    <div class="layui-form-item">
      <label for="L_repass" class="layui-form-label">
      </label>
      <button class="layui-btn" lay-filter="add" lay-submit="">
        添加
      </button>
    </div>
  </form>
</div>
<script>
  layui.use(['form', 'layer'], function () {
    $ = layui.jquery;
    var form = layui.form
      , layer = layui.layer;

    //自定义验证规则
    form.verify({
      nikename: function (value) {
        if (value.length < 5) {
          return '昵称至少得5个字符啊';
        }
      }
      , pass: [/(.+){6,12}$/, '密码必须6到12位']
      , repass: function (value) {
        if ($('#L_pass').val() != $('#L_repass').val()) {
          return '两次密码不一致';
        }
      }
    });

    //联系方式不可重复验证

    $.ajax({
      url: "<?php echo U('Public/getGardenData');?>",
      success: function (data) {
        $.each($.parseJSON(data), function (index, item) {
          // console.log(item);
          //option  第一个参数是页面显示的值，第二个参数是传递到后台的值
          $('#garden_id').append(new Option(item.garden_name, item.garden_id));//往下拉菜单里添加元素
          //设置value（这个值就可以是在更新的时候后台传递到前台的值）为2的值为默认选中
        })
        form.render(); //更新全部表单内容
        //form.render('select'); //刷新表单select选择框渲染
      }
    });

    //监听提交
    form.on('submit(add)', function (data) {
      console.log(data);
      //发异步，把数据提交给php
      $.ajax({
        url: "<?php echo U('Building/addBuilding');?>",
        type: 'post',
        data: data.field,
        dataType: 'json',
        success: function (data) {
          if (data.code == 200) {
            layer.msg(data.msg, {icon: 6}, function () {
              // 获得frame索引
              var index = parent.layer.getFrameIndex(window.name);
              //关闭当前frame
              parent.layer.close(index);

              //关闭层
              //x_admin_close();
              //对父窗体进行刷新
              parent.location.reload();
            })
          } else {
            layer.alert(data.msg);
          }
        }
      })
      return false;
    });

    getGardenAjax();

    function getGardenAjax () {
      var garden_id = window.parent.document.getElementById('garden_id').value;
      $.ajax({
        url: 'getGarden?gardenId=' + garden_id,
        type: 'get',
        dataType: 'json',
        success: function (data) {
          $("#garden_id").val(data.data.garden_id);
          form.render('select');
        }
      });
    }

  });
</script>
</body>

</html>