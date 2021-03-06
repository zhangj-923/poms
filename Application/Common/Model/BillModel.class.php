<?php

namespace Common\Model;

use Think\Model;

class BillModel extends BaseModel
{
    /**
     * 生成水费账单
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-01 17:06:17
     * Update: 2021-03-01 17:06:17
     * Version: 1.00
     */
    public function createBillByWater($request = [])
    {
        $request['total'] = ($request['current'] - $request['last_current']) * $request['price'];
        $request['bill_type'] = BILL_WATER;
        $request['create_time'] = time();
        $this->startTrans();
        $result = $this->add($request);
        if ($result) {
            $this->commit();
            return true;
        } else {
            $this->rollback();
            return false;
        }
    }

    /**
     * 获取账单列表
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-01 17:20:58
     * Update: 2021-03-01 17:20:58
     * Version: 1.00
     */
    public function getBillInfo($request = [])
    {
        $field = ['a.*', 'b.customer_name', 'b.customer_mobile', 'c.room_sn', 'd.garden_name', 'e.building_name', 'u.manager_name', 'l.is_exit', 'l.expire_time'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
        $where['a.manager_id'] = session('USER.manager_id');
        $page = $request['page'];
        $limit = $request['limit'];
        $join = [
            'join __CUSTOMER__ b on a.customer_id = b.customer_id',
            'join __ROOM__ c on a.room_id = c.room_id',
            'join __USER__ u on a.manager_id = u.manager_id',
            'join __GARDEN__ d on u.garden_id = d.garden_id',
            'join __BUILDING__ e on u.building_id = e.building_id',
            'join __LEASE__ l on a.lease_id = l.lease_id'
        ];
        $options = [];
        $options['alias'] = 'a';
//        $options['where'] = $where;
//        $count = $this->getCount($options);
        if (!empty($request['key1'])) {
            $where['b.customer_name|c.room_sn|a.bill_remark'] = ['like', '%' . $request['key1'] . '%'];
        }
        if (!empty($request['key2'])) {
            $where['bill_type'] = $request['key2'];
        }
        if (!empty($request['last_time']) && empty($request['time'])) {
            $where['a.last_time'] = array('egt', strtotime($request['last_time']));
        } else if (empty($request['last_time']) && !empty($request['time'])) {
            $where['a.time'] = array('elt', strtotime($request['time']));
        } else if (!empty($request['last_time']) && !empty($request['time'])) {
            $where['a.last_time'] = array('egt', strtotime($request['last_time']));
            $where['a.time'] = array('elt', strtotime($request['time']));
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
            $list[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
            if ($value['bill_type'] == BILL_LEASE) {
                $list[$key]['type'] = '房租';
            } elseif ($value['bill_type'] == BILL_WATER) {
                $list[$key]['type'] = '水费';
            } elseif ($value['bill_type'] == BILL_POWER) {
                $list[$key]['type'] = '电费';
            }
            if ($value['pay_status'] == 1) {
                $list[$key]['status'] = '已支付';
                $list[$key]['pay_time'] = date('Y-m-d', $value['pay_time']);
            } else {
                $list[$key]['status'] = '未支付';
            }
            if ($value['pay_time'] == 0) {
                $list[$key]['pay_time'] = '--';
            } else {
                $list[$key]['pay_time'] = date('Y-m-d', $value['pay_time']);
            }
            if ($value['is_exit'] == IS_EXIT) {
                $list[$key]['is_exit'] = '已退租';
            } else if ($value['expire_time'] < time()) {
                $list[$key]['is_exit'] = '已到期';
            } else if ($value['expire_time'] >= time()) {
                $list[$key]['is_exit'] = '生效中';
            }
            $list[$key]['roomInfo'] = $value['building_name'] . $value['room_sn'] . '室';
            $list[$key]['bill_cycle'] = date('Y-m-d', $value['last_time']) . '-' . date('Y-m-d', $value['time']);
        }
        return ['list' => $list, 'count' => $count];
    }

    /**
     * 生成电费账单
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-02 20:03:57
     * Update: 2021-03-02 20:03:57
     * Version: 1.00
     */
    public function createBillByPower($request = [])
    {
        $request['total'] = ($request['p_current'] - $request['plast_current']) * $request['p_price'];
        $request['bill_type'] = BILL_POWER;
        $request['last_time'] = $request['plast_time'];
        $request['time'] = $request['p_time'];
        $request['create_time'] = time();
        $this->startTrans();
        $result = $this->add($request);
        if ($result) {
            $this->commit();
            return true;
        } else {
            $this->rollback();
            return false;
        }
    }

    /**
     * 生成每月房租账单
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-03 18:40:42
     * Update: 2021-03-03 18:40:42
     * Version: 1.00
     */
    public function createBillLease($request = [])
    {
        $n = 0;
        foreach ($request as $key => $value) {
            $data = [];
            $data['lease_id'] = $value['lease_id'];
            $data['last_time'] = $value['last_time'];
            $data['bill_remark'] = $value['bill_remark'];
            $data['bill_type'] = BILL_LEASE;
            $data['total'] = $value['rent'];
            $data['room_id'] = $value['room_id'];
            $data['customer_id'] = $value['customer_id'];
            $data['manager_id'] = $value['manager_id'];
            $data['create_time'] = time();
            $time = date('Y-m-d', $value['last_time']);
            $data['time'] = strtotime("$time +1 month");
            $where = array();
            $where['lease_id'] = $value['lease_id'];
            $where['is_delete'] = NOT_DELETED;
            $where['bill_remark'] = $value['bill_remark'];
            $result = $this->where($where)->find();
            if (!empty($result)) {
                continue;
            } else {
                $this->startTrans();
                $result1 = $this->add($data);
                if ($result1) {
                    $n = $n + 1;
                    $this->commit();
                } else {
                    $this->rollback();
                }
            }
        }
        return $n;
    }

    /**
     * 删除当前id的账单信息
     * @param int $bill_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-03 19:11:19
     * Update: 2021-03-03 19:11:19
     * Version: 1.00
     */
    public function deleteBillById($bill_id = 0)
    {
        $where = array();
        $where['bill_id'] = $bill_id;
        $this->startTrans();
        $result = $this->where($where)->save(['is_delete' => DELETED]);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '当前账单删除失败，请稍后再试！！！！');
        } else {
            $this->commit();
            return getReturn(CODE_SUCCESS, '当前账单删除成功！！！');
        }
    }

    /**
     * 批量删除账单
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-03 22:22:34
     * Update: 2021-03-03 22:22:34
     * Version: 1.00
     */
    public function delAllByBillId($request = [])
    {
        $msg = '';
        foreach ($request as $key => $value) {
            $where = array();
            $where['bill_id'] = $value;
            $this->startTrans();
            $result = $this->where($where)->save(['is_delete' => DELETED]);
            if ($result === false) {
                $msg = $msg . $value . ',';
                $this->rollback();
            } else {
                $this->commit();

            }
        }
        if ($msg != '') {
            return getReturn(CODE_ERROR, '有部分账单删除失败，分别是：' . $msg . '请稍后再试！！');
        } else {
            return getReturn(CODE_SUCCESS, '所选账单都删除成功！！！');
        }
    }

    /**
     * 获取租户账单
     * @param int $customer_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * User: hjun
     * Date: 2021-03-06 17:29:45
     * Update: 2021-03-06 17:29:45
     * Version: 1.00
     */
    public function getBill($customer_id = 0)
    {

        $where = array();
        $where['is_delete'] = NOT_DELETED;
        $where['customer_id'] = $customer_id;
//        $page = $request['page'];
//        $limit = $request['limit'];
        $options = [];
        $options['where'] = $where;
        $count = $this->getCount($options);
        $options['limit'] = 20;
        $options['page'] = 1;
        $order = 'create_time asc';
        $list = $this->where($where)->order($order)->select();
//        return ['list' => $list, 'count' => $count];
        foreach ($list as $key => $value) {
            if ($value['bill_type'] == BILL_LEASE) {
                $list[$key]['type'] = '房租';
            } elseif ($value['bill_type'] == BILL_WATER) {
                $list[$key]['type'] = '水费';
            } elseif ($value['bill_type'] == BILL_POWER) {
                $list[$key]['type'] = '电费';
            }
            $list[$key]['last_time'] = date('Y-m-d', $value['last_time']);
            $list[$key]['time'] = date('Y-m-d', $value['time']);
            $list[$key]['cycle'] = $list[$key]['last_time'].'-'.$list[$key]['time'];
            if ($value['pay_time'] > 0){
                $list[$key]['pay_time'] = date('Y-m-d H:i:s', $value['pay_time']);
            }
        }
        return $list;
    }
}