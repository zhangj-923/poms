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
        } else if ($request['lease_team'] == 2) {
            $request['expire_time'] = date('Y-m-d', strtotime("$sing_time +6 month"));
        } else if ($request['lease_team'] == 3) {
            $request['expire_time'] = date('Y-m-d', strtotime("$sing_time +1 year"));
        } else if ($request['lease_team'] == 4) {
            $month = $request['month'];
            $request['expire_time'] = date('Y-m-d', strtotime("$sing_time +$month month"));
        }
        $request['sing_time'] = strtotime($request['sing_time']);
        $request['expire_time'] = strtotime($request['expire_time']);
        $request['create_time'] = time();
        $request['manager_id'] = session('USER.manager_id');
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
        $field = ['a.*', 'b.customer_name', 'b.customer_mobile', 'c.room_sn', 'd.garden_name', 'e.building_name'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
        $where['a.manager_id'] = session('USER.manager_id');
//        if (!empty($request['key2'])) {
//            $where['a.building_name'] = ['like', '%' . $request['key2'] . '%'];
//        }
        $page = $request['page'];
        $limit = $request['limit'];
        $join = [
            'join __CUSTOMER__ b on a.customer_id = b.customer_id',
            'join __ROOM__ c on a.room_id = c.room_id',
            'join __USER__ u on a.manager_id = u.manager_id',
            'join __GARDEN__ d on u.garden_id = d.garden_id',
            'join __BUILDING__ e on u.building_id = e.building_id'
        ];
        $options = [];
        $options['alias'] = 'a';
//        $options['where'] = $where;
//        $count = $this->getCount($options);
        if (!empty($request['key1'])) {
            $where['b.customer_name|c.room_sn'] = ['like', '%' . $request['key1'] . '%'];
        }
        if (!empty($request['key2'])) {
            $where['a.lease_team'] = $request['key2'];
        }
        if (!empty($request['key3'])) {
            if ($request['key3'] == 1) {
                $where['a.expire_time'] = array('egt', time());
            } else if ($request['key3'] == 2) {

                $where['a.expire_time'] = array('lt', time());
                $where['a.is_exit'] = array('neq', IS_EXIT);
            } else if ($request['key3'] == 3) {
                $where['a.is_exit'] = IS_EXIT;
            }
        }
        $options['where'] = $where;
        $options['field'] = $field;
        $options['join'] = $join;
        $count = $this->getCount($options);
        $options['limit'] = $limit;
        $options['page'] = $page;
        $options['order'] = 'a.create_time asc';
        $list = $this->queryList($options);
        foreach ($list as $key => $value) {
            if ($value['expire_time'] >= time()) {
                $list[$key]['lease_status'] = '生效中';
            } else {
                $list[$key]['lease_status'] = '已到期';
            }
            if ($value['is_exit'] == IS_EXIT) {
                $list[$key]['lease_status'] = '已退租';
            }
            if ($value['lease_team'] == 1) {
                $list[$key]['total_rent'] = $value['rent'] * 3;
                $list[$key]['team'] = '一季度';
            } else if ($value['lease_team'] == 2) {
                $list[$key]['total_rent'] = $value['rent'] * 6;
                $list[$key]['team'] = '半年';
            } else if ($value['lease_team'] == 3) {
                $list[$key]['total_rent'] = $value['rent'] * 12;
                $list[$key]['team'] = '一年';
            } else if ($value['lease_team'] == 4) {
                $list[$key]['total_rent'] = $value['rent'] * $value['month'];
                $list[$key]['team'] = $value['month'] . '个月';
            }
            if ($value['exit_time'] == 0) {
                $list[$key]['exit_time'] = '--';
            } else {
                $list[$key]['exit_time'] = date('Y-m-d', $value['exit_time']);
            }
            $list[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            $list[$key]['sing_time'] = date('Y-m-d', $value['sing_time']);
            $list[$key]['expire_time'] = date('Y-m-d', $value['expire_time']);
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

    public function resetRoomById($lease_id = 0)
    {
        $where = array();
        $where['lease_id'] = $lease_id;
        $exit = $this->where($where)->find()['is_exit'];
        if ($exit == IS_RELEASE){
            return getReturn(CODE_SUCCESS, '房屋状态已释放，不用重复该操作！');
        }else if ($exit == NOT_EXIT){
            $this->startTrans();
            $this->where($where)->save(['is_exit' => IS_RELEASE]);
            $room_id = $this->where($where)->find()['room_id'];
            $where1 = array();
            $where1['room_id'] = $room_id;
            $result1 = M('room')->where($where1)->save(['room_status' => 0]);
            if ($result1 === false) {
                $this->rollback();
                return getReturn(CODE_ERROR, '房屋状态释放失败，请稍后再试！');
            } else {
                $this->commit();
                return getReturn(CODE_SUCCESS, '房屋状态已释放!!!!!');
            }
        }
//        $room_id = $this->where($where)->find()['room_id'];
//        $where1 = array();
//        $where1['room_id'] = $room_id;
//        $result1 = M('room')->where($where1)->find()['room_status'];
//        if ($result1 == 0) {
//            return getReturn(CODE_SUCCESS, '房屋状态已释放，不用重复该操作！');
//        } else {
//            $result = M('room')->where($where1)->save(['room_status' => 0]);
//            if ($result === false) {
//                return getReturn(CODE_ERROR, '房屋状态释放失败，请稍后再试！');
//            } else {
//                return getReturn(CODE_SUCCESS, '房屋状态已释放!!!!!');
//            }
//        }
    }

    /**
     * 获取租赁信息 传递生成当月账单
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-03 16:00:48
     * Update: 2021-03-03 16:00:48
     * Version: 1.00
     */
    public function createBillByLease()
    {
        $where = array();
        $where['is_delete'] = NOT_DELETED;
        $where['is_exit'] = NOT_EXIT;
        $where['manager_id'] = session('USER.manager_id');
        $where['expire_time'] = array('egt', time());
        $where['sing_time'] = array('elt', time());
        $list = $this->where($where)->select();
        foreach ($list as $key => $value) {
            $time = floor(floor(((time() - $value['sing_time']) / (24 * 3600))) / 30);
            if ($time == 0) {
                $list[$key]['bill_remark'] = date('m', $value['sing_time']) . '月房租';
                $list[$key]['last_time'] = $value['sing_time'];
            } else if ($time >= 1) {
                $month = $time - 1;
                $singTime = date('Y-m-d', $value['sing_time']);
                $list[$key]['bill_remark'] = date('m', strtotime("$singTime +$month month")) . '月房租';
                $list[$key]['last_time'] = strtotime("$singTime +$month month");
            }
        }
        $result = D('Bill')->createBillLease($list);
        if ($result > 0) {
            return getReturn(CODE_SUCCESS, '共生成' . $result . '条房租账单记录！！！');
        } else if ($result == 0) {
            return getReturn(CODE_SUCCESS, '当月房租账单均与生成，不用在重复生成！！！');
        } else {
            return getReturn(CODE_ERROR, '生成房租账单失败，请稍后重试！！！');
        }
    }

    /**
     * 根据lease_id进行退租
     * @param int $lease_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-06 13:47:42
     * Update: 2021-03-06 13:47:42
     * Version: 1.00
     */
    public function exitLeaseById($lease_id = 0)
    {
        $where = array();
        $where['lease_id'] = $lease_id;
        $room_id = $this->where($where)->find()['room_id'];
        $this->startTrans();
        $data['is_exit'] = IS_EXIT;
        $data['exit_time'] = time();
        $result = $this->where($where)->save($data);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '申请退租失败，请稍后再试！');
        } else {
            $where1 = array();
            $where1['room_id'] = $room_id;
            $result1 = M('room')->where($where1)->save(['room_status' => 0]);
            if ($result1 === false) {
                $this->rollback();
                return getReturn(CODE_ERROR, '房屋状态释放失败，不能成功进行申请退租，请稍后再试！');
            } else {
                $this->commit();
                return getReturn(CODE_SUCCESS, '当前房屋退租申请成功!!!!!');
            }
        }
    }
}