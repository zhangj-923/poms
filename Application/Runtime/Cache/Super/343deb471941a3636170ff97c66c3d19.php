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
<div class="x-body">
  <form class="layui-form">
    <input type="hidden" id="manager_id" name="manager_id"/>
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
      <label for="building_id" class="layui-form-label">
        <span class="x-red">*</span>所属楼宇
      </label>
      <div class="layui-input-inline">
        <select class="layui-select" id="building_id" name="building_id" lay-filter="building" lay-verify="required" disabled>
          <option value="">请选择</option>
        </select>
      </div>
    </div>
    <div class="layui-form-item">
      <label for="manager_name" class="layui-form-label">
        <span class="x-red">*</span>楼宇管理员名称
      </label>
      <div class="layui-input-inline">
        <input type="text" id="manager_name" name="manager_name" required
               autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <label for="manager_mobile" class="layui-form-label">
        <span class="x-red">*</span>联系方式
      </label>
      <div class="layui-input-inline">
        <input type="text" id="manager_mobile" name="manager_mobile" required
               autocomplete="off" class="layui-input" lay-verify="phone">
      </div>
    </div>
    <div class="layui-form-item">
      <label for="name" class="layui-form-label">
        <span class="x-red">*</span>登录名
      </label>
      <div class="layui-input-inline">
        <input type="text" id="name" name="name"
               autocomplete="off" class="layui-input"  disabled>
      </div>
      <div class="layui-form-mid layui-word-aux">
        <span class="x-red">*</span>将会成为您唯一的登入名，不可更改
      </div>
    </div>
    <div class="layui-form-item">
      <label for="remark" class="layui-form-label">
        <span class="x-red">*</span>备注
      </label>
      <div class="layui-input-inline">
        <input type="text" id="remark" name="remark" required
               autocomplete="off" class="layui-input">
      </div>
    </div>
    <div class="layui-form-item">
      <label for="L_repass" class="layui-form-label">
      </label>
      <button class="layui-btn" lay-filter="edit" lay-submit="">
        确定
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
      //验证用户名不重复
      username: function (value) {
        var datas = {name: value};
        var message = '';
        $.ajax({
          type: 'post',
          url: 'verifyName',
          data: datas,
          async: false,
          // dataType: 'json',
          // contentType: 'application/json;charset=UTF-8',
          success: function (data) {
            if ($.parseJSON(data).code == 200) {

            } else {
              message = "用户名已存在，请重新输入！";
            }
          }
        })
        if (message !== '') {
          return message;
        }
      }
      , pass: [/(.+){6,12}$/, '密码必须6到12位']
      , repass: function (value) {
        if ($('#L_pass').val() != $('#L_repass').val()) {
          return '两次密码不一致';
        }
      }
    });

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

    $.ajax({
      url: "<?php echo U('Public/getBuildingData');?>",
      success: function (data) {
        var optionstring = "";
        $.each($.parseJSON(data), function (index, item) {
          optionstring += "<option value=\"" + item.building_id + "\" >" + item.building_name + "</option>";
        })
        $("#building_id").html('<option value="">请选择</option>' + optionstring);
        // form.render(); //更新全部表单内容
        form.render('select'); //刷新表单select选择框渲染
      }
    });

    //监听提交
    form.on('submit(edit)', function (data) {
      console.log(data);
      //发异步，把数据提交给php
      $.ajax({
        url: 'editUser',
        type: 'post',
        data: data.field,
        dataType: 'json',
        success: function (data) {
          if (data.code == 200) {
            layer.msg(data.msg, function () {
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

    getUserAjax();

    function getUserAjax () {
      var manager_id = window.parent.document.getElementById('manager_id').value;
      $.ajax({
        url: 'getUser?managerId=' + manager_id,
        type: 'get',
        dataType: 'json',
        success: function (data) {
          $("#manager_id").val(data.data.manager_id);
          $("#garden_id").val(data.data.garden_id);
          $("#building_id").val(data.data.building_id);
          $("#manager_name").val(data.data.manager_name);
          $("#manager_mobile").val(data.data.manager_mobile);
          $("#name").val(data.data.name);
          $("#remark").val(data.data.remark);
          form.render('select');
        }
      });
    }


  });
</script>
<script>
  layui.use('form', function () {
    var form = layui.form;
    form.on('select(garden)', function (data) {
      var garden_id = data.value;
      // console.log(garden_id);
      $.ajax({
        url: "<?php echo U('Public/getBuildingData');?>",
        type: 'post',
        data: {garden_id: garden_id},
        success: function (data) {
          var optionstring = "";
          $.each($.parseJSON(data), function (index, item) {
            optionstring += "<option value=\"" + item.building_id + "\" >" + item.building_name + "</option>";
          })
          $('#building_id').empty();
          $("#building_id").html('<option value="">请选择</option>' + optionstring);
          form.render('select');
        }
      })
    })
  })
</script>
</body>

</html>