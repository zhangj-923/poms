<?php

namespace Super\Controller;

use Think\Controller;

class PublicController extends Controller
{

    /**
     * 选择框获取园区信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-25 22:29:45
     * Update: 2021-01-25 22:29:45
     * Version: 1.00
     */
    public function getGardenData()
    {
        $where = array();
        $where['is_delete'] = NOT_DELETED;
        $list = M('garden')->where($where)->select();
        echo json_encode($list);
    }

    public function getBuildingData()
    {
        $where = array();
        $where['is_delete'] = NOT_DELETED;
        if (empty($_POST)) {
            $where['garden_id'] = $_POST['garden_id'];
        }
        $list = M('building')->where($where)->select();
        echo json_encode($list);
    }
}