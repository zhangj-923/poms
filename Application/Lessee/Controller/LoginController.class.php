<?php

namespace Lessee\Controller;

use Think\Controller;

class LoginController extends Controller
{

    public function login()
    {
        $this->display();
    }


    public function toLogin()
    {
        $name = I('name');
        $password = md5(I('password'));
        $verify = I('code', '', 'htmlspecialchars,trim');
        if (!check_verify($verify, 'a_login_1')) {
            $this->error('验证码不正确');
        }
        $where = array();
        $where['customer_mobile'] = $name;
        $where['password'] = $password;
        $where['is_delete'] = NOT_DELETED;
        $customer = M('customer')->where($where)->find();
        if (empty($customer)) {
            $this->error('账号或密码错误，请重试！！！');
        }
//        查询该租户是否有租赁信息 有则开启登录，无则拒绝
        $where1 = array();
        $where1['a.customer_id'] = $customer['customer_id'];
        $where1['b.is_delete'] = NOT_DELETED;
        $where1['b.is_exit'] = NOT_EXIT;
        $join = '__LEASE__ b on a.customer_id = b.customer_id';
        $list = M('customer')->alias('a')->where($where1)->join($join)->find();
        if (empty($list)) {
            $this->error('暂无该租户的租赁信息，请联系管理员进行查询！！！');
        }
        session('CUSTOMER', $customer);
        $url = U('Index/index');
        $this->success('登录成功!', $url);
    }


    public function logout()
    {
        session('CUSTOMER', null);
        $this->redirect('Login/login');
    }


    /* 登录验证码*/
    public function verify($id = '1')
    {
        $config = array(
            'fontSize' => 18,
            'length' => 4,
//            'imageW' => 230,
//            'imageH' => 40,
            'bg' => array(206, 233, 246),
            'useCurve' => false,
            'useNoise' => false,
            'codeSet' => '234569',
        );
        $verify = new \Think\Verify($config);
        $verify->entry($id);
    }
}
