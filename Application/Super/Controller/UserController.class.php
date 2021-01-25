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
}