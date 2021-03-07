<?php

namespace Common\Model;

class DealModel extends BaseModel
{
    /**
     * 处理报修
     * @param array $request
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-03-07 23:32:54
     * Update: 2021-03-07 23:32:54
     * Version: 1.00
     */
    public function dealRepair($request = [])
    {
        $where = array();
        $where['repair_id'] = $request['repair_id'];
        $data = [];
        $data['deal_content'] = $request['deal_content'];
        $data['manager_id'] = session('USER.manager_id');
        $data['create_time'] = time();
        $list = $this->where($where)->find();
        $this->startTrans();
        if (!empty($list)) {
            $result = $this->where($where)->save($data);
            if ($result === false) {
                $this->rollback();
                return getReturn(CODE_ERROR, '处理该维修内容失败，请稍后重试！！！');
            } else {
                $status = M('repair')->where($where)->save(['status' => IS_DEAL]);
                if ($status === false) {
                    $this->rollback();
                    return getReturn(CODE_ERROR, '处理状态修改失败，请稍后重试！！！');
                } else {
                    $this->commit();
                    return getReturn(CODE_SUCCESS, '处理成功!!!!');
                }
            }
        } else {
            $data['repair_id'] = $request['repair_id'];
            $result1 = $this->add($data);
            if ($result1) {
                $status1 = M('repair')->where($where)->save(['status' => IS_DEAL]);
                if ($status1 === false) {
                    $this->rollback();
                    return getReturn(CODE_ERROR, '处理状态修改失败，请稍后重试！！！');
                } else {
                    $this->commit();
                    return getReturn(CODE_SUCCESS, '处理成功!!!!');
                }
            } else {
                $this->rollback();
                return getReturn(CODE_ERROR, '处理该维修内容失败，请稍后重试！！！');
            }
        }


    }

}