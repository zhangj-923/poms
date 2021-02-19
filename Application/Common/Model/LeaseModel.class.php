<?php

namespace Common\Model;

use Think\Model;

class LeaseModel extends BaseModel
{
    /**
     * 根据租户生成房屋租赁关系
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-16 14:22:13
     * Update: 2021-02-16 14:22:13
     * Version: 1.00
     */
    public function addLeaseByCustomer($request = [])
    {
        $sing_time = $request['sing_time'];
        if ($request['lease_team'] == 1) {
            $request['expire_time'] = date('Y-m-d', strtotime("$sing_time +3 month"));
        } elseif ($request['lease_team'] == 2) {
            $request['expire_time'] = date('Y-m-d', strtotime("$sing_time +6 month"));
        } elseif ($request['lease_team'] == 3) {
            $request['expire_time'] = date('Y-m-d', strtotime("$sing_time +1 year"));
        }
        $request['sing_time'] = strtotime($request['sing_time']);
        $request['expire_time'] = strtotime($request['expire_time']);
        $request['create_time'] = time();
        $request['garden_id'] = session('USER.garden_id');
        $this->startTrans();
        $result = $this->add($request);
        if ($result) {
            $where = array();
            $where['room_id'] = $request['room_id'];
            $result1 = M('room')->where($where)->save(['room_status' => 1]);
            if ($result1 === false) {
                $this->rollback();
                return getReturn(CODE_ERROR, '房租租赁状态修改失败，请稍后再试！！！');
            } else {
                $this->commit();
                return getReturn(CODE_SUCCESS, '租赁关系生成成功！！！');
            }
        } else {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        }
    }

    /**
     * 获取租赁关系信息
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-16 16:00:37
     * Update: 2021-02-16 16:00:37
     * Version: 1.00
     */
    public function getLeaseInfo($request = [])
    {
        $field = ['a.*', 'b.customer_name', 'b.customer_mobile', 'c.room_sn', 'd.garden_name'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
//        if (!empty($request['key2'])) {
//            $where['a.building_name'] = ['like', '%' . $request['key2'] . '%'];
//        }
        $page = $request['page'];
        $limit = $request['limit'];
        $join = [
            'join __CUSTOMER__ b on a.customer_id = b.customer_id',
            'join __ROOM__ c on a.room_id = c.room_id',
            'join __GARDEN__ d on a.garden_id = d.garden_id'
        ];
        $options = [];
        $options['alias'] = 'a';
        $options['where'] = $where;
        $count = $this->getCount($options);
        if (!empty($request['key1'])) {
            $where['b.customer_name|c.room_sn'] = ['like', '%' . $request['key1'] . '%'];
        }
        if (!empty($request['key2'])) {
            $where['lease_team'] = $request['key2'];
        }
        $options['where'] = $where;
        $options['field'] = $field;
        $options['join'] = $join;
        $options['limit'] = $limit;
        $options['page'] = $page;
        $options['order'] = 'a.create_time asc';
        $list = $this->queryList($options);
        foreach ($list as $key => $value) {
            $list[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $list[$key]['sing_time'] = date('Y-m-d', $value['sing_time']);
            $list[$key]['expire_time'] = date('Y-m-d', $value['expire_time']);
            if ($value['lease_team'] == 1) {
                $list[$key]['total_rent'] = $value['rent'] * 3;
                $list[$key]['team'] = '一季度';
            } elseif ($value['lease_team'] == 2) {
                $list[$key]['total_rent'] = $value['rent'] * 6;
                $list[$key]['team'] = '半年';
            } elseif ($value['lease_team'] == 3) {
                $list[$key]['total_rent'] = $value['rent'] * 12;
                $list[$key]['team'] = '一年';
            }
        }
        return ['list' => $list, 'count' => $count];
    }

    /**
     *
     * @param int $lease_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-18 15:52:32
     * Update: 2021-02-18 15:52:32
     * Version: 1.00
     */
    public function getLeaseById($lease_id = 0)
    {
//        $field = ['a.*', 'b.customer_name', 'b.customer_mobile', 'c.room_sn', 'd.garden_name'];
        $where = array();
        $where['lease_id'] = $lease_id;
//        $join = [
//            'join __CUSTOMER__ b on a.customer_id = b.customer_id',
//            'join __ROOM__ c on a.room_id = c.room_id',
//            'join __GARDEN__ d on a.garden_id = d.garden_id'
//        ];
        $options = [];
//        $options['alias'] = 'a';
        $options['where'] = $where;
//        $options['field'] = $field;
//        $options['join'] = $join;
//        $options['order'] = 'a.create_time asc';
        $data = $this->queryRow($options);
        $data['sing_time'] = date('Y-m-d', $data['sing_time']);
        return getReturn(CODE_SUCCESS, '查询成功', $data);
    }

    /**
     * 修改租赁关系
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-19 14:32:31
     * Update: 2021-02-19 14:32:31
     * Version: 1.00
     */
    public function leaseEdit($request = [])
    {
        $where = array();
        $where['lease_id'] = $request['lease_id'];
        $sing_time = $request['sing_time'];
        if ($request['lease_team'] == 1) {
            $request['expire_time'] = date('Y-m-d', strtotime("$sing_time +3 month"));
        } elseif ($request['lease_team'] == 2) {
            $request['expire_time'] = date('Y-m-d', strtotime("$sing_time +6 month"));
        } elseif ($request['lease_team'] == 3) {
            $request['expire_time'] = date('Y-m-d', strtotime("$sing_time +1 year"));
        }
        $request['sing_time'] = strtotime($request['sing_time']);
        $request['expire_time'] = strtotime($request['expire_time']);
//        $request['create_time'] = time();
//        $request['garden_id'] = session('USER.garden_id');
        $result = $this->where($where)->save($request);
        if ($result === false) {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            return getReturn(CODE_SUCCESS, '租赁关系编辑修改成功！！');
        }
//        $this->startTrans();
//        $result = $this->add($request);
//        if ($result) {
//            $where = array();
//            $where['room_id'] = $request['room_id'];
//            $result1 = M('room')->where($where)->save(['room_status' => 1]);
//            if ($result1 === false) {
//                $this->rollback();
//                return getReturn(CODE_ERROR, '房租租赁状态修改失败，请稍后再试！！！');
//            } else {
//                $this->commit();
//                return getReturn(CODE_SUCCESS, '租赁关系生成成功！！！');
//            }
//        } else {
//            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
//        }
    }

    /**
     * 解除当前id的租赁关系
     * @param int $lease_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-19 14:44:55
     * Update: 2021-02-19 14:44:55
     * Version: 1.00
     */
    public function deleteLeasegById($lease_id = 0)
    {
        $where = array();
        $where['lease_id'] = $lease_id;
        $room_id = $this->where($where)->find()['room_id'];
        $this->startTrans();
        $result = $this->where($where)->save(['is_delete' => DELETED]);
        if ($result === false) {
            return getReturn(CODE_ERROR, '租赁关系解除失败，请稍后再试！！！');
        } else {
            $where1 = array();
            $where1['room_id'] = $room_id;
            $result1 = M('room')->where($where1)->save(['room_status' => 0]);
            if ($result1 === false) {
                $this->rollback();
                return getReturn(CODE_ERROR, '房屋状态释放失败，请稍后再试！');
            } else {
                $this->commit();
                return getReturn(CODE_SUCCESS, '当前租赁关系解除成功!!!!!');
            }
        }
    }
}