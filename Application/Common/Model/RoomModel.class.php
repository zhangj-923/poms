<?php

namespace Common\Model;

class RoomModel extends BaseModel
{

    /**
     * 删除房屋
     * @param int $room_id
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-02-26 14:34:36
     * Update: 2021-02-26 14:34:36
     * Version: 1.00
     */
    public function deleteRoomById($room_id = 0)
    {
        $where = array();
        $where['room_id'] = $room_id;
        $status = $this->where($where)->find()['room_status'];
        if ($status == '1') {
            $this->startTrans();
            $result1 = $this->where($where)->save(['is_delete' => DELETED]);
            if ($result1 === false) {
                $this->rollback();
                return getReturn(CODE_ERROR, '解除房屋失败！！请稍后重试', $result1);
            } else {
                $result2 = M('lease')->where($where)->save(['is_delete' => DELETED]);
                $result3 = M('water')->where($where)->save(['is_delete' => DELETED]);
                $result4 = M('power')->where($where)->save(['is_delete' => DELETED]);
                if ($result2 === false || $result3 === false || $result4 === false) {
                    $this->rollback();
                    return getReturn(CODE_ERROR, '解除房屋失败！！请检查水电表关系或租赁关系', $result1);
                } else {
                    $this->commit();
                    return getReturn(CODE_SUCCESS, '房屋删除成功，并解除租赁关系和水电表！！！');
                }
            }
        } else {
            $this->startTrans();
            $result = $this->where($where)->save(['is_delete' => DELETED]);
            if ($result === false) {
                $this->rollback();
                return getReturn(CODE_ERROR, '房屋删除失败！！请稍后重试');
            } else {
                $this->commit();
                return getReturn(CODE_SUCCESS, '房屋删除成功!!');
            }
        }
    }

}