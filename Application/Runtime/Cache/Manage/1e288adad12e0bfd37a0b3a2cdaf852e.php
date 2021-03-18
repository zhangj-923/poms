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
  <script type="text/javascript" src="/Data/admin/layui/layui.js"></script>
</head>
<body>
<div class="x-body layui-anim layui-anim-up">
  <blockquote class="layui-elem-quote">欢迎管理员：
    <span class="x-red"><?php echo ($USER['manager_name']); ?></span>！当前时间: <?php echo ($now); ?>
  </blockquote>
  <blockquote class="layui-elem-quote">
    <form class="layui-form">
      <div class="demoTable layui-form-item">
        <div class="layui-inline">
          <label class="layui-form-label">账单类型:</label>
          <div class="layui-input-inline">
            <select class="layui-select" id="type" name="type" lay-filter="Team">
              <option value="1">全部时间</option>
              <option value="2">本月</option>
              <option value="3">本年</option>
            </select>
          </div>
          <label class="layui-form-label">账单周期:</label>
          <div class="layui-input-inline">
            <input type="text" name="last_time" id="last_time" placeholder="开始日期" autocomplete="off"
                   class="layui-input">
          </div>
          <label class="layui-form-label" style="margin-left: -80px">--</label>
          <div class="layui-input-inline">
            <input type="text" name="time" id="time" placeholder="截止日期" autocomplete="off"
                   class="layui-input">
          </div>
        </div>
        <button class="layui-btn" data-type="reload" lay-submit lay-filter="search">搜索</button>
        <div class="layui-btn layui-btn-warm" id="reset" name="reset" style="background: gray">重置</div>
      </div>
    </form>
  </blockquote>
  <fieldset class="layui-elem-field">
    <legend>数据统计</legend>
    <form class="layui-form">
      <div class="layui-field-box">
        <div class="layui-col-md12">
          <div class="layui-card">
            <div class="layui-card-body">
              <div class="layui-carousel x-admin-carousel x-admin-backlog" lay-anim="" lay-indicator="inside"
                   lay-arrow="none" style="width: 100%; height: 270px;">
                <div carousel-item="" style="height: 90px; width: 100%">
                  <ul class="layui-row layui-col-space10 layui-this">
                    <li class="layui-col-xs3">
                      <a href="javascript:;" class="x-admin-backlog-body">
                        <h4 style="color: black">总房间数</h4>
                        <p>
                          <cite style="font-size: 22px;color: limegreen;font-weight: bold"><?php echo ($room['count1']); ?></cite></p>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="javascript:;" class="x-admin-backlog-body">
                        <h4 style="color: black">空置房间数</h4>
                        <p>
                          <cite style="font-size: 22px;color: limegreen;font-weight: bolder"><?php echo ($room['count3']); ?></cite>
                        </p>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="javascript:;" class="x-admin-backlog-body">
                        <h4 style="color: red">已租房间数</h4>
                        <p>
                          <cite style="font-size: 22px;color: limegreen;font-weight: bolder"><?php echo ($room['count2']); ?></cite>
                        </p>
                      </a>
                    </li>
                  </ul>
                </div>
                <div carousel-item="" style="height: 90px; width: 100%">
                  <ul class="layui-row layui-col-space10 layui-this">
                    <li class="layui-col-xs3">
                      <a href="javascript:;" class="x-admin-backlog-body">
                        <h4 style="color: black">应收房租账单</h4>
                        <p id="lease">
                          <cite><?php echo ($data['leaseTotal']); ?></cite></p>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="javascript:;" class="x-admin-backlog-body">
                        <h4 style="color: black">应收水费账单</h4>
                        <p id="water">
                          <cite><?php echo ($data['waterTotal']); ?></cite></p>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="javascript:;" class="x-admin-backlog-body">
                        <h4 style="color: black">应收电费账单</h4>
                        <p id="power">
                          <cite></cite></p>
                      </a>
                    </li>
                  </ul>
                </div>
                <div carousel-item="" style="height: 90px; width: 100%">
                  <ul class="layui-row layui-col-space10 layui-this">
                    <li class="layui-col-xs3">
                      <a href="javascript:;" class="x-admin-backlog-body">
                        <h4 style="color: red">已收房租账单</h4>
                        <p id="payLease">
                          <cite><?php echo ($data['leaseTotal']); ?></cite></p>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="javascript:;" class="x-admin-backlog-body">
                        <h4 style="color: red">已收水费账单</h4>
                        <p id="payWater">
                          <cite></cite></p>
                      </a>
                    </li>
                    <li class="layui-col-xs3">
                      <a href="javascript:;" class="x-admin-backlog-body">
                        <h4 style="color: red">已收电费账单</h4>
                        <p id="payPower">
                          <cite></cite></p>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </fieldset>
  <fieldset class="layui-elem-field">
    <legend>系统信息</legend>
    <div class="layui-field-box">
      <table class="layui-table">
        <tbody>
        <tr>
          <th>园区物业系统</th>
          <td>1.0.0</td>
        </tr>
        <tr>
          <th>操作系统</th>
          <td><?php echo ($os); ?></td>
        </tr>
        <tr>
          <th>运行环境</th>
          <td><?php echo ($software); ?></td>
        </tr>
        <tr>
          <th>PHP版本</th>
          <td><?php echo ($phpversion); ?></td>
        </tr>
        <tr>
          <th>MYSQL版本</th>
          <td><?php echo ($mysql_ver); ?></td>
        </tr>
        <tr>
          <th>ThinkPHP</th>
          <td>5.0.18</td>
        </tr>
        </tbody>
      </table>
    </div>
  </fieldset>
  <fieldset class="layui-elem-field">
    <legend>开发团队</legend>
    <div class="layui-field-box">
      <table class="layui-table">
        <tbody>
        <tr>
          <th>版权所有</th>
          <td>福州大学至诚学院计算机工程系软件工程毕业设计</td>
        </tr>
        <tr>
          <th>开发者</th>
          <td>2017级软件工程一班张军</td>
        </tr>
        </tbody>
      </table>
    </div>
  </fieldset>
  <!--  <blockquote class="layui-elem-quote layui-quote-nm">感谢layui,ThinkPhp,向本系统的提供技术支持。</blockquote>-->
</div>
<script>
  layui.use(['table', 'layer', 'form', 'laydate'], function () {
    var table = layui.table;
    layer = layui.layer;
    form = layui.form;
    laydate = layui.laydate;

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
        table.reload('demo', {
          url: 'getBillList',
          method: 'get',
          page: {
            curr: 1
          },
          where: {
            key1: search
          }
        })
      },
    }

    form.on('submit(search)', function (data) {
      var last_time = $('#last_time').val();
      var time = $('#time').val();
      $.ajax({
        url: 'welcomeList',
        type: 'post',
        data: {
          'last_time': last_time,
          'time': time
        },
        success: function (data) {
          $('#lease').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).leaseTotal + "</cite>");
          $('#water').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).waterTotal + "</cite>");
          $('#power').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).powerTotal + "</cite>");
          $('#payPower').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).payPower + "</cite>");
          $('#payLease').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).payLease + "</cite>");
          $('#payWater').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).payWater + "</cite>");
        }
      })
      return false;
    });

    $.ajax({
      url: 'welcomeList',
      type: 'post',
      data: {'value': $('#type').val()},
      success: function (data) {
        $('#lease').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).leaseTotal + "</cite>");
        $('#water').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).waterTotal + "</cite>");
        $('#power').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).powerTotal + "</cite>");
        $('#payPower').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).payPower + "</cite>");
        $('#payLease').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).payLease + "</cite>");
        $('#payWater').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).payWater + "</cite>");
        // form.render();
      }
    })

    $('#type').ready(function () {
      form.on("select", function (data) {
        $.ajax({
          url: 'welcomeList',
          type: 'post',
          data: {'value': data.value},
          success: function (data) {
            $('#lease').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bold\">" + $.parseJSON(data).leaseTotal + "</cite>");
            $('#water').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bold\">" + $.parseJSON(data).waterTotal + "</cite>");
            $('#power').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bold\">" + $.parseJSON(data).powerTotal + "</cite>");
            $('#payPower').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bold\">" + $.parseJSON(data).payPower + "</cite>");
            $('#payLease').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bold\">" + $.parseJSON(data).payLease + "</cite>");
            $('#payWater').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bold\">" + $.parseJSON(data).payWater + "</cite>");
          }
        })
      });
    })


    //重置功能
    $('#reset').on('click', function () {
      $('#last_time').val("");
      $('#time').val("");
      form.render();
      $.ajax({
        url: 'welcomeList',
        type: 'post',
        data: {'value': $('#type').val()},
        success: function (data) {
          $('#lease').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).leaseTotal + "</cite>");
          $('#water').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).waterTotal + "</cite>");
          $('#power').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).powerTotal + "</cite>");
          $('#payPower').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).payPower + "</cite>");
          $('#payLease').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).payLease + "</cite>");
          $('#payWater').html("<cite style=\"font-size: 22px;color: limegreen;font-weight: bolder\">" + $.parseJSON(data).payWater + "</cite>");
          // form.render();
        }
      })
    });

    $('.demoTable .layui-btn').on('click', function () {
      var type = $(this).data('type');
      active[type] ? active[type].call(this) : '';
    });

  });
</script>

</body>
</html>