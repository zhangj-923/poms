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
        $where['a.manager_id'] = session('USER.manager_id');
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
        $list = $this->queryRow($options);
        $roomInfo = $list['garden_name'].$list['building_name'].$list['room_sn'].'室';
        return $roomInfo;
    }
}