<?php

namespace Manage\Controller;

use Think\Controller;

class PowerController extends Controller
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
     * 获取电表表单信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 15:55:13
     * Update: 2021-02-24 15:55:13
     * Version: 1.00
     */
    public function getPowerList()
    {
        if (IS_AJAX) {
            $data = D('Power')->getPowerInfo($_GET);
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
     * @param int $powerId
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 16:10:05
     * Update: 2021-02-24 16:10:05
     * Version: 1.00
     */
    public function getPower($powerId = 0)
    {
        if (IS_AJAX) {
            $data = D('Power')->getPowerById($powerId);
            echo json_encode($data);
        }
    }

    public function power_edit()
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
    public function editPower()
    {
        if (IS_AJAX) {
            $post_token = I('post.TOKEN');
            if (!checkToken($post_token)) {
                echo json_encode(getReturn(CODE_ERROR, '请不要重复提交页面!!!!'));
            } else {
                $result = D('Power')->powerEdit($_POST);
                echo json_encode($result);
            }
        }
    }

    public function power_add()
    {
        createToken('TOKEN');
        $this->display();
    }

    /**
     * 添加电表
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-25 15:50:43
     * Update: 2021-02-25 15:50:43
     * Version: 1.00
     */
    public function addPower()
    {
        if (IS_AJAX) {
            $post_token = I('post.TOKEN');
            if (!checkToken($post_token)) {
                echo json_encode(getReturn(CODE_ERROR, '请不要重复提交页面!!!!'));
            } else {
                $result = D('Power')->addPower($_POST);
                echo json_encode($result);
            }
        }
    }
}