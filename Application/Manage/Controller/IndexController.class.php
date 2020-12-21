<?php
namespace Manage\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function _initialize(){
        if (session('USER')){
            $user = session('USER');
            $this->assign('USER', $user);
        }else{
            $this->assign('USER', '请先登录！！！');
        }
    }

    public function index(){
        if (session('USER')){
            $this->display();
        }else{
            $this->success('请先登录！！', U('Login/login'),1);
        }
    }

    public function welcome(){
        $this->assign('now', date('Y-m-d H:i:s'));
        $this->display();
    }
}