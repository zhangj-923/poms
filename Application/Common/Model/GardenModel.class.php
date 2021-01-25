<?php

namespace Common\Model;

class GardenModel extends BaseModel
{

    /**
     * 获取园区列表信息
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:04:03
     * Update: 2021-01-17 15:04:03
     * Version: 1.00
     */
    public function getGardenInfo($request = [])
    {
        $where = array();
        $where['is_delete'] = NOT_DELETED;
        if (!empty($request['key'])) {
            $where['garden_name'] = ['like', '%' . $request['key'] . '%'];
        }
        $page = $request['page'];
        $limit = $request['limit'];
        $options = [];
        $options['where'] = $where;
        $count = $this->getCount($options);
        $options['limit'] = $limit;
        $options['page'] = $page;
        $options['order'] = 'garden_id desc';
        $list = $this->queryList($options);
        foreach ($list as $key => $value) {
//            if ($value['garden_status'] == 1) {
//                $list[$key]['garden_status'] = '正常';
//            } else {
//                $list[$key]['garden_status'] = '关闭';
//            }
            $list[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
        }
        return ['list' => $list, 'count' => $count];
    }

    /**
     * 删除园区
     * @param int $garden_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:33:48
     * Update: 2021-01-17 15:33:48
     * Version: 1.00
     */
    public function deleteGardenById($garden_id = 0)
    {
        $where = array();
        $where['garden_id'] = $garden_id;
        $result = $this->where($where)->save(['is_delete' => DELETED]);
        if ($result === false) {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后重试!!!');
        } else {
            return getReturn(CODE_SUCCESS, '删除成功!!!');
        }
    }

    /**
     * 添加园区
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:45:20
     * Update: 2021-01-17 15:45:20
     * Version: 1.00
     */
    public function addGardenInfo($request = [])
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
     * @param int $garden_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 15:55:11
     * Update: 2021-01-17 15:55:11
     * Version: 1.00
     */
    public function getGardenById($garden_id = 0)
    {
        $where = array();
        $where['garden_id'] = $garden_id;
        $options = [];
        $options['where'] = $where;
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
    public function editGardenInfo($request = [])
    {
        $where = array();
        $where['garden_id'] = $request['garden_id'];
        $result = $this->where($where)->save($request);
        if ($result === false) {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            return getReturn(CODE_SUCCESS, '编辑成功！！');
        }
    }

    /**
     * 监听园区状态
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-24 20:28:54
     * Update: 2021-01-24 20:28:54
     * Version: 1.00
     */
    public function changeStatusByGardenId($request = [])
    {
        $where = array();
        $where['garden_id'] = $request['garden_id'];
        $data = [];
        $data['garden_status'] = $request['garden_status'];
        $result = $this->where($where)->save($data);
        if ($result === false) {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            if ($data['garden_status'] == 1) {
                return getReturn(CODE_SUCCESS, '开启园区成功！！');
            } else {
                return getReturn(CODE_SUCCESS, '关闭园区成功！！');
            }
        }
    }
}