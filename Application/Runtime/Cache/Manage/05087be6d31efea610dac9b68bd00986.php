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

<body class="layui-anim layui-anim-up">
<div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">租务管理</a>
        <a href="">电表管理</a>
        <!--        <a>-->
        <!--          <cite>导航元素</cite></a>-->
      </span>
  <a class="layui-btn layui-btn-primary layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
     href="javascript:location.replace(location.href);" title="刷新">
    <i class="layui-icon" style="line-height:38px">ဂ</i></a>
</div>
<div class="x-body">
  <div class="chu">
    <div class="demoTable layui-form-item">
      <div class="layui-inline">
        <!--            <label class="layui-form-label">查询条件:</label>-->
        <div class="layui-input-inline">
          <input class="layui-input" name="search" id="search" placeholder="房间号" autocomplete="off">
        </div>
        <!--        <label class="layui-form-label">租期类型:</label>-->
        <!--        <div class="layui-input-inline">-->
        <!--          <select class="layui-select" id="leaseTeam" name="leaseTeam" lay-filter="Team">-->
        <!--            <option value="">请选择</option>-->
        <!--            <option value="1">一季度</option>-->
        <!--            <option value="2">半年</option>-->
        <!--            <option value="3">一年</option>-->
        <!--          </select>-->
        <!--        </div>-->
      </div>
      <div class="layui-btn" data-type="reload">搜索</div>
      <div class="layui-btn layui-btn-warm" id="reset">重置</div>
    </div>
  </div>
  <xblock>
    <!--        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>-->
    <button class="layui-btn" onclick="x_admin_show('添加租赁信息','lease_add',600,500)"><i class="layui-icon"></i>添加
    </button>
  </xblock>
  <input type="hidden" id="update_power_id" value="0">
  <table class="layui-table" id="demo" lay-filter="test">
    <!--        <thead>-->
    <!--          <tr>-->
    <!--            <th>-->
    <!--              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>-->
    <!--            </th>-->
    <!--            <th>ID</th>-->
    <!--            <th>用户名</th>-->
    <!--            <th>性别</th>-->
    <!--            <th>手机</th>-->
    <!--            <th>邮箱</th>-->
    <!--            <th>地址</th>-->
    <!--            <th>加入时间</th>-->
    <!--            <th>状态</th>-->
    <!--            <th>操作</th></tr>-->
    <!--        </thead>-->
    <!--        <tbody>-->
    <!--          <tr>-->
    <!--            <td>-->
    <!--              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='2'><i class="layui-icon">&#xe605;</i></div>-->
    <!--            </td>-->
    <!--            <td>1</td>-->
    <!--            <td>小明</td>-->
    <!--            <td>男</td>-->
    <!--            <td>13000000000</td>-->
    <!--            <td>admin@mail.com</td>-->
    <!--            <td>北京市 海淀区</td>-->
    <!--            <td>2017-01-01 11:11:42</td>-->
    <!--            <td class="td-status">-->
    <!--              <span class="layui-btn layui-btn-normal layui-btn-sm">已启用</span></td>-->
    <!--            <td class="td-manage">-->
    <!--              <a onclick="member_stop(this,'10001')" class="layui-btn layui-btn-sm layui-btn-primary" href="javascript:;"  title="启用">-->
    <!--              启用-->
    <!--              </a>-->
    <!--              <a title="编辑" class="layui-btn layui-btn-sm layui-btn-normal"  onclick="x_admin_show('编辑','customer_edit',600,400)" href="javascript:;">-->
    <!--                编辑-->
    <!--              </a>-->
    <!--              <a  class="layui-btn layui-btn-sm layui-btn-warm" onclick="x_admin_show('修改密码','customer_password',600,400)" title="修改密码" href="javascript:;">-->
    <!--                修改密码-->
    <!--              </a>-->
    <!--              <a title="删除" class="layui-btn layui-btn-sm layui-btn-danger" onclick="member_del(this,'要删除的id')" href="javascript:;">-->
    <!--                删除-->
    <!--              </a>-->
    <!--            </td>-->
    <!--          </tr>-->
    <!--        </tbody>-->
  </table>
  <!--      <div class="page">-->
  <!--        <div>-->
  <!--          <a class="prev" href="">&lt;&lt;</a>-->
  <!--          <a class="num" href="">1</a>-->
  <!--          <span class="current">2</span>-->
  <!--          <a class="num" href="">3</a>-->
  <!--          <a class="num" href="">489</a>-->
  <!--          <a class="next" href="">&gt;&gt;</a>-->
  <!--        </div>-->
  <!--      </div>-->

</div>

<!--    <script type="text/html" id="toolbarDemo">-->
<!--      <div class="layui-btn-container">-->
<!--        <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>-->
<!--        <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>-->
<!--        <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>-->
<!--      </div>-->
<!--    </script>-->

<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
  <a class="layui-btn layui-btn-xs" lay-event="readMeter" style="background: cornflowerblue">抄表</a>
</script>
<script>
  layui.use(['table', 'layer', 'form'], function () {
    var table = layui.table;
    layer = layui.layer;
    form = layui.form;
    //第一个实例
    table.render({
      elem: '#demo',
      height: 450,
      url: 'getPowerList',  //数据接口
      page: true, //开启分页
      cols: [
        [ //表头
          {fixed: 'left', type: 'checkbox'},
          {field: 'power_id', width: '5%', title: 'Id', align: 'center', sort: 'true'},
          {field: 'room_sn', width: '6%', title: '房屋', align: 'center', sort: 'true'},
          {field: 'power_sn', width: '6%', title: '电表', align: 'center', sort: 'true'},
          {field: 'p_current', width: '9%', title: '初始读数', align: 'center', sort: 'true'},
          {field: 'p_time', width: '12%', title: '初始抄表时间', align: 'center', sort: 'true'},
          {field: 'plast_current', width: '9%', title: '上次读数', align: 'center', sort: 'true'},
          {field: 'plast_time', width: '12%', title: '上次抄表时间', align: 'center', sort: 'true'},
          {field: 'p_price', width: '7%', title: '元/度', align: 'center', sort: 'true'},
          {field: 'create_time', width: '15%', title: '创建时间', align: 'center', sort: 'true'},
          {fixed: 'right', width: '18%', title: '操作', align: 'center', toolbar: '#barDemo'}
        ]
      ],
      id: 'demo'
    });
    var $ = layui.$, active = {
      reload: function () {
        var search = $('#search').val();
        // var leaseTeam = $('#leaseTeam').val();
        table.reload('demo', {
          url: 'getPowerList',
          method: 'get',
          page: {
            curr: 1
          },
          where: {
            key1: search
            // key2: leaseTeam
          }
        })
      }
    }
    $('.chu .layui-btn').on('click', function () {         //搜索点击功能
      var type = $(this).data('type');
      // if($('#customer_name').val()==""){
      //   layer.msg('查询项目不能为空');
      //   return false;
      // }
      active[type] ? active[type].call(this) : '';
    });

    //重置功能
    $('#reset').on('click', function () {
      $('#search').val("");
      $('#leaseTeam').val("");
    });

    table.on('tool(test)', function (obj) {
      var data = obj.data;
      var layEvent = obj.event;
      var tr = obj.tr;

      if (layEvent === 'del') {
        layer.confirm('确认解除当前电表嘛？', {
          title: '解除电表'
        }, function (index) {
          obj.del();
          layer.close(index);
          $.ajax({
            url: 'deletePower?powerId=' + data.power_id,
            type: 'get',
            dataType: "JSON",
            success: function (data) {
              if (data.code == 200) {
                layer.msg(data.msg);
              } else {
                //删除失败刷新表单
                layer.msg(data.msg, {icon: 2, time: 1000}, function () {
                  setTimeout('window.location.reload()', 1000);
                });
                // layer.alert(data.msg);
              }
            }
          })
        });
      } else if (layEvent === 'edit') {
        //隐藏域存放customer_id
        $('#update_power_id').val(data.power_id);
        x_admin_show('编辑电表信息', 'power_edit', 600, 500);
      } else if (layEvent === 'readMeter') {

      }
    })
  });
</script>

</body>

</html>