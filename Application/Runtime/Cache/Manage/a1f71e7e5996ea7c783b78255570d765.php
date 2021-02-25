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
    <input type="hidden" id="power_id" name="power_id"/>
    <input type="hidden" name="TOKEN" value="<?php echo session('TOKEN');?>"/>
    <input type="hidden" id="room_id" name="room_id"/>
    <div class="layui-form-item">
      <label for="room_sn" class="layui-form-label">
        <span class="x-red">*</span>房屋编号
      </label>
      <div class="layui-input-inline">
        <input type="text" id="room_sn" name="room_sn" required
               autocomplete="off" class="layui-input" disabled>
      </div>
    </div>
    <div class="layui-form-item">
      <label for="power_sn" class="layui-form-label">
        <span class="x-red">*</span>水表编号
      </label>
      <div class="layui-input-inline">
        <input type="text" id="power_sn" name="power_sn" required
               autocomplete="off" class="layui-input" placeholder="输入水表编号">
      </div>
    </div>
    <div class="layui-form-item">
      <label for="p_price" class="layui-form-label">
        <span class="x-red">*</span>单价
      </label>
      <div class="layui-input-inline">
        <input type="text" id="p_price" name="p_price" required
               autocomplete="off" class="layui-input" placeholder="输入单价">
      </div>
      <div class="layui-form-mid layui-word-aux">
        <span class="x-red">*</span>元/度
      </div>
    </div>
    <div class="layui-form-item">
      <label for="p_current" class="layui-form-label">
        <span class="x-red">*</span>初始读数
      </label>
      <div class="layui-input-inline">
        <input type="text" id="p_current" name="p_current" required
               autocomplete="off" class="layui-input" placeholder="输入初始读数">
      </div>
    </div>
    <div class="layui-inline">
      <label for="p_time" class="layui-form-label">
        <span class="x-red">*</span>初始抄表日期
      </label>
      <div class="layui-input-inline">
        <input type="text" name="p_time" id="p_time" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off"
               class="layui-input">
      </div>
    </div>
    <div class="layui-form-item" style="margin-top: 15px">
      <label for="L_repass" class="layui-form-label">
      </label>
      <button class="layui-btn" lay-filter="add" lay-submit="">
        确定
      </button>
    </div>
  </form>
</div>
<script>
  layui.use(['form', 'layer', 'laydate'], function () {
    $ = layui.jquery;
    var form = layui.form
      , layer = layui.layer
      , laydate = layui.laydate;

    //日期
    laydate.render({
      elem: '#p_time'
    });

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

    //监听提交
    form.on('submit(add)', function (data) {
      console.log(data);
      //发异步，把数据提交给php
      $.ajax({
        url: 'editPower',
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

    getLeaseAjax();

    function getLeaseAjax () {
      var power_id = window.parent.document.getElementById('update_power_id').value;
      $.ajax({
        url: 'getPower?powerId=' + power_id,
        type: 'get',
        dataType: 'json',
        success: function (data) {
          $("#power_id").val(data.data.power_id);
          $("#room_id").val(data.data.room_id);
          $("#room_sn").val(data.data.room_sn);
          $("#power_sn").val(data.data.power_sn);
          $("#p_current").val(data.data.p_current);
          $("#p_price").val(data.data.p_price);
          $("#p_time").val(data.data.p_time);
          form.render();
        }
      });
    }

  });
</script>
<script>

</script>
</body>

</html>