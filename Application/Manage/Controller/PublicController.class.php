<?php

namespace Manage\Controller;

use Think\Controller;
use Think\Model;

class PublicController extends Controller
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

    /**
     * 选择框获取房屋信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-25 22:29:45
     * Update: 2021-01-25 22:29:45
     * Version: 1.00
     */
    public function getRoomData()
    {
        $where = array();
        $where['is_delete'] = NOT_DELETED;
        $where['room_status'] = 0;
        $where['manager_id'] = session('USER.manager_id');
        $list = M('room')->where($where)->select();
        echo json_encode($list);
    }

    /**
     * 选择框获取租户信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-16 15:40:24
     * Update: 2021-02-16 15:40:24
     * Version: 1.00
     */
    public function getCustomerData()
    {
        $where = array();
        $where['is_delete'] = NOT_DELETED;
        $where['manager_id'] = session('USER.manager_id');
        $list = M('customer')->where($where)->select();
        echo json_encode($list);
    }

    public function getRoom()
    {
        if (IS_AJAX) {
            $where = array();
            $where['is_delete'] = NOT_DELETED;
            $where['room_status'] = 1;
            $list = M('room')->where($where)->select();
            echo json_encode($list);
        }
    }

    /**
     * 获取已租赁且未添加水表的房屋
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-26 16:50:35
     * Update: 2021-02-26 16:50:35
     * Version: 1.00
     */
    public function getRoomByWater()
    {
        if (IS_AJAX) {
            $where = array();
            $where['is_delete'] = NOT_DELETED;
            $where['room_status'] = 1;
            $list = M('room')->where($where)->select();
            foreach ($list as $key => $value) {
                $map = array();
                $map['room_id'] = $value['room_id'];
                $data = M('water')->where($map)->select();
                if (!empty($data)) {
                    unset($list[$key]);
                }
            }
            echo json_encode($list);
        }
    }

    /**
     * 获取已租赁且未添加电表的房屋
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-26 16:50:35
     * Update: 2021-02-26 16:50:35
     * Version: 1.00
     */
    public function getRoomByPower()
    {
        if (IS_AJAX) {
            $where = array();
            $where['is_delete'] = NOT_DELETED;
            $where['room_status'] = 1;
            $list = M('room')->where($where)->select();
            foreach ($list as $key => $value) {
                $map = array();
                $map['room_id'] = $value['room_id'];
                $data = M('power')->where($map)->select();
                if (!empty($data)) {
                    unset($list[$key]);
                }
            }
            echo json_encode($list);
        }
    }
}