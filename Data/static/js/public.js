/**
 * @author   liangxiaoqiong
 * @version  1.0
 * @date 2018-03-27.
 */


var tTD;//用来存储当前更改宽度的Table Cell,避免快速移动鼠标的问题
var publicObj = new Object({
  /*点击复制文字*/
  copyContent: function (text, id, doMsg) {
    if (navigator.userAgent.match(/(iPhone|iPod|iPad);?/i)) {
      //ios
      var copyDOM = document.querySelector('#' + id);  //要复制文字的节点
      var range = document.createRange();
      // 选中需要复制的节点
      range.selectNode(copyDOM);
      // 执行选中元素
      window.getSelection().addRange(range);
      // 执行 copy 操作
      var successful = document.execCommand('copy');
      try {
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('copy is' + msg);
      } catch (err) {
        console.log('Oops, unable to copy');
      }
      // 移除选中的元素
      window.getSelection().removeAllRanges();
    } else {
      // 创建元素用于复制
      var aux = document.createElement("input");
      // 设置元素内容
      aux.setAttribute("value", text);
      // 将元素插入页面进行调用
      document.body.appendChild(aux);
      // 复制内容
      aux.select();
      // 将内容复制到剪贴板
      document.execCommand("copy");
      // 删除创建元素
      document.body.removeChild(aux);
    }
    doMsg = !(doMsg === 0)
    if (doMsg) {
      layer.msg('已复制内容到剪贴板');
    }
  },
  /**
   * 质朴长存法 =>不足位步0 by lifesinger
   * @param value
   */
  padNum: function (num, n) {
    var len = num.toString().length;
    while (len < n) {
      num = "0" + num;
      len++;
    }
    return num;
  },
  /**
   * 正则，只允许正整数
   * @param value
   * limitVal{
   *  "maxVal":"限制最大数"，"maxMsg":"超过最大数限制说明",
   *  "minVal":"限制最小数"，"minMsg":"超过最小数限制说明"}
   * @returns {number}
   */
  numInt: function (obj, limitVal) {
    if (obj.value.length == 1) {
      obj.value = obj.value.replace(/[^0-9]/g, '')
    } else {
      obj.value = obj.value.replace(/\D/g, '')
    }
    if (typeof (limitVal) !== 'undefined') {
      if (obj.value > +limitVal.maxVal) {
        layer.msg(limitVal.maxMsg);//'该商品最大售量9999件！'
        obj.value = +limitVal.maxVal;
      }
    }
    return obj.value;
  },
  /**
   * 浮点小数(最多精确到2位)
   * @param value
   * limitVal{
   *  "maxVal":"限制最大数"，"maxMsg":"超过最大数限制说明",
   *  "minVal":"限制最小数"，"minMsg":"超过最小数限制说明"}
   * @returns {number}
   */
  numPoint2: function (obj, limitVal) {
    obj.value = obj.value.match(/\d+(\.\d{0,2})?/) ? obj.value.match(/\d+(\.\d{0,2})?/)[0] : '';
    if (typeof (limitVal) !== 'undefined') {
      if (obj.value > +limitVal.maxVal) {
        layer.msg(limitVal.maxMsg);
        obj.value = +limitVal.maxVal;
      }
    }
    return obj.value;
  },
  customLayer: function (type, contentLayer) {
    if (type === 'show') {
      $('#layerModel,' + contentLayer + '').show();
    } else {
      $('#layerModel,' + contentLayer + '').hide();
    }
  },
  /**
   * 右侧滑出/关闭弹框
   * */
  slideRight: function (type, elName) {
    if (elName === undefined) {
      elName = '.slide-right';
    }
    if (type === 'show') {
      $(elName).show("drop", {direction: 'right'}, 400);
      $("#layerModel").parents('html,body').css({'overflow': 'hidden', 'width': 'calc(100% - 5px)'});
      $("#layerModel").show();
    } else {
      $(elName).hide("drop", {direction: 'right'}, 400);
      $("#layerModel").parents('html,body').css({'overflow': 'auto', 'width': '100%'});
      $("#layerModel").hide();
    }
  },
  /**
   * 显示layer 弹框
   参数解释：
   type==1,div层 ；==2：iframe
   title  标题
   url    请求的url,div el
   id    需要操作的数据id
   area{w:弹出层宽度（缺省调默认值760px）,h:弹出层高度（缺省调默认值80%）}
   cancelPoll 关闭轮序
   * */
  layerShow: function (type, title, content, area, cancelPoll) {
    var areaH, areaW;
    var cancelEvent;
    if (title == null || title == '') {
      title = false;
    }
    if (typeof (area) === 'undefined') {
      areaW = '700px';
      areaH = '90%';//($(window).height() - 50)+'px';
    } else {
      areaW = area.w_;
      areaH = area.h_;
    }
    if (typeof (cancelPoll) === 'undefined') {
      cancelEvent = 0;
    } else {
      cancelEvent = cancelPoll;
    }
    if (+type === 2) {
      console.log(content);
      if (content == null || content == '') {
        content = "404.html";
      }
    } else {
      content = $(content);
    }
    return layer.open({
      type: type,
      area: [areaW, areaH],
      fix: false, //不固定
      // maxmin: true,
      //shade:0.4,
      title: title,
      closeBtn: title == null || title == '' ? false : true,
      skin: 'layer-open',
      // shadeClose: true,
      content: content,
      cancel: function () {
        if (+cancelPoll === 1) {
          window.localStorage.setItem("cancel_poll", "1")
        }
      }
    });
  },

  /**
   * 关闭弹出框口 ifream
   * */
  layerFrameClose: function () {
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
  },
  /**
   * 重置layer.msg样式
   * content:msg内容
   * msgType:msg类型{0：失败，1：成功}
   * iconName：
   * */
  layerMsg: function (content, msgType, iconName) {
    if (+msgType === 1) {
      if (typeof (iconName) === 'undefined' || typeof (iconName) === '') {
        iconName = 'myicon-success-white';
      }
      var html = '<div class="layer-msg-success"><i class="' + iconName + '"></i><div class="display-align">' + content + '</div></div>';
    } else {
      if (typeof (iconName) === 'undefined' || typeof (iconName) === '') {
        iconName = 'myicon-fail-white';
      }
      var html = '<div class="layer-msg-fail"><i class="' + iconName + '"></i><div class="display-align">' + content + '</div></div>';
    }
    layer.msg(html);
    $('[class^="layer-msg-"]').parents('.layui-layer').css({'background': 'none'});
  },

  confirmDel: function (callback, config) {
    var content = config.content ? config.content : ''
    var skin2 = config.content ? '' : ' layer-confirm-del'
    layer.confirm(content, {
      title: config && config.title ? config.title : '确认要删除该项吗？',
      skin: 'layer-confirm' + skin2,
      btn: config && config.btn ? config.btn : ['确定', '取消'],
    }, function (index) {
      callback(index)
    })
  },
  /**
   * 点击图片查看大图
   * 需要指向图片的父容器
   * */
  imgPreview: function (parentEl) {
    /* '<div id="parentEl" class="layer-photos-demo">\n' +
     '  <img layer-pid="图片id，可以不写" layer-src="大图地址" src="缩略图" alt="图片名">\n' +
     '  <img layer-pid="图片id，可以不写" layer-src="大图地址" src="缩略图" alt="图片名">\n' +
     '</div>';*/
    layer.photos({
      photos: parentEl
      , shade: [0.23, '#000000']
      , area: ['500px', '']
      , anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
    });
    /*$('.layui-layer').css({'background-color':'transparent','box-shadow':'none'});*/
  },
  /**
   * 格式化时间
   * @param {} date
   * @param {} format
   */
  formatDate: function (date, format) {
    var paddNum = function (num) {
      num += "";
      return num.replace(/^(\d)$/, "0$1");
    }
    //指定格式字符
    var cfg = {
      yyyy: date.getFullYear() //年 : 4位
      , yy: date.getFullYear().toString().substring(2)//年 : 2位
      , M: date.getMonth() + 1  //月 : 如果1位的时候不补0
      , MM: paddNum(date.getMonth() + 1) //月 : 如果1位的时候补0
      , d: date.getDate()   //日 : 如果1位的时候不补0
      , dd: paddNum(date.getDate())//日 : 如果1位的时候补0
      , hh: paddNum(date.getHours())  //时
      , mm: paddNum(date.getMinutes()) //分
      , ss: paddNum(date.getSeconds()) //秒
    }
    format || (format = "yyyy-MM-dd hh:mm:ss");
    return format.replace(/([a-z])(\1)*/ig, function (m) {
      return cfg[m];
    });
  },
  formatDate2: function (date, format) {
    var paddNum = function (num) {
      num += "";
      return num.replace(/^(\d)$/, "0$1");
    }
    //指定格式字符
    var cfg = {
      yyyy: date.getFullYear() //年 : 4位
      , yy: date.getFullYear().toString().substring(2)//年 : 2位
      , M: date.getMonth() + 1  //月 : 如果1位的时候不补0
      , MM: paddNum(date.getMonth() + 1) //月 : 如果1位的时候补0
      , d: date.getDate()   //日 : 如果1位的时候不补0
      , dd: paddNum(date.getDate())//日 : 如果1位的时候补0
      , hh: paddNum(date.getHours())  //时
      , mm: paddNum(date.getMinutes()) //分
      , ss: paddNum(date.getSeconds()) //秒
    }
    format || (format = "yyyy.MM.dd");
    return format.replace(/([a-z])(\1)*/ig, function (m) {
      return cfg[m];
    });
  },
  /**
   * 判断是否是手机
   * @param value
   * @returns {boolean}
   */
  isPhone: function (value) {
    var reg = /^1[2|3|4|5|6|7|8|9][0-9]\d{4,8}$/;
    return reg.test(value);
  },
  /**
   * //毫秒转时间戳2017-08-20 12:12:12*/
  dateTime_Str: function (time_, timeType) {
    var Y = time_.getFullYear();    //获取完整的年份(4位,1970-????)
    var M = publicObj.padNum(time_.getMonth() + 1, 2);       //获取当前月份(0-11,0代表1月)
    var D = publicObj.padNum(time_.getDate(), 2);        //获取当前日(1-31)
    var H = publicObj.padNum(time_.getHours(), 2);       //获取当前小时数(0-23)
    var Min = publicObj.padNum(time_.getMinutes(), 2);     //获取当前分钟数(0-59)
    var S = publicObj.padNum(time_.getSeconds(), 2);     //获取当前秒数(0-59)
    if (timeType === 'date') {
      var dataTime = Y + '-' + M + '-' + D;
    } else {
      var dataTime = Y + '-' + M + '-' + D + ' ' + H + ':' + Min + ':' + S;
    }
    return dataTime;
  },
  // 验证
  /*
    var verifyRule = [
      { key: 'name', verify_type: 'required', error_text: '请输入**'},
      { key: 'name', verify_type: 'required_length', error_text: '请输入**'},
    ]
    if (!publicObj.verifyForm(verifyRule, verifyArr)) return false
    verifyRule:验证规则
    verifyArr:验证的数据
  */
  verifyForm: function (verifyRule, verifyArr) {
    // 传入表单数据，调用验证方法a
    let result = true
    try {
      verifyRule.forEach(function (value) {
        switch (value.verify_type) {
          case 'required':
            if (typeof verifyArr[value.key] === 'undefined' || verifyArr[value.key] === '') {
              publicObj.layerMsg(value.error_text)
              result = false
              throw Error()
            }
            break
          case 'required_length':
            if (typeof verifyArr[value.key] === 'undefined' || verifyArr[value.key].length <= 0) {
              publicObj.layerMsg(value.error_text)
              result = false
              throw Error()
            }
            break
          default:
            break
        }
      })
    } catch (e) {
    }
    return result
  },
  /**自定义可滑动table*/
  diyTableScroll: function () {
    $(".diy-table-box>.diy-table-body").scroll(function () {
      $(".diy-table-header").scrollLeft($(".diy-table-box>.diy-table-body").scrollLeft());
      $(".diy-table-fixed .diy-table-body").scrollTop($(".diy-table-box>.diy-table-body").scrollTop());
    });
  },
  /**表格table 可改变列宽*/
  diyTableTh: function (el, tableFiled) {
    var table = document.getElementById(el);
    for (j = 0; j < table.rows[0].cells.length; j++) {
      table.rows[0].cells[j].onmousedown = function () {
//记录单元格
        tTD = this;
        if (event.offsetX > tTD.offsetWidth - 10) {
          tTD.mouseDown = true;
          tTD.oldX = event.x;
          tTD.oldWidth = tTD.offsetWidth;
        }
        $('.diy-table .diy-table-cell').addClass('unselect');
      };
      table.rows[0].cells[j].onmouseup = function () {
//结束宽度调整
        if (tTD == undefined) tTD = this;
        tTD.mouseDown = false;
        tTD.style.cursor = 'default';
        $('.diy-table .diy-table-cell').removeClass('unselect');
      };
      table.rows[0].cells[j].onmousemove = function () {
//更改鼠标样式
        if (event.offsetX > this.offsetWidth - 10)
          this.style.cursor = 'col-resize';
        else
          this.style.cursor = 'default';
//取出暂存的Table Cell
        if (tTD == undefined) tTD = this;
//调整宽度
        if (tTD.mouseDown != null && tTD.mouseDown == true) {
          tTD.style.cursor = 'default';
          if (tTD.oldWidth + (event.x - tTD.oldX) > 0) {
            var index = $(tTD).data('index')
            if (typeof tableFiled !== 'undefined') {
              if (tableFiled[index].is_fixed_left === 'undefined'
                || +tableFiled[index].is_fixed_left === 1
                || tableFiled[index].is_fixed_right === 'undefined'
                || +tableFiled[index].is_fixed_right === 1)
                return false
              tableFiled[index].t_width = tTD.oldWidth + (event.x - tTD.oldX)
            } else {
              $('.diy-table-cell-' + index).css('width', tTD.oldWidth + (event.x - tTD.oldX))
            }
          }
          tTD.style.cursor = 'col-resize';
        }
      };
    }
    document.onmouseup = function () {
//结束宽度调整
      if (tTD == undefined) tTD = this;
      tTD.mouseDown = false;
      // tTD.style.userSelect = '';
      $('.diy-table .diy-table-cell').removeClass('unselect');
    }
  }
})
