<?php

namespace Manage\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function _initialize()
    {
        if (session('USER')) {
            $user = session('USER');
            $this->assign('USER', $user);
        } else {
            $this->assign('USER', '请先登录！！！');
        }
    }

    public function index()
    {
        if (session('USER')) {
            $where = array();
            $where['garden_id'] = session('USER.garden_id');
            $where['is_delete'] = NOT_DELETED;
            $garden_name = M('garden')->where($where)->find()['garden_name'];
            $this->assign('garden_name', $garden_name);
            $this->display();
        } else {
            $this->success('请先登录！！', U('Login/login'), 1);
        }
    }

    public function user_edit()
    {
        $this->display();
    }

    /**
     *
     * 获取物业管理员个人信息
     * Date: 2020-12-29 13:09:16
     * Update: 2020-12-29 13:09:16
     * Version: 1.00
     */
    public function getUser()
    {
        $user = M('user');
        $where = array();
        $where['a.manager_id'] = session('USER.manager_id');
        $join = [
            "join __GARDEN__ b on a.garden_id = b.garden_id",
            "join __BUILDING__ c on a.building_id = c.building_id"
        ];
        $field = ['a.manager_id', 'a.manager_name', 'a.manager_mobile', 'a.name', 'a.password', 'a.remark', 'b.garden_name', 'c.building_name'];
        $data = $user->alias('a')->join($join)->where($where)->field($field)->select();
        echo json_encode($data);
        die();
    }

    /**
     * 编辑物业管理员信息
     * Date: 2020-12-29 13:09:35
     * Update: 2020-12-29 13:09:35
     * Version: 1.00
     */
    public function editUser()
    {
        $user = M('user');
        $where = array();
        $where['manager_id'] = session('USER.manager_id');
        $data = $_POST;
        if (strcmp($_POST['password'], session('USER.password')) == 0) {
            $data['password'] = $_POST['password'];
        } else {
            $data['password'] = md5($_POST['password']);
        }
        $result = $user->where($where)->save($data);
        if ($result === false) {
            $this->error('系统繁忙!!!');
        } else {
            $userInfo = $user->where($where)->find();
            session('USER', $userInfo);
            $this->success('编辑成功!!!');
        }
    }

    /**
     * 欢迎页
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-14 14:56:41
     * Update: 2021-02-14 14:56:41
     * Version: 1.00
     */
    public function welcome()
    {
        $room = D('Room')->welList();
        $this->assign('room', $room);
        $this->assign('now', date('Y-m-d H:i:s'));
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


        $this->display();
    }


    public function welcomeList(){
        $data = D('Bill')->findTotal($_POST);
        $list = D('Bill')->payTotal($_POST);
        $result = array_merge($data, $list);
        echo json_encode($result);
    }

    /**
     * 验证用户名除本身外不重复
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Update: 2021-02-14 14:26:05
     * Version: 1.00
     */
    public function verifyName()
    {
        if (IS_AJAX) {
            $result = D('User')->checkNameByID($_POST);
            echo json_encode($result);
        }
    }
}