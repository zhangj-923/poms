<?php

namespace Super\Controller;

use Think\Controller;

class UserController extends Controller
{

    public function _initialize()
    {
        if (session('ADMIN')) {
            $admin = session('ADMIN');
            $this->assign('ADMIN', $admin);
        } else {
            $this->assign('ADMIN', '请先登录！！！');
        }
    }

    /**
     * 获取楼宇管理员列表
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-25 20:28:27
     * Update: 2021-01-25 20:28:27
     * Version: 1.00
     */
    public function getUserList()
    {
        if (IS_AJAX) {
            $data = D('User')->getUserInfo($_GET);
            $msg = [
                'code' => 0,
                'msg' => '查询成功',
                'data' => $data['list'],
                'count' => $data['count']
            ];
            echo json_encode($msg);
        }
    }


    /**
     * 删除当前楼宇管理员信息
     * @param int $managerId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-25 22:33:28
     * Update: 2021-01-25 22:33:28
     * Version: 1.00
     */
    public function deleteUser($managerId = 0)
    {
        if (IS_AJAX) {
            $result = D('User')->deleteUserById($managerId);
            echo json_encode($result);
        }
    }

    /**
     * 添加楼宇管理员
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 13:18:12
     * Update: 2021-01-29 13:18:12
     * Version: 1.00
     */
    public function addUser()
    {
        if (IS_AJAX) {
            $result = D('User')->addUserInfo($_POST);
            echo json_encode($result);
        }
    }

    /**
     * 验证楼宇管理员登录用户名不重复
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 13:54:28
     * Update: 2021-01-29 13:54:28
     * Version: 1.00
     */
    public function verifyName()
    {
        if (IS_AJAX) {
            $result = D('User')->checkName($_POST);
            echo json_encode($result);
        }
    }

    /**
     * 根据楼宇管理员id获取管理员信息
     * @param int $managerId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 15:35:12
     * Update: 2021-01-29 15:35:12
     * Version: 1.00
     */
    public function getUser($managerId = 0)
    {
        if (IS_AJAX) {
            $data = D('User')->getUserById($managerId);
            echo json_encode($data);
        }
    }

    /**
     * 编辑楼宇管理员信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 16:01:14
     * Update: 2021-01-29 16:01:14
     * Version: 1.00
     */
    public function editUser()
    {
        if (IS_AJAX) {
            $result = D('User')->editUserInfo($_POST);
            echo json_encode($result);
        }
    }

    /**
     * 密码初始化
     * @param int $managerId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 16:13:35
     * Update: 2021-01-29 16:13:35
     * Version: 1.00
     */
    public function resetUserPass($managerId = 0)
    {
        if (IS_AJAX) {
            $result = D('User')->resetUserById($managerId);
            echo json_encode($result);
        }
    }

    /**
     * 验证楼宇管理员编辑录用户名不重复
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 13:54:28
     * Update: 2021-01-29 13:54:28
     * Version: 1.00
     */
    public function verifyNameByID()
    {
        if (IS_AJAX) {
            $result = D('User')->checkNameByID($_POST);
            echo json_encode($result);
        }
    }
}