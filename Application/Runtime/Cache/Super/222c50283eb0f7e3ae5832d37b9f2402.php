<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>后台管理模板</title>
  <link rel="stylesheet" href="/Data/pull/plugins/layui/css/layui.css" media="all" />
  <link rel="stylesheet" href="/Data/pull/css/main.css"  media="all"  />
  <!--[if lt IE 9]>
  <script src="Data/static/js/html5shiv.min.js"></script>
  <script src="Data/static/js/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript" src="/Data/pull/plugins/layui/layui.js"></script>
</head>
<body>
<!--主体-->
<div style="margin-bottom:36px;">
  <div class="tpt—index fly-panel fly-panel-user">
    <blockquote style="padding: 10px;border-left: 5px solid #009688;" class="layui-elem-quote">个人信息：</blockquote>
    <table width="100%">
      <tr><td width="110px">用户名</td><td><?php echo ($ADMIN['realname']); ?></td></tr>
      <tr><td width="110px">联系方式</td><td><?php echo ($ADMIN['tel']); ?></td></tr>
      <tr><td>用户组</td><td>超级管理员</td></tr>
<!--      <tr><td>上次登录时间</td><td><?php echo (session('yang_adm_logintime')); ?></td></tr>-->
<!--      <tr><td>上次登录IP</td><td><?php echo (session('yang_adm_loginip')); ?></td></tr>-->
<!--      <tr><td>登录次数</td><td><?php echo (session('yang_adm_loginnum')); ?></td></tr>-->
    </table>
    <blockquote style="padding: 10px;border-left: 5px solid #009688;" class="layui-elem-quote">系统信息：</blockquote>
    <table width="100%">
      <tr><td width="110px">程序版本</td><td>园区物业管理系统 </td></tr>
      <tr><td>服务器类型</td><td><?php echo ($os); ?></td></tr>
      <tr><td>服务器软件</td><td><?php echo ($software); ?></td></tr>
      <tr><td>MySQL版本</td><td><?php echo ($mysql_ver); ?></td></tr>
<!--      <tr><td>上传文件大小</td><td><?php echo ($environment_upload); ?></td></tr>-->
    </table>
    <blockquote style="padding: 10px;border-left: 5px solid #009688;" class="layui-elem-quote">开发团队：</blockquote>
    <table width="100%">
      <tr><td width="110px">版权所有</td><td>福州大学至诚学院计算机工程系软件工程毕业设计</td></tr>
      <tr><td>特别提醒您</td><td>严禁删除、隐藏或更改版权信息，否则导致的一切损失由使用者自行承担。</td></tr>
    </table>
  </div>
</div>
</body>
</html>