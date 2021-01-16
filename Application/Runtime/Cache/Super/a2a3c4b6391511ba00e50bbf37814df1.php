<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>园区物业管理总后台</title>
  <link rel="stylesheet" type="text/css" href="/Data/admin/css/login.css">
  <link rel="stylesheet" href="/Data/home/css/font.css">
  <link rel="stylesheet" href="/Data/home/css/xadmin.css">
  <script src="/Data/home/lib/layui/layui.js" charset="utf-8"></script>
  <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="/Data/home/js/xadmin.js"></script>
</head>
<body>
<div id="wrapper" class="login-page">
  <h1 style="color: blue; margin-left: 80px;margin-bottom: 20px">园区物业管理总后台</h1>
  <div id="login_form" class="form">
    <h2 style="display: inline-block; margin-bottom: 20px">登录</h2>
    <form method="post" class="layui-form" >
      <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" autocomplete="off">

      <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">

      <div class="layui-form-item item-verify">
        <input type="text" name="code" placeholder="验证码" required
               lay-verify="required" autocomplete="off" class="layui-input" style="width: 180px">
        <img id="captcha" src="<?php echo U('Login/verify',array('id' => 'a_login_1'));?>"
             onClick="this.src='<?php echo U('Login/verify',array('id' => 'a_login_1'));?>'"
             style="float:right; margin-top: -50px" alt="captcha"/>
      </div>
      <input class="layui-bg-black" value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">

    </form>
  </div>
</div>

<script type="text/javascript">
  $(function  () {
    layui.use('form', function(){
      var form = layui.form;
      // layer.msg('玩命卖萌中', function(){
      //   //关闭后的操作
      //   });
      //监听提交
      form.on('submit(login)', function(data){
        // JSON.stringify(data.field)
        //Ajax
        $.ajax({
          url:'toLogin',
          type:'post',
          data:data.field,
          dataType:"json",
          success:function(data){
            if (data.status == 1){
              layer.msg(data.info, function () {
                location.href = data.url;
              })
            }else{
              layer.msg(data.info);
              $('#captcha').attr('src', "<?php echo U('Login/verify',array('id' => 'a_login_1'));?>");
            }
          }
        });
        return false;
      });
    });
  })
</script>
</body>
</html>