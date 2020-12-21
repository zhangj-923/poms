<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" xmlns:th="http://www.thymeleaf.org">
<head>
  <meta charset="UTF-8">
  <title>园区登录</title>
  <meta name="renderer" content="webkit|ie-comp|ie-stand">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
  <meta http-equiv="Cache-Control" content="no-siteapp" />

  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="/Data/home/css/font.css">
  <link rel="stylesheet" href="/Data/home/css/xadmin.css">
  <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
  <script src="/Data/home/lib/layui/layui.js" charset="utf-8"></script>
  <script type="text/javascript" src="/Data/home/js/xadmin.js"></script>

</head>
<body class="login-bg">

<div class="login layui-anim layui-anim-up">
  <div class="message layui-bg-black">物业登录</div>
  <div id="darkbannerwrap"></div>

  <form method="post" class="layui-form" >
    <input name="name" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" autocomplete="off">
    <hr class="hr15">
    <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
    <hr class="hr15">
    <div class="layui-form-item item-verify">
      <input type="text" name="code" placeholder="验证码" required
             lay-verify="required" autocomplete="off" class="layui-input" style="width: 180px">
      <img id="captcha" src="<?php echo U('Login/verify',array('id' => 'a_login_1'));?>"
           onClick="this.src='<?php echo U('Login/verify',array('id' => 'a_login_1'));?>'"
           style="float:right; margin-top: -50px" alt="captcha"/>
    </div>
    <input class="layui-bg-black" value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
    <hr class="hr20" >
  </form>
</div>



<script>
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





<!-- 底部结束 -->
</body>
</html>