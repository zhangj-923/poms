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
     * 删除楼宇
     * @param $buildingId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:31:53
     * Update: 2021-01-17 15:31:53
     * Version: 1.00
     */
    public function deleteBuilding($buildingId = 0)
    {
        if (IS_AJAX) {
            $result = D('Building')->deleteBuildingById($buildingId);
            echo json_encode($result);
        }
    }

    /**
     * 添加楼宇
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:42:42
     * Update: 2021-01-17 15:42:42
     * Version: 1.00
     */
    public function addBuilding()
    {
        if (IS_AJAX) {
            $result = D('Building')->addBuildingInfo($_POST);
            echo json_encode($result);
        }
    }

    /**
     * 根据楼宇id获取楼宇信息
     * @param int $buildingId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:53:36
     * Update: 2021-01-17 15:53:36
     * Version: 1.00
     */
    public function getBuilding($buildingId = 0)
    {
        if (IS_AJAX) {
            $data = D('Building')->getBuildingById($buildingId);
            echo json_encode($data);
        }
    }

    /**
     * 编辑楼宇信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:59:29
     * Update: 2021-01-17 15:59:29
     * Version: 1.00
     */
    public function editBuilding()
    {
        if (IS_AJAX) {
            $result = D('Building')->editBuildingInfo($_POST);
            echo json_encode($result);
        }
    }


}