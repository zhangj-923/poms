<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
  <meta name='viewport'
        content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'/>
  <meta charset='UTF-8'>
  <title>首页</title>
  <link rel="stylesheet" href="/Data/admin/css/font.css">
  <link rel="stylesheet" href="/Data/admin/css/xadmin.css">
  <link rel='stylesheet' href='/Data/lessee/css/index.css'>
  <script src="/Data/admin/js/jquery.min.js"></script>
  <script type="text/javascript" src="/Data/admin/lib/layui/layui.js" charset="utf-8"></script>
  <script type="text/javascript" src="/Data/admin/js/xadmin.js"></script>
</head>
<body>
<div class="index-content">
  <header class="index-header white">
    <div class="f-lex al-center" style="margin-top: -20px">
      <h5 class="f-40"><?php echo ($customer_name); ?></h5>
      <img class="down-icon ml-12" id="close" src="/Data/lessee/images/icon/close_1_icon.png" alt=""
           style="background: yellow;margin-left: 20px;width: 15px;height: 15px">
    </div>
    <div>
      <!--      <div class="f-lex">-->
      <p class="f-lex f-28 black-1" style="margin-top: 16px; color: white">所租房屋</p>
      <!--      </div>-->
      <div class="f-weight" id="header" style="margin-left: 70px; margin-top: -30px">
      </div>


    </div>
    <!--    <p class="f-26 show-btn mt-12" style="width: 35vw;color: deeppink"><?php echo ($roomInfo); ?></p>-->
    <!--    <button class="add-btn">-->
    <!--      <img src="/Data/lessee/images/icon/add_icon.png" alt="">-->
    <!--    </button>-->
  </header>
  <header class="index-header white" style="background: deepskyblue;margin-top: 10px;height: 100px">
    <form class="layui-form">
      <div class="demoTable layui-form-item">
        <div class="layui-inline">
          <div class="layui-input-inline" style="height: 20px;margin-top: -10px;margin-left: -10px">
            <input type="text" name="last_time" id="last_time" placeholder="开始日期" autocomplete="off"
                   class="layui-input" style="width: 100px;float: left;height: 20px">
            <input type="text" name="time" id="time" placeholder="截止日期" autocomplete="off"
                   class="layui-input" style="width: 100px;height: 20px;margin-left: 150px">
          </div>
        </div>
        <button class="layui-btn" data-type="reload" lay-submit lay-filter="query"
                style="float: right;margin-right: 20px;margin-top: -15px">
          搜索
        </button>
        <div class="layui-btn layui-btn-warm" id="reset" name="reset"
             style="background: gray;float: right;width: 20px;height: 20px;margin-right: 10px;border-radius: 4em"></div>
        <!--        <div class="close-btn" id="query" lay-submit lay-filter="query"-->
        <!--             style="width: 20px;height: 20px;float:right;margin-right: 60px;margin-top: -50px;border-radius: 50%;background: yellow">-->
        <!--        </div>-->
      </div>
    </form>
    <div>
      <p class="f-lex f-28 black-1" style="color: white; margin-top: -55px">平均水费</p>
      <div class="f-weight" id="water" style="margin-left: 70px; margin-top: -30px">
        <!--        <p class="f-26 mt-12" style="width: 20vw;height: 10px;color: deeppink">200</p>-->
      </div>
    </div>
    <div>
      <p class="f-lex f-28 black-1" style="color: white;margin-top: 15px">平均电费</p>
      <div class="f-weight" id="power" style="margin-left: 70px; margin-top: -30px">
        <!--        <p class="f-26 mt-12" style="width: 20vw;height: 10px;color: deeppink">40</p>-->
      </div>
    </div>

  </header>
  <form class="layui-form" style="padding-top: 10px">
    <!--    <nav class="index-nav f-28 c-gray f-weight">-->
    <!--      <p class="nav-active">账单</p>-->
    <!--    </nav>-->
    <label class="layui-form-label">账单类型:</label>
    <div class="layui-input-inline">
      <select class="layui-select" id="leaseTeam" name="leaseTeam" lay-filter="Team">
        <option value="0">所有</option>
        <option value="1">房租</option>
        <option value="2">水费</option>
        <option value="3">电费</option>
      </select>
    </div>
  </form>
  <div class="f-lex fl-wrap block-list" id="contents">
    <!--    <form class="layui-form">-->
    <!--      <div class="block-icon">-->
    <!--        <div class="f-lex f-weight j-s-b">-->
    <!--          <p class="f-28 black-1">环境检测</p>-->
    <!--          <p class="f-24 gray-90">客厅</p>-->
    <!--        </div>-->
    <!--      <input type="hidden" value="" id="bill_id">-->
    <!--        <div class="f-lex j-s-b al-center mt-40">-->
    <!--          <img class="source-1" src="/Data/lessee/images/source/furnishing_1.png" alt="">-->
    <!--                  <div class="f-weight">-->
    <!--                    <p class="f-50">52 <span class="blue-1 f-26">良</span></p>-->
    <!--                    <p class="f-24">总计：<span class="red-90 f-26">良</span></p>-->
    <!--                    <p class="f-50 red-90">已支付</p>-->
    <!--                    <p class="f-24"></p>-->
    <!--                  </div>-->
    <!--        </div>-->
    <!--      </div>-->
    <!--      <div class="block-icon">-->
    <!--        <div class="f-lex f-weight j-s-b">-->
    <!--          <p class="f-28 black-1">智能插座</p>-->
    <!--          <p class="f-24 gray-90">厨房</p>-->
    <!--        </div>-->
    <!--              <div class="f-lex j-s-b al-center mt-40">-->
    <!--                <img class="source-2" src="/Data/lessee/images/source/furnishing_2.png" alt="">-->
    <!--      <div class="close-btn" data-type="reload" lay-submit lay-filter="search"><span onclick="payBill(this)"></span>支付-->
    <!--    <input type="button" name="payBill" class="close-btn" id="" value="">-->
    <!--      </div>-->
    <!--      <button class="layui-btn" data-type="reload" lay-submit lay-filter="search">搜索</button>-->

    <!--              </div>-->
    <!--      </div>-->
    <!--    </form>-->
  </div>
</div>
<div class="footer fl-ar bg-black">
  <a href="index">
    <img src="/Data/lessee/images/icon/home_a_icon.png" alt="">
    <p class="blue-1">首页</p>
  </a>
  <a href="device">
    <img src="/Data/lessee/images/icon/equr_n_icon.png" alt="">
    <p>设备报修</p>
  </a>
  <a href="per_center">
    <img src="/Data/lessee/images/icon/mine_n_icon.png" alt="">
    <p>我的</p>
  </a>
</div>
</body>
<script>
  layui.use(['table', 'layer', 'form', 'jquery', 'laydate'], function () {
    var table = layui.table;
    layer = layui.layer;
    form = layui.form;
    $ = layui.$;
    laydate = layui.laydate;

    //日期
    laydate.render({
      elem: '#time'
    });

    //日期
    laydate.render({
      elem: '#last_time'
    });


    $.ajax({
      url: 'getBillList',
      type: 'post',
      // dataType: "JSON",
      success: function (data) {
        // console.log();
        var str = '';
        $.each($.parseJSON(data), function (index, item) {
          str += "<form class=\"layui-form\">";
          str += "<div class=\"block-icon\">";
          str += "<div class=\"f-lex f-weight j-s-b\">";
          str += "<p class=\"f-28 black-1\">" + item.bill_remark + '  (' + item.room_sn + '室)' + "</p>";
          str += " <p class=\"f-24 gray-90\">" + item.type + "</p>";
          str += "</div>";
          str += "<div class=\"f-lex j-s-b al-center mt-40\">";
          str += "<div class=\"f-weight\">";
          str += "<p class=\"f-50\">账单周期: <span class=\"blue-1 f-26\">" + item.cycle + "</span></p>";
          str += "<p class=\"f-24\">总计：<span class=\"red-90 f-26\">" + item.total + "</span></p>";
          str += "</div>";
          if (item.pay_status == 0) {
            // str += "<input type=\"hidden\" class=\"hidden\" value=\"" + item.bill_id + "\" id=\"" + index + "\">";
            str += "<div class=\"close-btn\" data-type=\"" + item.type + "\" data-value=\"" + item.bill_id + "\" lay-submit lay-filter=\"search\">支付</div>";

          } else {
            str += "<div class=\"f-weight\">";
            str += "<p class=\"f-50 red-90\">已支付</p>";
            str += "<p class=\"f-24\">" + item.pay_time + "</p>";
            str += "</div>";
          }
          str += "</div>";
          str += "</div>";
          str += "</form>";
        });
        $('#contents').html(str);
      }
    })

    $('#leaseTeam').ready(function () {
      form.on("select", function (data) {
        $.ajax({
          url: 'getBillList',
          type: 'post',
          data: {'value': data.value},
          success: function (data) {
            var str = '';
            $.each($.parseJSON(data), function (index, item) {
              str += "<form class=\"layui-form\">";
              str += "<div class=\"block-icon\">";
              str += "<div class=\"f-lex f-weight j-s-b\">";
              str += "<p class=\"f-28 black-1\">" + item.bill_remark + '  (' + item.room_sn + '室)' + "</p>";
              str += " <p class=\"f-24 gray-90\">" + item.type + "</p>";
              str += "</div>";
              str += "<div class=\"f-lex j-s-b al-center mt-40\">";
              str += "<div class=\"f-weight\">";
              str += "<p class=\"f-50\">账单周期: <span class=\"blue-1 f-26\">" + item.cycle + "</span></p>";
              str += "<p class=\"f-24\">总计：<span class=\"red-90 f-26\">" + item.total + "</span></p>";
              str += "</div>";
              if (item.pay_status == 0) {
                // str += "<input type=\"hidden\" class=\"hidden\" value=\"" + item.bill_id + "\" id=\"" + index + "\">";
                str += "<div class=\"close-btn\" data-type=\"" + item.type + "\" data-value=\"" + item.bill_id + "\" lay-submit lay-filter=\"search\">支付</div>";

              } else {
                str += "<div class=\"f-weight\">";
                str += "<p class=\"f-50 red-90\">已支付</p>";
                str += "<p class=\"f-24\">" + item.pay_time + "</p>";
                str += "</div>";
              }
              str += "</div>";
              str += "</div>";
              str += "</form>";
            });
            $('#contents').html(str);
          }
        })
      });
    })

    $.ajax({
      url: 'getRoomInfo',
      type: 'post',
      success: function (data) {
        var str = '';
        $.each($.parseJSON(data), function (index, item) {
          str += "<p class=\"f-26 show-btn mt-12\" style=\"width: 35vw;color: deeppink\">" + item.garden_name + item.building_name + item.room_sn + "</p>";
        })
        $('#header').html(str);
      }
    })

    $.ajax({
      url: 'getAverageCost',
      type: 'post',
      success: function (data) {
        $('#water').html("<p class=\"f-26 mt-12\" style=\"width: 20vw;height: 10px;color: deeppink\">" + $.parseJSON(data).avgWater + "</p>");
        $('#power').html("<p class=\"f-26 mt-12\" style=\"width: 20vw;height: 10px;color: deeppink\">" + $.parseJSON(data).avgPower + "</p>");
      }
    })


    form.on('submit(query)', function (data) {
      var last_time = $('#last_time').val();
      var time = $('#time').val();
      $.ajax({
        url: 'getAverageCost',
        type: 'post',
        data: {
          'last_time': last_time,
          'time': time
        },
        success: function (data) {
          $('#water').html("<p class=\"f-26 mt-12\" style=\"width: 20vw;height: 10px;color: deeppink\">" + $.parseJSON(data).avgWater + "</p>");
          $('#power').html("<p class=\"f-26 mt-12\" style=\"width: 20vw;height: 10px;color: deeppink\">" + $.parseJSON(data).avgPower + "</p>");
        }
      })
      return false;
    });

    //重置功能
    $('#reset').on('click', function () {
      $('#last_time').val("");
      $('#time').val("");
      form.render();
      $.ajax({
        url: 'getAverageCost',
        type: 'post',
        success: function (data) {
          $('#water').html("<p class=\"f-26 mt-12\" style=\"width: 20vw;height: 10px;color: deeppink\">" + $.parseJSON(data).avgWater + "</p>");
          $('#power').html("<p class=\"f-26 mt-12\" style=\"width: 20vw;height: 10px;color: deeppink\">" + $.parseJSON(data).avgPower + "</p>");
        }
      })
    });


    form.on('submit(search)', function (data) {
      var type = $(this).data('type');
      var value = $(this).data('value');
      // console.log();
      // active[type] ? active[type].call(this) : '';
      layer.confirm('完成该账单支付！！', {
        title: type
      }, function () {
        $.ajax({
          url: 'payBill',
          type: 'post',
          dataType: "JSON",
          data: {'bill_id': value},
          success: function (data) {
            if (data.code == 200) {
              layer.msg(data.msg);
            } else {
              layer.alert(data.msg);
            }
            setTimeout(function () {
              window.location.reload();
            }, 2500);
          }
        })
      })
      return false;
    });

    $('#close').on('click', function () {
      layer.confirm('确认退出？', {
        title: '退出'
      }, function () {
        $.ajax({
          url: "<?php echo U('Login/logout');?>",
          success: function () {
            window.location.reload();
          }
        })
      })
    });


    // form.on('submit(search)', function (data) {
    //   var type = $(this).data('type');
    //   // if($('#customer_name').val()==""){
    //   //   layer.msg('查询项目不能为空');
    //   //   return false;
    //   // }
    //   active[type] ? active[type].call(this) : '';
    //   return false;
    // });

    // var $ = layui.$, active = {
    //   reload: function (data) {
    //     console.log(data);
    //   }
    // }
  });
</script>
</html>