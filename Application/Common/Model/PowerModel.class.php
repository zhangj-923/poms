<?php

namespace Common\Model;

class PowerModel extends BaseModel
{
    /**
     * 验证该房屋是否已经添加电表
     * @param int $room_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-25 15:47:30
     * Update: 2021-02-25 15:47:30
     * Version: 1.00
     */
    public function checkPower($room_id = 0)
    {
        $where = array();
        $where['room_id'] = $room_id;
        $where['is_delete'] = NOT_DELETED;
        $result = $this->where($where)->select();
        if (empty($result)) {
            return getReturn(CODE_SUCCESS, '可添加电表！！');
        } else {
            return getReturn(CODE_ERROR, '该房屋已存在电表，不可添加多个电表！！！');
        }
    }

    /**
     * 添加电表
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-25 15:51:24
     * Update: 2021-02-25 15:51:24
     * Version: 1.00
     */
    public function addPower($request = [])
    {
        $request['p_time'] = strtotime($request['p_time']);
        $request['manager_id'] = session('USER.manager_id');
        $request['create_time'] = time();
        $this->startTrans();
        $result = $this->add($request);
        if ($result) {
            $this->commit();
            return getReturn(CODE_SUCCESS, '该房屋电表添加成功！！！');
        } else {
            $this->rollback();
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        }
    }

    /**
     * 获取电表信息
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 15:40:48
     * Update: 2021-02-24 15:40:48
     * Version: 1.00
     */
    public function getPowerInfo($request = [])
    {
        $field = ['a.*', 'b.room_sn'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
        $page = $request['page'];
        $limit = $request['limit'];
        $join = [
            'join __ROOM__ b on a.room_id = b.room_id'
        ];
        $options = [];
        $options['alias'] = 'a';
//        $options['where'] = $where;

        if (!empty($request['key1'])) {
            $where['b.room_sn'] = ['like', '%' . $request['key1'] . '%'];
        }
//        if (!empty($request['key2'])) {
//            $where['lease_team'] = $request['key2'];
//        }
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
            $list[$key]['p_time'] = date('Y-m-d', $value['p_time']);
            if ($value['plast_time'] != 0) {
                $list[$key]['plast_time'] = date('Y-m-d', $value['plast_time']);
            } else {
                $list[$key]['plast_time'] = '--';
            }
            if ($value['plast_current'] == 0) {
                $list[$key]['plast_current'] = '--';
            }

        }
        return ['list' => $list, 'count' => $count];
    }

    /**
     * 解除电表
     * @param int $power_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-25 16:01:33
     * Update: 2021-02-25 16:01:33
     * Version: 1.00
     */
    public function deletePowerById($power_id = 0)
    {
        $where = array();
        $where['power_id'] = $power_id;
        $this->startTrans();
        $result = $this->where($where)->save(['is_delete' => DELETED]);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '电表删除失败！！！请稍后重试');
        } else {
            $this->commit();
            return getReturn(CODE_SUCCESS, '当前电表删除成功！！');
        }
    }

    /**
     * 获取该电表id的信息
     * @param int $power_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 16:11:17
     * Update: 2021-02-24 16:11:17
     * Version: 1.00
     */
    public function getPowerById($power_id = 0)
    {
        $field = ['a.*', 'b.room_sn'];
        $where = array();
        $where['a.power_id'] = $power_id;
        $join = [
            'join __ROOM__ b on a.room_id = b.room_id'
        ];
        $options = [];
        $options['alias'] = 'a';
        $options['where'] = $where;
        $options['field'] = $field;
        $options['join'] = $join;
        $data = $this->queryRow($options);
        $data['p_time'] = date('Y-m-d', $data['p_time']);
        return getReturn(CODE_SUCCESS, '查询成功', $data);
    }

    /**
     * 保存修改后的内容
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 16:27:36
     * Update: 2021-02-24 16:27:36
     * Version: 1.00
     */
    public function powerEdit($request = [])
    {
        $where = array();
        $where['power_id'] = $request['power_id'];
        $request['p_time'] = strtotime($request['p_time']);
        $this->startTrans();
        $result = $this->where($where)->save($request);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            $this->commit();
            return getReturn(CODE_SUCCESS, '当前电表编辑修改成功！！');
        }
    }

    /**
     * 电表抄表 并生成账单
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-02 20:00:16
     * Update: 2021-03-02 20:00:16
     * Version: 1.00
     */
    public function readPower($request = [])
    {
        $where = array();
        $where['power_id'] = $request['power_id'];
        $request['p_time'] = strtotime($request['p_time']);
        $request['plast_time'] = strtotime($request['plast_time']);
        $this->startTrans();
        $result = $this->where($where)->save($request);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            $field = ['a.p_current', 'a.plast_current', 'a.p_price', 'a.plast_time', 'a.p_time', 'a.manager_id', 'a.room_id', 'b.lease_id', 'b.customer_id'];
            $where = array();
            $where['a.is_delete'] = NOT_DELETED;
            $where['a.power_id'] = $request['power_id'];
            $join = [
                'join __LEASE__ b on a.room_id = b.room_id'
            ];
            $options = [];
            $options['alias'] = 'a';
            $options['where'] = $where;
            $options['where'] = $where;
            $options['field'] = $field;
            $options['join'] = $join;
            $list = $this->queryRow($options);
            $list['bill_remark'] = $request['remark'];
            $result1 = D('Bill')->createBillByPower($list);
            if ($result1 === false) {
                $this->rollback();
                return getReturn(CODE_ERROR, '电表抄表时生成账单失败，请稍后重试！！！！');
            } else {
                $this->commit();
                return getReturn(CODE_SUCCESS, '电表抄表成功！！并生成账单');
            }
        }
    }
}