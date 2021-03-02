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
        $field = ['a.*', 'b.customer_name', 'b.customer_mobile', 'c.room_sn', 'd.garden_name', 'e.building_name', 'u.manager_name'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
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
}