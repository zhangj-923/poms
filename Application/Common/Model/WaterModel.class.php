<?php

namespace Common\Model;

class WaterModel extends BaseModel
{
    /**
     * 验证该房屋是否已经添加水表
     * @param int $room_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 13:22:06
     * Update: 2021-02-24 13:22:06
     * Version: 1.00
     */
    public function checkWater($room_id = 0)
    {
        $where = array();
        $where['room_id'] = $room_id;
        $where['is_delete'] = NOT_DELETED;
        $result = $this->where($where)->select();
        if (empty($result)) {
            return getReturn(CODE_SUCCESS, '可添加水表！！');
        } else {
            return getReturn(CODE_ERROR, '该房屋已存在水表，不可添加多个水表！！！');
        }
    }

    /**
     * 添加水表
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 14:11:58
     * Update: 2021-02-24 14:11:58
     * Version: 1.00
     */
    public function addWater($request = [])
    {
        $request['time'] = strtotime($request['time']);
        $request['manager_id'] = session('USER.manager_id');
        $request['create_time'] = time();
        $this->startTrans();
        $result = $this->add($request);
        if ($result) {
            $this->commit();
            return getReturn(CODE_SUCCESS, '该房屋水表添加成功！！！');
        } else {
            $this->rollback();
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        }
    }

    /**
     * 获取水表信息
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 15:40:48
     * Update: 2021-02-24 15:40:48
     * Version: 1.00
     */
    public function getWaterInfo($request = [])
    {
        $field = ['a.*', 'b.room_sn'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
        $where['a.manager_id'] = session('USER.manager_id');
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
            $list[$key]['time'] = date('Y-m-d', $value['time']);
            if ($value['last_time'] != 0) {
                $list[$key]['last_time'] = date('Y-m-d', $value['last_time']);
            } else {
                $list[$key]['last_time'] = '--';
            }
            if ($value['last_current'] == 0) {
                $list[$key]['last_current'] = '--';
            }
        }
        return ['list' => $list, 'count' => $count];
    }

    /**
     * 删除水表
     * @param int $water_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 15:56:57
     * Update: 2021-02-24 15:56:57
     * Version: 1.00
     */
    public function deleteWaterById($water_id = 0)
    {
        $where = array();
        $where['water_id'] = $water_id;
        $this->startTrans();
        $result = $this->where($where)->save(['is_delete' => DELETED]);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '水表删除失败！！！请稍后重试');
        } else {
            $this->commit();
            return getReturn(CODE_SUCCESS, '当前水表删除成功！！');
        }
    }

    /**
     * 获取该水表id的信息
     * @param int $water_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-24 16:11:17
     * Update: 2021-02-24 16:11:17
     * Version: 1.00
     */
    public function getWaterById($water_id = 0)
    {
        $field = ['a.*', 'b.room_sn'];
        $where = array();
        $where['a.water_id'] = $water_id;
        $join = [
            'join __ROOM__ b on a.room_id = b.room_id'
        ];
        $options = [];
        $options['alias'] = 'a';
        $options['where'] = $where;
        $options['field'] = $field;
        $options['join'] = $join;
        $data = $this->queryRow($options);
        $data['time'] = date('Y-m-d', $data['time']);
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
    public function waterEdit($request = [])
    {
        $where = array();
        $where['water_id'] = $request['water_id'];
        $request['time'] = strtotime($request['time']);
        $this->startTrans();
        $result = $this->where($where)->save($request);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            $this->commit();
            return getReturn(CODE_SUCCESS, '当前水表编辑修改成功！！');
        }
    }

    /**
     * 水表抄表 并生成账单
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-01 16:44:07
     * Update: 2021-03-01 16:44:07
     * Version: 1.00
     */
    public function readWater($request = [])
    {
        $where = array();
        $where['water_id'] = $request['water_id'];
        $request['time'] = strtotime($request['time']);
        $request['last_time'] = strtotime($request['last_time']);
        $this->startTrans();
        $result = $this->where($where)->save($request);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            $field = ['a.current', 'a.last_current', 'a.price', 'a.last_time', 'a.time', 'a.manager_id', 'a.room_id', 'b.lease_id', 'b.customer_id'];
            $where = array();
            $where['a.is_delete'] = NOT_DELETED;
            $where['b.is_delete'] = NOT_DELETED;
            $where['b.is_exit'] = NOT_EXIT;
            $where['a.water_id'] = $request['water_id'];
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
            if (!empty($list)) {
                $list['bill_remark'] = $request['remark'];
                $result1 = D('Bill')->createBillByWater($list);
                if ($result1 === false) {
                    $this->rollback();
                    return getReturn(CODE_ERROR, '水表抄表时生成账单失败，请稍后重试！！！！');
                } else {
                    $this->commit();
                    return getReturn(CODE_SUCCESS, '水表抄表成功！！并生成账单');
                }
            } else {
                $this->rollback();
                return getReturn(CODE_ERROR, '查询不到该房屋的租赁状态，所以抄表失败，请查询租赁状态后在进行抄表！！！');
            }
        }
    }

}