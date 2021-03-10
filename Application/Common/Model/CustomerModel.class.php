<?php

namespace Common\Model;

class CustomerModel extends BaseModel
{
    /**
     * 获取租户房屋信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-06 16:52:31
     * Update: 2021-03-06 16:52:31
     * Version: 1.00
     */
    public function getRoomInfo()
    {
        $field = ['a.customer_name', 'e.garden_name', 'f.building_name', 'c.room_sn'];
        $where = array();
        $where['a.is_delete'] = NOT_DELETED;
        $where['a.manager_id'] = session('CUSTOMER.manager_id');
        $where['a.customer_id'] = session('CUSTOMER.customer_id');
        $where['b.expire_time'] = array('egt', time());
        $join = [
            'join __LEASE__ b on a.customer_id = b.customer_id',
            'join __ROOM__ c on b.room_id = c.room_id',
            'join __USER__ d on a.manager_id = d.manager_id',
            'join __GARDEN__ e on d.garden_id = e.garden_id',
            'join __BUILDING__ f on d.building_id = f.building_id'
        ];
        $options = [];
        $options['alias'] = 'a';
        $options['where'] = $where;
        $options['field'] = $field;
        $options['join'] = $join;
        $options['limit'] = 20;
        $options['page'] = 1;
        $list = $this->alias('a')->where($where)->join($join)->field($field)->select();
        return $list;
    }

    /**
     * 获取租户个人信息
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 15:46:04
     * Update: 2021-03-07 15:46:04
     * Version: 1.00
     */
    public function getCus()
    {
        $where = array();
        $where['customer_id'] = session('CUSTOMER.customer_id');
        $list = $this->where($where)->find();
        return getReturn(CODE_SUCCESS, '查询成功', $list);
    }

    /**
     * 验证租户手机号不重复
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-29 13:55:50
     * Update: 2021-01-29 13:55:50
     * Version: 1.00
     */
    public function checkMobileByID($request = [])
    {
        $where = array();
        $where['customer_mobile'] = $request['name'];
        $where['customer_id'] = array('neq', $request['customer_id']);
        $where['is_delete'] = NOT_DELETED;
        $result = $this->where($where)->find();
        if ($result) {
            return getReturn(CODE_ERROR, '楼宇管理员登录名重复，请重新输入！！！', $result);
        } else {
            return getReturn(CODE_SUCCESS, '没有重复');
        }
    }

    /**
     * 编辑租户个人信息
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 15:51:32
     * Update: 2021-03-07 15:51:32
     * Version: 1.00
     */
    public function editCustomer($request = [])
    {

        $where = array();
        $where['customer_id'] = session('CUSTOMER.customer_id');
        $data = $_POST;
        if (strcmp($_POST['password'], session('CUSTOMER.password')) == 0) {
            $data['password'] = $_POST['password'];
        } else {
            $data['password'] = md5($_POST['password']);
        }
        $this->startTrans();
        $result = $this->where($where)->save($data);
        if ($result === false) {
            $this->rollback();
            return getReturn(CODE_ERROR, '修改个人信息失败，请稍后再试！！！');
        } else {
            $this->commit();
            $userInfo = $this->where($where)->find();
            session('CUSTOMER', $userInfo);
            return getReturn(CODE_SUCCESS, '修改个人信息成功!!');
        }
    }
}