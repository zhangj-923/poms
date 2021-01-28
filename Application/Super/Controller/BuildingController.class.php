<?php

namespace Super\Controller;

use Think\Controller;

class BuildingController extends Controller
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

    public function index()
    {
        $this->display();
    }

    /**
     * 获取楼宇列表信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 14:53:34
     * Update: 2021-01-17 14:53:34
     * Version: 1.00
     */
    public function getBuildingList()
    {
        if (IS_AJAX) {
            $data = D('Building')->getBuildingInfo($_GET);
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