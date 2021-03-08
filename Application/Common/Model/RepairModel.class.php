<?php

namespace Common\Model;

class RepairModel extends BaseModel
{
    /**
     * 添加报修
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 18:49:34
     * Update: 2021-03-07 18:49:34
     * Version: 1.00
     */
    public function addRepair($request = [])
    {
        $request['repair_time'] = strtotime($request['repair_time']);
        $request['create_time'] = time();
        $request['customer_id'] = session('CUSTOMER.customer_id');
        $request['manager_id'] = session('CUSTOMER.manager_id');
        $this->startTrans();
        $result = $this->add($request);
        if ($result) {
            $this->commit();
            return getReturn(CODE_SUCCESS, '该设备报修成功，请等候管理员处理！！！');
        } else {
            $this->rollback();
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        }
    }

    /**
     * 获取设备报修详情
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 18:57:02
     * Update: 2021-03-07 18:57:02
     * Version: 1.00
     */
    public function getRepairInfo()
    {
        $field = ['a.*', 'b.deal_content', 'b.deal_id'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
        $where['a.customer_id'] = session('CUSTOMER.customer_id');
        $join = [
            'left join __DEAL__ b on a.repair_id = b.repair_id'
        ];
        $options = [];
        $options['alias'] = 'a';
        $options['where'] = $where;
        $options['field'] = $field;
        $options['join'] = $join;
        $options['limit'] = 20;
        $options['page'] = 1;
        $options['order'] = 'a.create_time asc';
        $list = $this->queryList($options);
        foreach ($list as $key => $value) {
            $list[$key]['repair_time'] = date('Y-m-d', $value['repair_time']);
        }
        return $list;
    }

    /**
     * 删除该id的报修信息
     * @param int $repair_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 19:21:20
     * Update: 2021-03-07 19:21:20
     * Version: 1.00
     */
    public function deleteRepair($repair_id = 0)
    {
        $where = array();
        $where['repair_id'] = $repair_id;
        $this->startTrans();
        $result = $this->where($where)->save(['is_delete' => DELETED]);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '删除该条报修信息失败，请稍后重试！！！！');
        } else {
            $this->commit();
            return getReturn(CODE_SUCCESS, '该报修信息删除成功！！！');
        }
    }


    /**
     * 后台管理获取报修信息
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 22:54:56
     * Update: 2021-03-07 22:54:56
     * Version: 1.00
     */
    public function getRepairList($request = [])
    {
        $field = ['a.*', 'b.customer_name', 'b.customer_mobile', 'c.deal_content', 'e.room_sn', 'g.garden_name', 'h.building_name'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
        $where['a.manager_id'] = session('USER.manager_id');
        $where['d.expire_time'] = array('egt', time());
        $where['e.room_status'] = 1;
        $page = $request['page'];
        $limit = $request['limit'];
        $join = [
            'join __CUSTOMER__ b on a.customer_id = b.customer_id',
            'left join __DEAL__ c on a.repair_id = c.repair_id',
            'join __LEASE__ d on b.customer_id = d.customer_id',
            'join __ROOM__ e on d.room_id = e.room_id',
            'join __USER__ f on a.manager_id = f.manager_id',
            'join __GARDEN__ g on f.garden_id = g.garden_id',
            'join __BUILDING__ h on f.building_id = h.building_id'
        ];
        $options = [];
        $options['alias'] = 'a';
        if (!empty($request['key1'])) {
            $where['e.room_sn|b.customer_name'] = ['like', '%' . $request['key1'] . '%'];
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
            if ($value['status'] == 0) {
                $list[$key]['status'] = '未处理';
                $list[$key]['deal_content'] = '--';
            } else {
                $list[$key]['status'] = '已处理';
            }
            $list[$key]['roomInfo'] = $value['garden_name'] . $value['building_name'] . $value['room_sn'] . '室';
            $list[$key]['repair_time'] = date('Y-m-d', $value['repair_time']);
            $list[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
        }
        return ['list' => $list, 'count' => $count];
    }

    /**
     * 获取该id的报修信息
     * @param $repair_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 23:22:57
     * Update: 2021-03-07 23:22:57
     * Version: 1.00
     */
    public function getRepairById($repair_id){
        $where = array();
        $where['repair_id'] = $repair_id;
        $where['is_delete'] = NOT_DELETED;
        $data = $this->where($where)->find();
        $data['repair_time'] = date('Y-m-d', $data['repair_time']);
        return getReturn(CODE_SUCCESS, '查询成功', $data);
    }
}