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
        $this->startTrans();
        $result = $this->where($where)->save(['is_delete' => DELETED]);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '系统繁忙，请稍后重试!!!');
        } else {
            $data = $this->where($where)->find();
            $where2 = array();
            $where2['building_id'] = $data['building_id'];
            M('building')->startTrans();
            $result2 = M('building')->where($where2)->save(['is_user' => 0]);
            if ($result2 === false) {
                M('building')->rollback();
                $this->rollback();
                return getReturn(CODE_ERROR, '系统繁忙，请稍后再试!!!');
            } else {
                M('building')->commit();
                $this->commit();
                return getReturn(CODE_SUCCESS, '删除成功!!!');
            }
        }
    }

    /**
     * 添加楼宇管理员
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 13:20:22
     * Update: 2021-01-29 13:20:22
     * Version: 1.00
     */
    public function addUserInfo($request = [])
    {
        $request['create_time'] = time();
        $request['password'] = md5('123456');
        $this->startTrans();
        $result = $this->add($request);
        if ($result) {
            $where = array();
            $where['building_id'] = $request['building_id'];
            $result2 = M('building')->where($where)->field('is_user')->find();
            if ($result2['is_user'] == 1) {
                $this->rollback();
                return getReturn(CODE_ERROR, '该楼宇已存在楼宇管理员，不可重复添加！！！');
            } else {
                $this->commit();
                $result3 = M('building')->where($where)->save(['is_user' => 1]);
                return getReturn(CODE_SUCCESS, '添加成功！！！');
            }
        } else {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        }
    }

    /**
     * 验证楼宇管理员登录用户名不重复
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 13:55:50
     * Update: 2021-01-29 13:55:50
     * Version: 1.00
     */
    public function checkName($request = [])
    {
        $where = array();
        $where['name'] = $request['name'];
        $where['is_delete'] = NOT_DELETED;
        $result = $this->where($where)->find();
        if ($result) {
            return getReturn(CODE_ERROR, '楼宇管理员登录名重复，请重新输入！！！', $result);
        } else {
            return getReturn(CODE_SUCCESS, '没有重复');
        }
    }

    /**
     * 根据楼宇管理员id获取管理员信息
     * @param int $manager_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 15:36:33
     * Update: 2021-01-29 15:36:33
     * Version: 1.00
     */
    public function getUserById($manager_id = 0)
    {
        $where = array();
        $where['manager_id'] = $manager_id;
        $options = [];
        $options['where'] = $where;
        $data = $this->queryRow($options);
        return getReturn(CODE_SUCCESS, '查询成功', $data);
    }

    /**
     * 编辑楼宇管理员信息
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 16:02:17
     * Update: 2021-01-29 16:02:17
     * Version: 1.00
     */
    public function editUserInfo($request = [])
    {
        $where = array();
        $where['manager_id'] = $request['manager_id'];
        $result = $this->where($where)->save($request);
        if ($result === false) {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            return getReturn(CODE_SUCCESS, '编辑成功！！');
        }
    }

    /**
     * 密码初始化
     * @param int $manager_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 16:14:28
     * Update: 2021-01-29 16:14:28
     * Version: 1.00
     */
    public function resetUserById($manager_id = 0)
    {
        $where = array();
        $where['manager_id'] = $manager_id;
        $result = $this->where($where)->save(['password' => md5('123456')]);
        if ($result === false) {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            return getReturn(CODE_SUCCESS, '密码初始化完成！！');
        }
    }
}