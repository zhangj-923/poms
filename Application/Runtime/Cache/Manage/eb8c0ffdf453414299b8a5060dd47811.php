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
        <a href="">租赁</a>
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
          <input class="layui-input" name="search" id="search" placeholder="租户姓名/房间号" autocomplete="off">
        </div>
        <label class="layui-form-label">租赁状态:</label>
        <div class="layui-input-inline">
          <select class="layui-select" id="leaseCycle" name="leaseCycle" lay-filter="Team">
            <option value="">请选择</option>
            <option value="1">生效中</option>
            <option value="2">已到期</option>
            <option value="3">已退租</option>
          </select>
        </div>
        <label class="layui-form-label">租期类型:</label>
        <div class="layui-input-inline">
          <select class="layui-select" id="leaseTeam" name="leaseTeam" lay-filter="Team">
            <option value="">请选择</option>
            <option value="1">一季度</option>
            <option value="2">半年</option>
            <option value="3">一年</option>
            <option value="4">其他</option>
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
  <!--        <label class="layui-form-label">租期类型:</label>-->
  <!--        <div class="layui-input-inline">-->
  <!--          <select class="layui-select" id="leaseTeam" name="leaseTeam" lay-filter="Team">-->
  <!--            <option value="">请选择</option>-->
  <!--            <option value="1">一季度</option>-->
  <!--            <option value="2">半年</option>-->
  <!--            <option value="3">一年</option>-->
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
    <button class="layui-btn" id="createBill">房租账单</button>
  </xblock>
  <input type="hidden" id="update_lease_id" value="0">
  <table class="layui-table" id="demo" lay-filter="test">
    <!--        <thead>-->
    <!--          <tr>-->
    <!--            <th>-->
    <!--              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>-->
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
  {{#  if(d.lease_status !== '已退租'){ }}
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="exit">退租</a>
  {{#  } }}
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
      url: 'getLeaseList',  //数据接口
      page: true, //开启分页
      cols: [
        [ //表头
          {fixed: 'left', type: 'checkbox'},
          {field: 'lease_id', width: '4%', title: 'Id', align: 'center', sort: 'true'},
          {field: 'lease_status', width: '6%', title: '租赁状态', align: 'center', sort: 'true', templet: '#statusTpl'},
          {field: 'customer_name', width: '5%', title: '租户', align: 'center', sort: 'true'},
          {field: 'customer_mobile', width: '7%', title: '联系方式', align: 'center', sort: 'true'},
          {field: 'garden_name', width: '5%', title: '园区', align: 'center', sort: 'true'},
          {field: 'building_name', width: '5%', title: '楼宇', align: 'center', sort: 'true'},
          {field: 'room_sn', width: '5%', title: '房屋', align: 'center', sort: 'true'},
          {field: 'team', width: '5%', title: '租期', align: 'center', sort: 'true'},
          {field: 'create_time', width: '10%', title: '签约时间', align: 'center', sort: 'true'},
          {field: 'sing_time', width: '7%', title: ' 开始时间', align: 'center', sort: 'true'},
          {field: 'expire_time', width: '7%', title: ' 到期时间', align: 'center', sort: 'true', style: 'color: red;'},
          {field: 'rent', width: '6%', title: '月租金', align: 'center', sort: 'true'},
          {field: 'total_rent', width: '6%', title: '总金额', align: 'center', sort: 'true'},
          {field: 'exit_time', width: '7%', title: '退租时间', align: 'center', sort: 'true'},
          // {field: 'remark', width: '15%', title: '备注', align: 'center', sort: 'true'},
          {fixed: 'right', width: '13%', title: '操作', align: 'center', toolbar: '#barDemo'}
        ]
      ],
      id: 'demo'
    });
    var $ = layui.$, active = {
      reload: function () {
        var search = $('#search').val();
        var leaseTeam = $('#leaseTeam').val();
        var leaseCycle = $('#leaseCycle').val();
        table.reload('demo', {
          url: 'getLeaseList',
          method: 'get',
          page: {
            curr: 1
          },
          where: {
            key1: search,
            key2: leaseTeam,
            key3: leaseCycle
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

    //重置功能
    $('#reset').on('click', function () {
      $('#search').val("");
      $('#leaseCycle').val("");
      $('#leaseTeam').val("");
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
              table.reload('demo');
            }
          })
        });
      } else if (layEvent === 'edit') {
        //隐藏域存放customer_id
        $('#update_lease_id').val(data.lease_id);
        x_admin_show('编辑租赁关系', 'lease_edit', 600, 500);
      } else if (layEvent === 'exit') {
        layer.confirm('是否确认申请退租？？', {
          title: '退租'
        }, function (index) {
          $.ajax({
            url: 'exitLease',
            type: 'post',
            data: {'lease_id': data.lease_id},
            dataType: "JSON",
            success: function (data) {
              if (data.code == 200) {
                layer.msg(data.msg);
              } else {
                layer.alert(data.msg);
              }
              table.reload('demo');
            }
          })
        })
      }
    })

    $('#createBill').on('click', function () {
      layer.confirm('是否批量生成当月房租账单？', {
        title: '房租账单'
      }, function (index) {
        // var datas1 = new Array();
        // datas = table.cache["demo"];
        // console.log(datas);
        // for (i = 0; i < datas.length; i++) {
        //   datas1.push(datas[i].lease_id);
        // }
        // layer.close(index);
        $.ajax({
          url: 'createBill',
          type: 'post',
          dataType: "JSON",
          success: function (data) {
            if (data.code == 200) {
              layer.msg(data.msg);
            } else {
              layer.alert(data.msg);
            }
          }
        })
      })
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


</script>
<script type="text/html" id="statusTpl">
  {{#  if(d.lease_status === '已到期'){ }}
  <span style="color: red;">{{ d.lease_status }}</span>
  {{#  } else { }}
  {{ d.lease_status }}
  {{#  } }}
</script>
</body>

</html>