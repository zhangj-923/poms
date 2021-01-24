<?php

namespace Super\Controller;

use Think\Controller;

class GardenController extends Controller
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
     * 获取园区列表信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 14:53:34
     * Update: 2021-01-17 14:53:34
     * Version: 1.00
     */
    public function getGardenList()
    {
        if (IS_AJAX) {
            $data = D('Garden')->getGardenInfo($_GET);
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
     * 删除园区
     * @param $gardenId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:31:53
     * Update: 2021-01-17 15:31:53
     * Version: 1.00
     */
    public function deleteGarden($gardenId = 0)
    {
        if (IS_AJAX) {
            $result = D('Garden')->deleteGardenById($gardenId);
            echo json_encode($result);
        }
    }

    /**
     * 添加园区
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:42:42
     * Update: 2021-01-17 15:42:42
     * Version: 1.00
     */
    public function addGarden()
    {
        if (IS_AJAX) {
            $result = D('Garden')->addGardenInfo($_POST);
            echo json_encode($result);
        }
    }

    /**
     * 根据园区id获取园区信息
     * @param int $gardenId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:53:36
     * Update: 2021-01-17 15:53:36
     * Version: 1.00
     */
    public function getGarden($gardenId = 0)
    {
        if (IS_AJAX) {
            $data = D('Garden')->getGardenById($gardenId);
            echo json_encode($data);
        }
    }

    /**
     * 编辑园区信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:59:29
     * Update: 2021-01-17 15:59:29
     * Version: 1.00
     */
    public function editGarden()
    {
        if (IS_AJAX) {
            $result = D('Garden')->editGardenInfo($_POST);
            echo json_encode($result);
        }
    }

    /**
     * 监听园区状态
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-24 20:25:17
     * Update: 2021-01-24 20:25:17
     * Version: 1.00
     */
    public function changeStatus(){
        if (IS_AJAX){
            $result = D('Garden')->changeStatusByGardenId($_POST);
            echo json_encode($result);
        }
    }
}