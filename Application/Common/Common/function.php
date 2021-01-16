<?php

//定义状态码
define('CODE_SUCCESS', 200); // 请求成功
define('CODE_ERROR', 406); // 请求失败


/**
 * 检测登录验证码
 * @param $code
 * @param int $id
 * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
 * Date: 2021-01-16 13:24:02
 * Update: 2021-01-16 13:24:02
 * Version: 1.00
 */
function check_verify($code, $id = 1)
{
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}


/**
 * 返回规范结构
 * @param $code 状态码
 * @param null $msg  信息
 * @param array $data  数据
 * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
 * Date: 2021-01-16 13:23:29
 * Update: 2021-01-16 13:23:29
 * Version: 1.00
 */
function getReturn($code = CODE_ERROR, $msg = null, $data = [])
{
    $msg = !isset($msg) ? '系统繁忙,请稍候重试...' : $msg;
    return array('time' => '', 'code' => $code, 'msg' => $msg, 'data' => $data);
}