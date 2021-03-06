<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv='X-UA-Compatible' content='IE=edge'/>
  <meta name='viewport'
        content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'/>
  <meta charset='UTF-8'>
  <title>首页</title>
  <link rel='stylesheet' href='/Data/lessee/css/index.css'>
  <!--  <link rel="stylesheet" href="/Data/admin/css/font.css">-->
  <!--  <link rel="stylesheet" href="/Data/admin/css/xadmin.css">-->
  <script src="/Data/admin/js/jquery.min.js"></script>
  <script type="text/javascript" src="/Data/admin/lib/layui/layui.js" charset="utf-8"></script>
  <script type="text/javascript" src="/Data/admin/js/xadmin.js"></script>
</head>
<body>
<div class="index-content">
  <header class="index-header white">
    <div class="f-lex al-center">
      <h5 class="f-40"><?php echo ($customer_name); ?></h5>
      <img class="down-icon ml-12" src="/Data/lessee/images/icon/down_2_icon.png" alt="">
    </div>
    <p class="f-26 show-btn mt-12" style="width: 35vw;color: deeppink"><?php echo ($roomInfo); ?></p>
    <!--    <button class="add-btn">-->
    <!--      <img src="/Data/lessee/images/icon/add_icon.png" alt="">-->
    <!--    </button>-->
  </header>
  <div class="f-lex fl-wrap block-list" id="contents">
    <form class="layui-form">
<!--      <div class="block-icon">-->
        <!--        <div class="f-lex f-weight j-s-b">-->
        <!--          <p class="f-28 black-1">环境检测</p>-->
        <!--          <p class="f-24 gray-90">客厅</p>-->
        <!--        </div>-->
      <input type="hidden" value="" id="bill_id">
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
<!--                <div class="close-btn" data-type="reload" lay-submit lay-filter="search">支付</div>-->
<!--      <button class="layui-btn" data-type="reload" lay-submit lay-filter="search">搜索</button>-->

<!--              </div>-->
      <!--      </div>-->
<!--    </form>-->
  </div>
</div>
<div class="footer fl-ar bg-black">
  <a>
    <img src="/Data/lessee/images/icon/home_a_icon.png" alt="">
    <p class="blue-1">首页</p>
  </a>
  <a>
    <img src="/Data/lessee/images/icon/equr_n_icon.png" alt="">
    <p>设备</p>
  </a>
  <a>
    <img src="/Data/lessee/images/icon/mine_n_icon.png" alt="">
    <p>我的</p>
  </a>
</div>
</body>
<script>
  layui.use(['table', 'layer', 'form', 'jquery'], function () {
    var table = layui.table,
      layer = layui.layer,
      form = layui.form,
      $ = layui.$;


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
          str += "<p class=\"f-28 black-1\">" + item.bill_remark + "</p>";
          str += " <p class=\"f-24 gray-90\">" + item.type + "</p>";
          str += "</div>";
          str += "<div class=\"f-lex j-s-b al-center mt-40\">";
          str += "<div class=\"f-weight\">";
          str += "<p class=\"f-50\">账单周期: <span class=\"blue-1 f-26\">" + item.cycle + "</span></p>";
          str += "<p class=\"f-24\">总计：<span class=\"red-90 f-26\">" + item.total + "</span></p>";
          str += "</div>";
          if (item.pay_status == 0){
            str += "<input type=\"hidden\" class=\"hidden\" value=\"" + item.bill_id + "\" id=\"bill_id\">";
            str += "<div class=\"close-btn\" data-type=\"reload\" lay-submit lay-filter=\"search\">支付</div>";
          }else{
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


    form.on('submit(search)', function (data) {
      var type = $(this).data('type');
      // if($('#customer_name').val()==""){
      //   layer.msg('查询项目不能为空');
      //   return false;
      // }
      active[type] ? active[type].call(this) : '';
      return false;
    });

    var $ = layui.$, active = {
      reload: function () {
        var bill_id = $('.f-lex .hidden').val();
        console.log(bill_id);
      }
    }
  });
</script>
</html>