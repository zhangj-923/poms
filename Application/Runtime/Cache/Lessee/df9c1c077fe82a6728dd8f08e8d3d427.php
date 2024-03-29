<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
  <meta name='viewport'
        content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'/>
  <meta charset='UTF-8'>
  <title>个人信息</title>

  <link rel="stylesheet" href="/Data/admin/css/font.css">
  <link rel="stylesheet" href="/Data/admin/css/xadmin.css">
  <link rel='stylesheet' href='/Data/lessee/css/index.css'>
  <script src="/Data/admin/js/jquery.min.js"></script>
  <script type="text/javascript" src="/Data/admin/lib/layui/layui.js" charset="utf-8"></script>
  <script type="text/javascript" src="/Data/admin/js/xadmin.js"></script>
</head>
<body>
<div class="index-content">
  <header class="index-header white" style="height: 20vw">
    <div class="f-lex al-center">
      <!--        <h5 class="f-40"><?php echo ($customer_name); ?></h5>-->
      <!--        <img class="down-icon ml-12" src="/Data/lessee/images/icon/down_2_icon.png" alt="">-->
    </div>
    <p class="f-26 show-btn mt-12" style="width: 35vw;color: deeppink;display: inline-block">个人信息修改</p>
  </header>
  <div class="f-lex fl-wrap block-list" id="contents" style="margin-top: 50px">
    <form class="layui-form">
      <input type="hidden" id="customer_id" name="customer_id"/>
      <div class="layui-form-item">
        <label for="customer_name" class="layui-form-label">
          <span class="x-red">*</span>姓名
        </label>
        <div class="layui-input-inline">
          <input type="text" id="customer_name" name="customer_name" required
                 autocomplete="off" class="layui-input" lay-verify="required">
        </div>
      </div>
      <div class="layui-form-item">
        <label for="customer_mobile" class="layui-form-label">
          <span class="x-red">*</span>联系方式
        </label>
        <div class="layui-input-inline">
          <input type="text" id="customer_mobile" name="customer_mobile" required lay-verify="required|phone|username"
                 autocomplete="off" class="layui-input">
        </div>
        <!--              <div class="layui-form-mid layui-word-aux">-->
        <!--                  <span class="x-red">*</span>将会成为您唯一的登入名-->
        <!--              </div>-->
      </div>
      <div class="layui-form-item">
        <label for="password" class="layui-form-label">
          <span class="x-red">*</span>密码
        </label>
        <div class="layui-input-inline">
          <input type="password" id="password" name="password" required
                 autocomplete="off" class="layui-input" lay-verify="required">
        </div>
      </div>
      <div class="layui-form-item">
        <label for="r_pass" class="layui-form-label">
          <span class="x-red">*</span>确认密码
        </label>
        <div class="layui-input-inline">
          <input type="password" id="r_pass" name="r_pass" required
                 autocomplete="off" class="layui-input" lay-verify="required|confirmPass">
        </div>
      </div>
      <div class="layui-form-item">
        <label for="remark" class="layui-form-label">
          <span class="x-red">*</span>备注
        </label>
        <div class="layui-input-inline">
          <input type="text" id="remark" name="remark" required
                 autocomplete="off" class="layui-input" lay-verify="required">
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
</div>
<div class="footer fl-ar ">
  <a href="index">
    <img src="/Data/lessee/images/icon/home_a_icon.png" alt="">
    <p>首页</p>
  </a>
  <a href="device">
    <img src="/Data/lessee/images/icon/equr_n_icon.png" alt="">
    <p>设备报修</p>
  </a>
  <a href="per_center">
    <img src="/Data/lessee/images/icon/mine_n_icon.png" alt="">
    <p class="blue-1">我的</p>
  </a>
</div>
</body>
<script>
  layui.use(['table', 'layer', 'form', 'jquery'], function () {
    var table = layui.table,
      layer = layui.layer,
      form = layui.form,
      $ = layui.$;

//自定义验证规则
    form.verify({
      //验证用户名不重复
      username: function (value) {
        var datas = {
          name: value,
          customer_id: $("#customer_id").val()
        };
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
      , nikename: function (value) {
        if (value.length < 5) {
          return '昵称至少得5个字符啊';
        }
      }
      , pass: [/(.+){6,12}$/, '密码必须6到12位']
      , confirmPass: function (value) {
        if ($('input[name=password]').val() !== value)
          return '提示：两次输入密码不一致！';
      }
    });

    //监听提交
    form.on('submit(edit)', function (data) {
      console.log(data);
      //发异步，把数据提交给php
      $.ajax({
        url: 'editCustomer',
        type: 'post',
        data: data.field,
        dataType: 'json',
        success: function (data) {
          if (data.code == 200) {
            layer.msg(data.msg);
          } else {
            layer.alert(data.msg);
          }
          setTimeout(function () {
            window.location.reload();
          }, 5000);
        }
      })
      return false;
    });


  });
</script>
<script>
  getCustomerAjax();

  function getCustomerAjax () {
    // var room_id = window.parent.document.getElementById('update_room_id').value;
    $.ajax({
      url: 'getCustomer',
      type: 'post',
      dataType: 'json',
      success: function (data) {
        $("#customer_id").val(data.data.customer_id);
        $("#customer_mobile").val(data.data.customer_mobile);
        $("#customer_name").val(data.data.customer_name);
        $("#password").val(data.data.password);
        $("#r_pass").val(data.data.password);
        $("#remark").val(data.data.remark);
      }
    });
  }
</script>
</html>