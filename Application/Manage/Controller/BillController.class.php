<?php

namespace Manage\Controller;

use Think\Controller;

class BillController extends Controller
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
        $this->display();
    }

    /**
     * 获取租赁关系信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-16 15:58:31
     * Update: 2021-02-16 15:58:31
     * Version: 1.00
     */
    public function getBillList()
    {
        if (IS_AJAX) {
            $data = D('Bill')->getBillInfo($_GET);
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
     * 删除当前账单
     * @param int $billId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-19 14:43:20
     * Update: 2021-02-19 14:43:20
     * Version: 1.00
     */
    public function deleteBill($billId = 0)
    {
        if (IS_AJAX) {
            $result = D('Bill')->deleteBillById($billId);
            echo json_encode($result);
        }
    }

    /**
     * 批量删除账单
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-03 22:08:28
     * Update: 2021-03-03 22:08:28
     * Version: 1.00
     */
    public function delAllBill()
    {
        if (IS_AJAX) {
            $result = D('Bill')->delAllByBillId($_POST['datas']);
            echo json_encode($result);
        }
    }
}