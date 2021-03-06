<?php

namespace Lessee\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function _initialize()
    {
        if (session('CUSTOMER')) {
            $user = session('CUSTOMER');
            $this->assign('CUSTOMER', $user);
        } else {
            $this->assign('CUSTOMER', '请先登录！！！');
        }
    }

    public function index()
    {
        if (session('CUSTOMER')) {
            $customer_name = session('CUSTOMER.customer_name');
            $this->assign('customer_name', $customer_name);
            //获取租户所租房屋信息
            $roomInfo = D('Customer')->getRoomInfo();
            $this->assign('roomInfo', $roomInfo);
            $this->display();
        } else {
            $this->success('请先登录！！', U('Login/login'), 1);
        }
    }

    public function getBillList()
    {
        if (IS_AJAX) {
            $customer_id = session('CUSTOMER.customer_id');
            $data = D('Bill')->getBill($customer_id);
//            $msg = [
//                'code' => 0,
//                'msg' => '查询成功',
//                'data' => $data['list'],
//                'count' => $data['count']
//            ];
            echo json_encode($data);
        }
    }
}