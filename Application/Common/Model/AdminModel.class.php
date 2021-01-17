<?php

namespace Common\Model;

class AdminModel extends BaseModel
{
    /**
     * 获取超级管理员信息
     * @param int $id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 13:15:41
     * Update: 2021-01-17 13:15:41
     * Version: 1.00
     */
    public function getSuperInfo($id = 0)
    {
        $where = [];
        $where['id'] = $id;
        $field = ['id', 'realname', 'tel'];
        $options = [];
        $options['where'] = $where;
        $options['field'] = $field;
        $data = $this->queryRow($options);
        return getReturn(CODE_SUCCESS, '查询成功', $data);
    }

    /**
     * 编辑超级管理员个人信息
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 14:20:30
     * Update: 2021-01-17 14:20:30
     * Version: 1.00
     */
    public function editSuperInfo($request = [])
    {
        $where = [];
        $where['id'] = $request['id'];
        $result = $this->where($where)->save($request);
        if ($result === false) {
            return getReturn(CODE_ERROR, '系统繁忙，请稍后再试！！！');
        } else {
            $adminInfo = $this->where($where)->find();
            session('ADMIN', $adminInfo);
            return getReturn(CODE_SUCCESS, '编辑成功！！');
        }
    }


}