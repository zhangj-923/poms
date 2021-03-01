<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  
  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-L-admin1.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/Data/admin/favicon.ico" type="image/x-icon" />
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
  
  <body>
    <div class="x-body">
        <form class="layui-form">
          <input type="hidden" id="room_id" name="room_id" />
          <div class="layui-form-item">
            <label for="room_sn" class="layui-form-label">
              <span class="x-red">*</span>房屋编号
            </label>
            <div class="layui-input-inline">
              <input type="text" id="room_sn" name="room_sn" required
                     autocomplete="off" class="layui-input" lay-verify="required">
            </div>
          </div>
<!--          <div class="layui-form-item">-->
<!--            <label for="garden_name" class="layui-form-label">-->
<!--              <span class="x-red">*</span>园区-->
<!--            </label>-->
<!--            <div class="layui-input-inline">-->
<!--              <input type="text" id="garden_name" name="garden_name" required-->
<!--                     autocomplete="off" class="layui-input" disabled>-->
<!--            </div>-->
<!--          </div>-->
<!--          <div class="layui-form-item">-->
<!--              <label for="customer_mobile" class="layui-form-label">-->
<!--                  <span class="x-red">*</span>联系方式-->
<!--              </label>-->
<!--              <div class="layui-input-inline">-->
<!--                  <input type="text" id="customer_mobile" name="customer_mobile" required lay-verify="phone"-->
<!--                  autocomplete="off" class="layui-input">-->
<!--              </div>-->
<!--              <div class="layui-form-mid layui-word-aux">-->
<!--                  <span class="x-red">*</span>将会成为您唯一的登入名-->
<!--              </div>-->
<!--          </div>-->
<!--          <div class="layui-form-item">-->
<!--              <label for="room_name" class="layui-form-label">-->
<!--                  <span class="x-red">*</span>房间号-->
<!--              </label>-->
<!--              <div class="layui-input-inline">-->
<!--                  <input type="text" id="room_name" name="room_name" required-->
<!--                  autocomplete="off" class="layui-input">-->
<!--              </div>-->
<!--          </div>-->
          <div class="layui-form-item">
            <label for="remark" class="layui-form-label">
              <span class="x-red">*</span>备注
            </label>
            <div class="layui-input-inline">
              <input type="text" id="remark" name="remark" required
                     autocomplete="off" class="layui-input" lay-verify="required">
            </div>
          </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="edit" lay-submit="">
                  确定
              </button>
          </div>
      </form>
    </div>
    <script>
      layui.use(['form','layer'], function(){
          $ = layui.jquery;
        var form = layui.form
        ,layer = layui.layer;
      
        //自定义验证规则
        form.verify({
          nikename: function(value){
            if(value.length < 5){
              return '昵称至少得5个字符啊';
            }
          }
          ,pass: [/(.+){6,12}$/, '密码必须6到12位']
          ,repass: function(value){
              if($('#L_pass').val()!=$('#L_repass').val()){
                  return '两次密码不一致';
              }
          }
        });

        //监听提交
        form.on('submit(edit)', function(data){
          console.log(data);
          //发异步，把数据提交给php
          $.ajax({
            url: 'editRoom',
            type: 'post',
            data: data.field,
            dataType: 'json',
            success:function (data) {
              if (data.status == "1"){
                layer.msg(data.info, function () {
                  // 获得frame索引
                  var index = parent.layer.getFrameIndex(window.name);
                  //关闭当前frame
                  parent.layer.close(index);
                  //关闭层
                  //x_admin_close();
                  //对父窗体进行刷新
                  parent.location.reload();

                })
              }else{
                layer.alert(data.info);
              }
            }
          })
          return false;
        });
        
        
      });
  </script>
  <script>
    getCustomerAjax();
    function getCustomerAjax () {
      var room_id = window.parent.document.getElementById('update_room_id').value;
      $.ajax({
        url: 'getRoom?roomId='+room_id,
        type: 'get',
        dataType: 'json',
        success:function (data) {
          $("#room_id").val(data[0].room_id);
          $("#room_sn").val(data[0].room_sn);
          $("#remark").val(data[0].remark);
        }
      });
    }
  </script>
  </body>

</html>