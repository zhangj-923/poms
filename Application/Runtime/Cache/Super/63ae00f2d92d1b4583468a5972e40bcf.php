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
        <a href="">园区管理</a>
        <a href="">楼宇列表</a>
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
        <label class="layui-form-label">园区名称:</label>
        <div class="layui-input-inline">
          <select class="layui-select" id="selectId" name="selectId" lay-filter="garden">
            <option value="">请选择</option>
          </select>
        </div>
        <label class="layui-form-label">楼宇名称:</label>
        <div class="layui-input-inline">
          <input class="layui-input" name="building" id="building" placeholder="楼宇名称" autocomplete="off">
        </div>
      </div>
      <div class="layui-btn" data-type="reload">搜索</div>
      <div class="layui-btn layui-btn-warm" id="reset">重置</div>
    </div>
  </div>
  <xblock>
    <!--        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>-->
    <button class="layui-btn" onclick="x_admin_show('添加楼宇','building_add',600,400)"><i class="layui-icon"></i>添加</button>
  </xblock>
  <input type="hidden" id="building_id" value="0">
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
      url: 'getBuildingList',  //数据接口
      page: true, //开启分页
      cols: [
        [ //表头
          {fixed: 'left', type: 'checkbox'},
          {field: 'building_id', width: '5%', title: 'Id', align: 'center', sort: 'true'},
          {field: 'garden_name', width: '10%', title: '园区名称', align: 'center', sort: 'true'},
          {field: 'building_name', width: '10%', title: '楼宇名称', align: 'center', sort: 'true'},
          {field: 'create_time', width: '20%', title: '创建时间', align: 'center', sort: 'true'},
          {fixed: 'right', title: '操作', align: 'center', toolbar: '#barDemo'}
        ]
      ],
      id: 'demo'
    });
    var $ = layui.$, active = {
      reload: function () {
        var selectId = $('#selectId').val();
        var building = $('#building').val();
        table.reload('demo', {
          url: 'getBuildingList',
          method: 'get',
          page: {
            curr: 1
          },
          where: {
            key1: selectId,
            key2: building
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
      $('#selectId').val("");
      $('#building').val("");
    });

    $.ajax({
      url: "<?php echo U('Public/getGardenData');?>",
      success: function (data) {
        $.each($.parseJSON(data), function (index, item) {
          // console.log(item);
          //option  第一个参数是页面显示的值，第二个参数是传递到后台的值
          $('#selectId').append(new Option(item.garden_name, item.garden_id));//往下拉菜单里添加元素
          //设置value（这个值就可以是在更新的时候后台传递到前台的值）为2的值为默认选中
          // $('#selectId').val(1);
        })
        form.render(); //更新全部表单内容
        //form.render('select'); //刷新表单select选择框渲染
      }
    });


    table.on('tool(test)', function (obj) {
      var data = obj.data;
      var layEvent = obj.event;
      var tr = obj.tr;

      if (layEvent === 'del') {
        layer.confirm('确认删除当前楼宇？ 会对应删除所属楼宇管理员', {
          title: '删除'
        }, function (index) {
          obj.del();
          layer.close(index);
          $.ajax({
            url: 'deleteBuilding?buildingId=' + data.building_id,
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
        //隐藏域存放building_id
        $('#building_id').val(data.building_id);
        x_admin_show('编辑楼宇', 'building_edit', 600, 300);
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
</body>

</html>