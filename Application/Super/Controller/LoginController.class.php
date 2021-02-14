<?php
namespace Super\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
        $this->display();
    }

    public function toLogin(){
        $username = I('username');
        $password = I('password');
        $verify = I('code', '', 'htmlspecialchars,trim');
        if (!check_verify($verify, 'a_login_1')) {
            $this->error('验证码不正确');
        }
        $where = array();
        $where['username'] = $username;
        $where['password'] = $password;
        $admin = M('admin')->field(true)->where($where)->find();
        if (empty($admin)){
            $this->error('账号或密码错误，请重试！！！');
        }

        session('ADMIN', $admin);
        $url = U('Index/index');
        $this->success('登录成功!', $url);
    }

    /**
     * 退出登录
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-16 13:43:21
     * Update: 2021-01-16 13:43:21
     * Version: 1.00
     */
    public function logout(){
        session('ADMIN', null);
        $this->success('退出系统！！', U('Login/login'),1);
    }

    /* 登录验证码*/
    public function verify($id = '1'){
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