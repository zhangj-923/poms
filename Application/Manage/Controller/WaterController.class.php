<?php

namespace Manage\Controller;

use Think\Controller;

class WaterController extends Controller
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
     * 获取水表表单信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 15:55:13
     * Update: 2021-02-24 15:55:13
     * Version: 1.00
     */
    public function getWaterList()
    {
        if (IS_AJAX) {
            $data = D('Water')->getWaterInfo($_GET);
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
     * 删除水表
     * @param int $waterId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 15:55:42
     * Update: 2021-02-24 15:55:42
     * Version: 1.00
     */
    public function deleteWater($waterId = 0)
    {
        if (IS_AJAX) {
            $result = D('Water')->deleteWaterById($waterId);
            echo json_encode($result);
        }
    }

    /**
     * 获取该水表信息
     * @param int $waterId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 16:10:05
     * Update: 2021-02-24 16:10:05
     * Version: 1.00
     */
    public function getWater($waterId = 0)
    {
        if (IS_AJAX) {
            $data = D('Water')->getWaterById($waterId);
            echo json_encode($data);
        }
    }

    public function water_edit()
    {
        createToken('TOKEN');
        $this->display();
    }

    /**
     * 保存修改后的内容
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 16:25:58
     * Update: 2021-02-24 16:25:58
     * Version: 1.00
     */
    public function editWater()
    {
        if (IS_AJAX) {
            $post_token = I('post.TOKEN');
            if (!checkToken($post_token)) {
                echo json_encode(getReturn(CODE_ERROR, '请不要重复提交页面!!!!'));
            } else {
                $result = D('Water')->waterEdit($_POST);
                echo json_encode($result);
            }
        }
    }


    public function water_add()
    {
        createToken('TOKEN');
        $this->display();
    }

    /**
     * 添加水表
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-26 16:46:43
     * Update: 2021-02-26 16:46:43
     * Version: 1.00
     */
    public function addWater()
    {
        if (IS_AJAX) {
            $post_token = I('post.TOKEN');
            if (!checkToken($post_token)) {
                echo json_encode(getReturn(CODE_ERROR, '请不要重复提交页面!!!!'));
            } else {
                $result = D('Water')->addWater($_POST);
                echo json_encode($result);
            }
        }
    }
}