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
        $where['is_delete'] = NOT_DELETED;
        $user = M('user')->where($where)->find();
        if (empty($user)){
            $this->error('账号或密码错误，请重试！！！');
        }
//        查询园区是否为开启状态
        $where1 = array();
        $where1['garden_id'] = $user['garden_id'];
        $status = M('garden')->where($where1)->find()['garden_status'];
        if ($status == 0){
            $this->error('园区暂未开启，请联系主管理员开启园区！！！');
        }
        session('USER', $user);
        $url = U('Index/index');
        $this->success('登录成功!', $url);
    }


    public function logout(){
        session('USER', null);
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
