<?php

namespace Manage\Controller;

use Think\Controller;

class LeaseController extends Controller
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
    public function getLeaseList()
    {
        if (IS_AJAX) {
            $data = D('Lease')->getLeaseInfo($_GET);
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
     * 对租户生成房屋租赁关系
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-16 14:15:06
     * Update: 2021-02-16 14:15:06
     * Version: 1.00
     */
    public function addLease()
    {
        if (IS_AJAX) {
            $post_token = I('post.TOKEN');
            if (!checkToken($post_token)) {
                echo json_encode(getReturn(CODE_ERROR, '请不要重复提交页面!!!!'));
//                $this->error('请不要重复提交页面',U('User/Index/login'));
            } else {
                $result = D('Lease')->addLeaseByCustomer($_POST);
                echo json_encode($result);
            }
        }
    }

    public function lease_add()
    {
        createToken('TOKEN');
        $this->display();
    }

    /**
     *
     * @param int $leaseId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-18 15:49:10
     * Update: 2021-02-18 15:49:10
     * Version: 1.00
     */
    public function getLease($leaseId = 0)
    {
        if (IS_AJAX) {
            $data = D('Lease')->getLeaseById($leaseId);
            echo json_encode($data);
        }
    }
}