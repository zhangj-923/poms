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
        <a href="">账单</a>
        <!--        <a>-->
        <!--          <cite>导航元素</cite></a>-->
      </span>
  <a class="layui-btn layui-btn-primary layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right"
     href="javascript:location.replace(location.href);" title="刷新">
    <i class="layui-icon" style="line-height:38px">ဂ</i></a>
</div>
<div class="x-body">
  <form class="layui-form">
    <div class="demoTable layui-form-item">
      <div class="layui-inline">
        <div class="layui-input-inline">
          <input class="layui-input" name="search" id="search" placeholder="租户姓名/房间号/账单备注" autocomplete="off">
        </div>
        <label class="layui-form-label">账单周期:</label>
        <div class="layui-input-inline">
          <input type="text" name="last_time" id="last_time"  placeholder="开始日期" autocomplete="off"
                 class="layui-input">
        </div>
        <label class="layui-form-label" style="margin-left: -80px">--</label>
        <div class="layui-input-inline">
          <input type="text" name="time" id="time"  placeholder="截止日期" autocomplete="off"
                 class="layui-input">
        </div>
        <label class="layui-form-label">账单类型:</label>
        <div class="layui-input-inline">
          <select class="layui-select" id="leaseTeam" name="leaseTeam" lay-filter="Team">
            <option value="">请选择</option>
            <option value="1">房租</option>
            <option value="2">水费</option>
            <option value="3">电费</option>
          </select>
        </div>
      </div>
      <button class="layui-btn" data-type="reload" lay-submit lay-filter="search">搜索</button>
      <!--      <button type="reset" class="layui-btn layui-btn-primary">重置</button>-->
      <div class="layui-btn layui-btn-warm" id="reset" name="reset" style="background: gray">重置</div>
    </div>
  </form>
<!--  <div class="chu">-->
<!--    <div class="demoTable layui-form-item">-->
<!--      <div class="layui-inline">-->
<!--        &lt;!&ndash;            <label class="layui-form-label">查询条件:</label>&ndash;&gt;-->
<!--        <div class="layui-input-inline">-->
<!--          <input class="layui-input" name="search" id="search" placeholder="租户姓名/房间号" autocomplete="off">-->
<!--        </div>-->
<!--        <label class="layui-form-label">账单类型:</label>-->
<!--        <div class="layui-input-inline">-->
<!--          <select class="layui-select" id="leaseTeam" name="leaseTeam" lay-filter="Team">-->
<!--            <option value="">请选择</option>-->
<!--            <option value="1">房租</option>-->
<!--            <option value="2">水费</option>-->
<!--            <option value="3">电费</option>-->
<!--          </select>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="layui-btn" data-type="reload">搜索</div>-->
<!--      <div class="layui-btn layui-btn-warm" id="reset">重置</div>-->
<!--    </div>-->
<!--  </div>-->
  <xblock>
    <!--        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>-->
    <button class="layui-btn" onclick="x_admin_show('添加租赁信息','lease_add',600,500)"><i class="layui-icon"></i>添加
    </button>
  </xblock>
  <input type="hidden" id="update_lease_id" value="0">
  <table class="layui-table" id="demo" lay-filter="test">
    <!--        <thead>-->
    <!--          <tr>-->
    <!--            <th>-->
    <!--              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>-->
    <!--                   修改密码-->
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


</script>
<script>
  layui.use(['table', 'layer', 'form', 'laydate'], function () {
    var table = layui.table;
    layer = layui.layer;
    form = layui.form;
    laydate = layui.laydate;
    //第一个实例
    table.render({
      elem: '#demo',
      height: 450,
      url: 'getBillList',  //数据接口
      page: true, //开启分页
      cols: [
        [ //表头
          {fixed: 'left', type: 'checkbox'},
          {field: 'bill_id', width: '5%', title: 'Id', align: 'center', sort: 'true'},
          {field: 'bill_cycle', width: '11%', title: '账单周期', align: 'center', sort: 'true'},
          {field: 'garden_name', width: '6%', title: '园区', align: 'center', sort: 'true'},
          {field: 'roomInfo', width: '10%', title: '房屋信息', align: 'center', sort: 'true'},
          {field: 'type', width: '5%', title: '收费项', align: 'center', sort: 'true'},
          {field: 'manager_name', width: '5%', title: '收款方', align: 'center', sort: 'true'},
          {field: 'total', width: '6%', title: '账单金额', align: 'center', sort: 'true'},
          {field: 'customer_name', width: '5%', title: '承租方', align: 'center', sort: 'true'},
          {field: 'customer_mobile', width: '7%', title: '联系电话', align: 'center', sort: 'true'},
          {field: 'status', width: '6%', title: '支付状态', align: 'center', sort: 'true',  templet: '#statusTpl'},
          {field: 'pay_time', width: '10%', title: '支付日期', align: 'center', sort: 'true'},
          {field: 'bill_remark', width: '15%', title: '账单备注', align: 'center', sort: 'true'},
          {field: 'create_time', width: '15%', title: '创建时间', align: 'center', sort: 'true'},
          {fixed: 'right', width: '10%', title: '操作', align: 'center', toolbar: '#barDemo'}
        ]
      ],
      id: 'demo'
    });

    //日期
    laydate.render({
      elem: '#time'
    });

    //日期
    laydate.render({
      elem: '#last_time'
    });


    var $ = layui.$, active = {
      reload: function () {
        var search = $('#search').val();
        var leaseTeam = $('#leaseTeam').val();
        var last_time = $('#last_time').val();
        var time = $('#time').val();
        table.reload('demo', {
          url: 'getBillList',
          method: 'get',
          page: {
            curr: 1
          },
          where: {
            key1: search,
            key2: leaseTeam,
            last_time: last_time,
            time: time
          }
        })
      }
    }

    form.on('submit(search)', function (data) {
      var type = $(this).data('type');
      // if($('#customer_name').val()==""){
      //   layer.msg('查询项目不能为空');
      //   return false;
      // }
      active[type] ? active[type].call(this) : '';
      return false;
    });

    // $('.chu .layui-btn').on('click', function () {         //搜索点击功能
    //   var type = $(this).data('type');
    //   // if($('#customer_name').val()==""){
    //   //   layer.msg('查询项目不能为空');
    //   //   return false;
    //   // }
    //   active[type] ? active[type].call(this) : '';
    // });

    //重置功能
    $('#reset').on('click', function () {
      $('#search').val("");
      $('#leaseTeam').val("");
      $('#last_time').val("");
      $('#time').val("");
      form.render();
    });

    table.on('tool(test)', function (obj) {
      var data = obj.data;
      var layEvent = obj.event;
      var tr = obj.tr;

      if (layEvent === 'del') {
        layer.confirm('确认解除当前租赁关系？解除即释放当前房屋状态', function (index) {
          obj.del();
          layer.close(index);
          $.ajax({
            url: 'deleteLease?leaseId=' + data.lease_id,
            type: 'get',
            dataType: "JSON",
            success: function (data) {
              if (data.code == 200) {
                layer.msg(data.msg);
              } else {
                layer.alert(data.msg);
              }
            }
          })
        });
      } else if (layEvent === 'edit') {
        //隐藏域存放customer_id
        $('#update_lease_id').val(data.lease_id);
        x_admin_show('编辑租赁关系', 'lease_edit', 600, 500);
      }
    })
  });
</script>
<script>
  layui.use('laydate', function () {
    var laydate = layui.laydate;

    //执行一个laydate实例
    laydate.render({
      elem: '#start' //指定元素
    });

    //执行一个laydate实例
    laydate.render({
      elem: '#end' //指定元素
    });
  });

  /*用户-停用*/
  function member_stop (obj, id) {
    layer.confirm('确认要停用吗？', function (index) {

      if ($(obj).attr('title') == '启用') {

        //发异步把用户状态进行更改
        $(obj).attr('title', '停用')
        $(obj).find('i').html('&#xe62f;');

        $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
        layer.msg('已停用!', {icon: 5, time: 1000});

      } else {
        $(obj).attr('title', '启用')
        $(obj).find('i').html('&#xe601;');

        $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
        layer.msg('已启用!', {icon: 5, time: 1000});
      }

    });
  }

  /*用户-删除*/
  function member_del (obj, id) {
    layer.confirm('确认要删除吗？', function (index) {
      //发异步删除数据
      $(obj).parents("tr").remove();
      layer.msg('已删除!', {icon: 1, time: 1000});
    });
  }


  function delAll (argument) {

    var data = tableCheck.getData();

    layer.confirm('确认要删除吗？' + data, function (index) {
      //捉到所有被选中的，发异步进行删除
      layer.msg('删除成功', {icon: 1});
      $(".layui-form-checked").not('.header').parents('tr').remove();
    });
  }
</script>
<script type="text/html" id="statusTpl">
  {{#  if(d.status === '未支付'){ }}
  <span style="color: red;">{{ d.status }}</span>
  {{#  } else { }}
  {{ d.status }}
  {{#  } }}
</script>
</body>

</html>