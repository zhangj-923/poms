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

    /**
     * 获取超级管理员信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 13:43:13
     * Update: 2021-01-17 13:43:13
     * Version: 1.00
     */
    public function getAdmin(){
        $id = session('ADMIN.id');
        $data = D('Admin')->getSuperInfo($id);
        echo json_encode($data);
    }

    /**
     * 修改超级管理员信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 14:15:36
     * Update: 2021-01-17 14:15:36
     * Version: 1.00
     */
    public function editAdmin(){
        if (IS_AJAX){
            $result = D('Admin')->editSuperInfo($_POST);
            echo json_encode($result);
        }
    }
}