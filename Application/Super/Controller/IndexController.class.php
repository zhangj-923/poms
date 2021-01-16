<?php
namespace Super\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function _initialize(){
        if (session('ADMIN')){
            $admin = session('ADMIN');
            $this->assign('ADMIN', $admin);
        }else{
            $this->assign('ADMIN', '请先登录！！！');
        }
    }

    public function index(){
        if (session('ADMIN')){
            $this->display();
        }else{
            $this->success('请先登录！！', U('Login/login'),1);
        }
    }

    public function main(){
        /* phpversion */
        $this->assign('phpversion', phpversion());
        $this->assign('software', $_SERVER["SERVER_SOFTWARE"]);
        $this->assign('os', PHP_OS);

        $_mysql_ver = M()->query('SELECT VERSION() as ver;');

        if (is_array($_mysql_ver)) {
            $mysql_ver = $_mysql_ver[0]['ver'];
        } else {
            $mysql_ver = '';
        }
        $this->assign('mysql_ver', $mysql_ver);
        $this->assign('ADMIN', session('ADMIN'));
        $this->display();
    }

    public function super_edit(){
        $this->display();
    }
}