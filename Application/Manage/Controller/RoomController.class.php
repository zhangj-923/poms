<?php
namespace Manage\Controller;
use Think\Controller;
class RoomController extends Controller {
    public function _initialize(){
        if (session('USER')){
            $user = session('USER');
            $this->assign('USER', $user);
        }else{
            $this->assign('USER', '请先登录！！！');
        }
    }

    public function index(){
        $this->display();
    }

    /**
     * 获取房屋列表
     * Date: 2020-12-28 15:18:07
     * Update: 2020-12-28 15:18:07
     * Version: 1.00
     */
    public function getRoomList(){
        $room = M('room');
        $where = array();
        $where['is_delete'] = 0;
        if (!empty($_GET['key'])){
            $where['room_sn|remark'] = ['like', '%'.$_GET['key'].'%'];
        }
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $start = $limit * ($page - 1);
        $data = $room->where($where)->limit($start, $limit)->order('room_id', 'desc')->select();
        $count = count($room->where($where)->select());
        foreach ($data as $key => $value){
            $data[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            if ($value['room_status'] === 1){
                $data[$key]['room_status'] = '已签约';
            }else{
                $data[$key]['room_status'] = '未签约';
            }
        }
        $msg = [
            'code' => 0,
            'msg' => '查询成功',
            'data' => $data,
            'count' => $count
        ];
        echo json_encode($msg);
        die();
    }

    /**
     *
     * 添加房屋
     * Date: 2020-12-28 15:30:30
     * Update: 2020-12-28 15:30:30
     * Version: 1.00
     */
    public function addRoom(){
        $room = M('room');
        $data = $_POST;
        $data['manager_id'] = session('USER.manager_id');
        $data['garden_id'] = session('USER.garden_id');
        $data['create_time'] = time();
        $result = $room->add($data);
        if ($result){
            $this->success('添加成功');
        }else {
            $this->error('系统繁忙，请重试！！');
        }
    }

    public function room_add(){
        $this->display();
    }

    /**
     * 根据房屋id获取房屋信息
     * @param string $roomId
     * Date: 2020-12-28 15:38:37
     * Update: 2020-12-28 15:38:37
     * Version: 1.00
     */
    public function getRoom($roomId = ''){
        $room = M('room');
        $where = array();
        $where['room_id'] = $roomId;
        $data = $room->where($where)->select();
        echo json_encode($data);
        die();
    }

    /**
     * 编辑房屋信息并保存
     * Date: 2020-12-28 15:39:08
     * Update: 2020-12-28 15:39:08
     * Version: 1.00
     */
    public function editRoom(){
        $room = M('room');
        $where = array();
        $where['room_id'] = $_POST['room_id'];
        $data = $_POST;
        $result = $room->where($where)->save($data);
        if ($result){
            $this->success('编辑成功!!!');
        }else{
            $this->error('系统繁忙!!!');
        }
    }

    public function room_edit(){
        $this->display();
    }

    /**
     * 删除房屋
     * @param string $roomId
     * Date: 2020-12-28 15:50:01
     * Update: 2020-12-28 15:50:01
     * Version: 1.00
     */
    public function deleteRoom($roomId = ''){
        $room = M('room');
        $where = array();
        $where['room_id'] = $roomId;
        $result = $room->where($where)->save(['is_delete' => 1]);
        if ($result){
            $this->success('删除成功');
        }else {
            $this->error('系统繁忙！！请重试');
        }
    }
}