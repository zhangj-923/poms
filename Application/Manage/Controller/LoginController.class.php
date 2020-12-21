<?php
namespace Manage\Controller;
use \Think\Controller;

class LoginController extends Controller{
    public function login(){
        $this->display();
    }


    public function toLogin(){
        $name = I('name');
        $password = md5(I('password'));
        $verify = I('code', '', 'htmlspecialchars,trim');
        if (!check_verify($verify, 'a_login_1')) {
            $this->error('验证码不正确');
        }
        $where = array();
        $where['name'] = $name;
        $where['password'] = $password;
        $user = M('user')->field(true)->where($where)->find();
        if (empty($user)){
            $this->error('账号或密码错误，请重试！！！');
        }

        session('USER', $user);
        $url = U('Index/index');
        $this->success('登录成功!', $url);
    }


    public function logout(){
        session(null);
        $this->redirect('Login/login');
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
