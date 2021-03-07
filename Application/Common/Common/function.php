<?php


//定义删除状态
define('NOT_DELETED', 0);
define('DELETED', 1);

//定义账单类型
define('BILL_LEASE', 1);
define('BILL_WATER', 2);
define('BILL_POWER', 3);

//定义账单支付状态
define('NOT_PAY', 0);
define('IS_PAY', 1);

//定义处理状态
define('IS_DEAL', 1);
define('NOT_DEAL', 0);

//定义租赁退租与否
define('NOT_EXIT', 0);
define('IS_EXIT', 1);

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
 * @param null $msg 信息
 * @param array $data 数据
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

//创建TOKEN
function createToken($tokenName)
{
    $code = chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE)) . chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE)) . chr(mt_rand(0xB0, 0xF7)) . chr(mt_rand(0xA1, 0xFE));
    session($tokenName, authcode($code));
}

//判断TOKEN
function checkToken($tokenName)
{
    if ($tokenName == session('TOKEN')) {
        session('TOKEN', NULL);
        return TRUE;
    } else {
        return FALSE;
    }
}

//加密TOKEN
function authcode($str)
{
    $key = "YOURKEY";
    $str = substr(md5($str), 8, 10);
    return md5($key . $str);
}