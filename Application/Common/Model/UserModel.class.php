<?php

namespace Common\Model;

class UserModel extends BaseModel
{
    /**
     * 获取楼宇管理员信息列表
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-25 20:33:52
     * Update: 2021-01-25 20:33:52
     * Version: 1.00
     */
    public function getUserInfo($request = [])
    {
        $field = ['a.*', 'garden_name', 'building_name'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
        if (!empty($request['key1'])) {
            $where['a.garden_id'] = $request['key1'];
        }
        if (!empty($request['key2'])) {
            $where['a.building_id'] = $request['key2'];
        }
        if (!empty($request['key3'])) {
            $where['a.manager_name'] = ['like', '%' . $request['key3'] . '%'];
        }
        $page = $request['page'];
        $limit = $request['limit'];
        $join = [
            'join __GARDEN__ b on a.garden_id = b.garden_id',
            'join __BUILDING__ c on a.building_id = c.building_id'
        ];
        $options = [];
        $options['where'] = $where;
        $options['alias'] = 'a';
        $count = $this->getCount($options);
        $options['field'] = $field;
        $options['limit'] = $limit;
        $options['page'] = $page;
        $options['join'] = $join;
        $options['order'] = 'a.garden_id desc';
        $list = $this->queryList($options);
        foreach ($list as $key => $value) {
            $list[$key]['create_time'] = date('Y-m-d H:i:s', $value['create_time']);
        }
        return ['list' => $list, 'count' => $count];
    }


    /**
     * 根据楼宇管理员id删除
     * @param int $manager_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-25 22:34:38
     * Update: 2021-01-25 22:34:38
     * Version: 1.00
     */
    public function deleteUserById($manager_id = 0)
    {
        $where = array();
        $where['manager_id'] = $manager_id;
        $result = $this->where($where)->save(['is_delete' => DELETED]);
        if ($result === false) {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后重试!!!');
        } else {
            return getReturn(CODE_SUCCESS, '删除成功!!!');
        }
    }
}