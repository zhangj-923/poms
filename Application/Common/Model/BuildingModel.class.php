<?php

namespace Common\Model;

class BuildingModel extends BaseModel
{

    /**
     * 获取楼宇列表信息
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:04:03
     * Update: 2021-01-17 15:04:03
     * Version: 1.00
     */
    public function getBuildingInfo($request = [])
    {
        $field = ['a.*', 'garden_name'];
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
            'join __GARDEN__ b on a.garden_id = b.garden_id'
        ];
        $options = [];
        $options['alias'] = 'a';
        $options['where'] = $where;
        $count = $this->getCount($options);
        $options['field'] = $field;
        $options['join'] = $join;
        $options['limit'] = $limit;
        $options['page'] = $page;
        $options['order'] = 'a.garden_id asc';
        $list = $this->queryList($options);
        foreach ($list as $key => $value) {
            $list[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
        }
        return ['list' => $list, 'count' => $count];
    }

    /**
     * 删除园区
     * @param int $building_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:33:48
     * Update: 2021-01-17 15:33:48
     * Version: 1.00
     */
    public function deleteBuildingById($building_id = 0)
    {
        $where = array();
        $where['building_id'] = $building_id;
        $result = $this->where($where)->save(['is_delete' => DELETED]);
        if ($result === false) {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后重试!!!');
        } else {
            return getReturn(CODE_SUCCESS, '删除成功!!!');
        }
    }

    /**
     * 添加楼宇
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:45:20
     * Update: 2021-01-17 15:45:20
     * Version: 1.00
     */
    public function addBuildingInfo($request = [])
    {
        $request['create_time'] = time();
        $result = $this->add($request);
        if ($result) {
            return getReturn(CODE_SUCCESS, '添加成功！！！');
        } else {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        }
    }

    /**
     * 根据园区id获取园区信息
     * @param int $building_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:55:11
     * Update: 2021-01-17 15:55:11
     * Version: 1.00
     */
    public function getBuildingById($building_id = 0)
    {
        $field = ['building_id', 'building_name', 'garden_name', 'a.garden_id'];
        $where = array();
        $where['building_id'] = $building_id;
        $join = [
            'join __GARDEN__ b on a.garden_id = b.garden_id'
        ];
        $options = [];
        $options['alias'] = 'a';
        $options['field'] = $field;
        $options['where'] = $where;
        $options['join'] = $join;
        $data = $this->queryRow($options);
        return getReturn(CODE_SUCCESS, '查询成功', $data);
    }

    /**
     * 编辑园区信息
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 16:03:43
     * Update: 2021-01-17 16:03:43
     * Version: 1.00
     */
    public function editBuildingInfo($request = [])
    {
        $where = array();
        $where['building_id'] = $request['building_id'];
        $result = $this->where($where)->save($request);
        if ($result === false) {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            return getReturn(CODE_SUCCESS, '编辑成功！！');
        }
    }

}