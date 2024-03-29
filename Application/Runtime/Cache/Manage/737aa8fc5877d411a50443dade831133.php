<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>物业后台登录</title>
  <meta name="renderer" content="webkit|ie-comp|ie-stand">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport"
        content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
  <meta http-equiv="Cache-Control" content="no-siteapp"/>

  <link rel="shortcut icon" href="/Data/admin/favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" href="/Data/admin/css/font.css">
  <link rel="stylesheet" href="/Data/admin/css/xadmin.css">
  <script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
  <script src="/Data/admin/lib/layui/layui.js" charset="utf-8"></script>
  <script type="text/javascript" src="/Data/admin/js/xadmin.js"></script>

</head>
<body>
<!-- 顶部开始 -->
<div class="container">
  <div class="logo"><a href="index.html"><?php echo ($garden_name); ?></a></div>
  <div class="left_open">
    <i title="展开左侧栏" class="iconfont">&#xe699;</i>
  </div>
<!--  <ul class="layui-nav left fast-add" lay-filter="">-->
<!--    <li class="layui-nav-item">-->
<!--      <a href="javascript:;">+新增</a>-->
<!--      <dl class="layui-nav-child"> &lt;!&ndash; 二级菜单 &ndash;&gt;-->
<!--        <dd><a onclick="x_admin_show('资讯','http://www.baidu.com')"><i class="iconfont">&#xe6a2;</i>资讯</a></dd>-->
<!--        <dd><a onclick="x_admin_show('图片','http://www.baidu.com')"><i class="iconfont">&#xe6a8;</i>图片</a></dd>-->
<!--        <dd><a onclick="x_admin_show('用户','http://www.baidu.com')"><i class="iconfont">&#xe6b8;</i>用户</a></dd>-->
<!--      </dl>-->
<!--    </li>-->
<!--  </ul>-->
  <ul class="layui-nav right" lay-filter="">
    <li class="layui-nav-item">
      <a href="javascript:;" style="color: white;font-size: 15px"><?php echo ($USER['manager_name']); ?></a>
      <dl class="layui-nav-child"> <!-- 二级菜单 -->
        <dd><a onclick="x_admin_show('个人信息','user_edit', 800, 600)">个人信息</a></dd>
        <dd><a href="<?php echo U('Login/logout');?>">退出</a></dd>
      </dl>
    </li>
  </ul>

</div>
<!-- 顶部结束 -->
<!-- 中部开始 -->
<!-- 左侧菜单开始 -->
<div class="left-nav">
  <div id="side-nav">
    <ul id="nav">
      <li>
        <a href="javascript:;">
          <i class="iconfont">&#xe6eb;</i>
          <cite>主页</cite>
          <i class="iconfont nav_right">&#xe6a7;</i>
        </a>
        <ul class="sub-menu">
          <li><a _href="welcome"><i class="iconfont">&#xe6a7;</i><cite>欢迎台</cite></a></li>
        </ul>
      </li>
      <li>
        <a href="javascript:;">
          <i class="iconfont">&#xe6b8;</i>
          <cite>租户管理</cite>
          <i class="iconfont nav_right">&#xe6a7;</i>
        </a>
        <ul class="sub-menu">
          <li>
            <a _href="<?php echo U('Customer/index');?>">
              <i class="iconfont">&#xe6a7;</i>
              <cite>租户列表</cite>

            </a>
          </li>
<!--          <li>-->
<!--            <a _href="<?php echo U('Customer/customer_del');?>">-->
<!--              <i class="iconfont">&#xe6a7;</i>-->
<!--              <cite>租户删除</cite>-->
<!--            </a>-->
<!--          </li>-->
        </ul>
      </li>
      <li>
        <a href="javascript:;">
          <i class="iconfont">&#xe69e;</i>
          <cite>房间管理</cite>
          <i class="iconfont nav_right">&#xe6a7;</i>
        </a>
        <ul class="sub-menu">
          <li>
            <a _href="<?php echo U('Room/index');?>">
              <i class="iconfont">&#xe6a7;</i>
              <cite>房间列表</cite>
            </a>
          </li>
        </ul>
      </li>
      <li>
        <a href="javascript:;">
          <i class="iconfont">&#xe726;</i>
          <cite>租务管理</cite>
          <i class="iconfont nav_right">&#xe6a7;</i>
        </a>
        <ul class="sub-menu">
          <li>
            <a _href="<?php echo U('Water/index');?>">
              <i class="iconfont">&#xe6a7;</i>
              <cite>水表管理</cite>
            </a>
          </li>
          <li>
            <a _href="<?php echo U('Power/index');?>">
              <i class="iconfont">&#xe6a7;</i>
              <cite>电表管理</cite>
            </a>
          </li>
          <li>
            <a _href="<?php echo U('Lease/index');?>">
              <i class="iconfont">&#xe6a7;</i>
              <cite>租赁</cite>
            </a>
          </li>
          <li>
            <a _href="<?php echo U('Bill/index');?>">
              <i class="iconfont">&#xe6a7;</i>
              <cite>账单</cite>
            </a>
          </li>
          <li>
            <a _href="<?php echo U('Repair/index');?>">
              <i class="iconfont">&#xe6a7;</i>
              <cite>报修处理</cite>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<!-- <div class="x-slide_left"></div> -->
<!-- 左侧菜单结束 -->
<!-- 右侧主体开始 -->
<div class="page-content">
  <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
    <ul class="layui-tab-title">
      <li class="home"><i class="layui-icon">&#xe68e;</i>欢迎页</li>
    </ul>
    <div class="layui-tab-content">
      <div class="layui-tab-item layui-show">
        <iframe src="<?php echo U('Index/welcome');?>" frameborder="0" scrolling="yes" class="x-iframe"></iframe>
      </div>
    </div>
  </div>
</div>
<div class="page-content-bg"></div>
<!-- 右侧主体结束 -->
<!-- 中部结束 -->
<!-- 底部开始 -->
<!--<div class="footer">
    <div class="copyright">Copyright ©2019 L-admin v2.3 All Rights Reserved</div>
</div>-->
<!-- 底部结束 -->
</body>
</html>