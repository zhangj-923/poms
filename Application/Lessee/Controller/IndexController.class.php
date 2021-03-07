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

    /**
     * 账单支付
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 14:46:23
     * Update: 2021-03-07 14:46:23
     * Version: 1.00
     */
    public function payBill()
    {
        if (IS_AJAX) {
            $resutl = D('Bill')->payBillById($_POST['bill_id']);
            echo json_encode($resutl);
        }

    }

    /**
     * 获取租户个人信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 15:23:11
     * Update: 2021-03-07 15:23:11
     * Version: 1.00
     */
    public function getCustomer()
    {
        if (IS_AJAX) {
            $result = D('Customer')->getCus();
            echo json_encode($result);
        }
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
            $result = D('Customer')->checkMobileByID($_POST);
            echo json_encode($result);
        }
    }

    /**
     * 修改租户个人信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 15:49:42
     * Update: 2021-03-07 15:49:42
     * Version: 1.00
     */
    public function editCustomer()
    {
        if (IS_AJAX) {
            $result = D('Customer')->editCustomer($_POST);
            echo json_encode($result);
        }
    }


    public function repair_add()
    {
        createToken('TOKEN');
        $this->display();
    }


    /**
     * 添加报修内容
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 18:46:01
     * Update: 2021-03-07 18:46:01
     * Version: 1.00
     */
    public function addRepair()
    {
        if (IS_AJAX) {
            $post_token = I('post.TOKEN');
            if (!checkToken($post_token)) {
                echo json_encode(getReturn(CODE_ERROR, '请不要重复提交页面!!!!'));
            } else {
                $result = D('Repair')->addRepair($_POST);
                echo json_encode($result);
            }
        }
    }

    /**
     * 获取报修详情
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 18:54:55
     * Update: 2021-03-07 18:54:55
     * Version: 1.00
     */
    public function getRepairList()
    {
        if (IS_AJAX) {
            $data = D('Repair')->getRepairInfo();
            echo json_encode($data);
        }

    }

    /**
     * 删除报修信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 19:19:18
     * Update: 2021-03-07 19:19:18
     * Version: 1.00
     */
    public function delRepair()
    {
        if (IS_AJAX) {
            $result = D('Repair')->deleteRepair($_POST['repair_id']);
            echo json_encode($result);
        }
    }
}