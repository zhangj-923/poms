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
        $field = ['a.*', 'b.customer_name', 'b.customer_mobile', 'b.customer_id', 'c.room_sn', 'c.room_id'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
        if (!empty($request['key1'])) {
            $where['a.garden_id'] = $request['key1'];
        }
        if (!empty($request['key2'])) {
            $where['a.building_name'] = ['like', '%' . $request['key2'] . '%'];
        }
        $page = $request['page'];
        $limit = $request['limit'];
        $join = [
            'join __CUSTOMER__ b on a.customer_id = b.customer_id',
            'join __ROOM__ c on a.room_id = c.room_id'
        ];
        $options = [];
        $options['alias'] = 'a';
        $options['where'] = $where;
        $count = $this->getCount($options);
        $options['field'] = $field;
        $options['join'] = $join;
        $options['limit'] = $limit;
        $options['page'] = $page;
        $options['order'] = 'a.create_time asc';
        $list = $this->queryList($options);
        foreach ($list as $key => $value) {
            $list[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
        }
        return ['list' => $list, 'count' => $count];
    }

}