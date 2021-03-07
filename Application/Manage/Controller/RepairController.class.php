<?php

namespace Manage\Controller;

use Think\Controller;

class RepairController extends Controller
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
     * 获取报修列表
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 22:53:22
     * Update: 2021-03-07 22:53:22
     * Version: 1.00
     */
    public function getRepairList()
    {
        if (IS_AJAX) {
            $data = D('Repair')->getRepairList($_GET);
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
     * 删除电表
     * @param int $powerId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-25 16:00:56
     * Update: 2021-02-25 16:00:56
     * Version: 1.00
     */
    public function deletePower($powerId = 0)
    {
        if (IS_AJAX) {
            $result = D('Power')->deletePowerById($powerId);
            echo json_encode($result);
        }
    }

    /**
     * 获取该电表信息
     * @param int $repairId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 16:10:05
     * Update: 2021-02-24 16:10:05
     * Version: 1.00
     */
    public function getRepair($repairId = 0)
    {
        if (IS_AJAX) {
            $data = D('Repair')->getRepairById($repairId);
            echo json_encode($data);
        }
    }

    public function repair_deal()
    {
        createToken('TOKEN');
        $this->display();
    }

    public function dealRepair()
    {
        if (IS_AJAX) {
            $post_token = I('post.TOKEN');
            if (!checkToken($post_token)) {
                echo json_encode(getReturn(CODE_ERROR, '请不要重复提交页面!!!!'));
            } else {
                $result = D('Deal')->dealRepair($_POST);
                echo json_encode($result);
            }
        }
    }


}