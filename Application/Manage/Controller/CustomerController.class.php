<?php
namespace Manage\Controller;
use Think\Controller;
class CustomerController extends Controller {

    public function _initialize(){
        if (session('USER')){
            $user = session('USER');
            $this->assign('USER', $user);
        }else{
            $this->assign('USER', '请先登录！！！');
        }
    }

    public function index()
    {
        $this->display();
    }

    /**
     *
     * 获取租户列表数据
     * Date: 2020-12-19 18:46:01
     * Update: 2020-12-19 18:46:01
     * Version: 1.00
     */
    public function getCustomerList(){
        $customer = M('customer');
        $where = array();
        $where['is_delete'] = 0;
        $page = $_GET['_URL_'][4];
        $limit = $_GET['_URL_'][5];
        $start = $limit * ($page - 1);
        $data = $customer->where($where)->limit($start, $limit)->order('customer_id', 'desc')->select();
        $count = count($customer->where($where)->select());
        $msg = [
            'code' => 0,
            'msg' => '查询成功',
            'data' => $data,
            'count' => $count
        ];
        echo json_encode($msg);
        die();
    }

    public function customer_add()
    {
        $this->display();
    }

    public function customer_edit()
    {
        $this->display();
    }

    /**
     *
     * 添加租户
     * Date: 2020-12-19 21:56:34
     * Update: 2020-12-19 21:56:34
     * Version: 1.00
     */
    public function addCustomer(){
        $customer = M('customer');
        $data = [];
        $data['customer_name'] = $_POST['customer_name'];
        $data['customer_mobile'] = $_POST['customer_mobile'];
        $data['garden_id'] = session('USER.garden_id');
        $data['manager_id'] = session('USER.id');
        $data['manager_name'] = session('USER.manager_name');
        $data['garden_name'] = $_POST['garden_name'];
        $data['room_name'] = $_POST['room_name'];
        $data['remark'] = $_POST['remark'];
        $data['password'] = md5('123456');
        $data['create_time'] = time();
        $result = $customer->add($data);
        if ($result){
            $this->success('添加成功');
        }else {
            $this->error('系统繁忙，请重试！！');
        }
    }

    /**
     *
     * @param $customerId
     * 获取租户信息
     * Date: 2020-12-19 21:58:26
     * Update: 2020-12-19 21:58:26
     * Version: 1.00
     */
    public function getCustomer($customerId){
        $customer = M('customer');
        $where = array();
        $where['customer_id'] = $customerId;
        $data = $customer->where($where)->select();
        echo json_encode($data);
        die();
    }

    /**
     *
     * 编辑租户信息并保存
     * Date: 2020-12-19 21:57:06
     * Update: 2020-12-19 21:57:06
     * Version: 1.00
     */
    public function editCostomer(){
        $customer = M('customer');
        $where = array();
        $where['customer_id'] = $_POST['customer_id'];
        $data = [];
        $data['customer_name'] = $_POST['customer_name'];
        $data['customer_mobile'] = $_POST['customer_mobile'];
        $data['garden_name'] = $_POST['garden_name'];
        $data['room_name'] = $_POST['room_name'];
        $data['remark'] = $_POST['remark'];
        $result = $customer->where($where)->save($data);
        if ($result){
            $this->success('编辑成功!!!');
        }else{
            $this->error('系统繁忙!!!');
        }
    }

    /**
     *
     * @param $customerId
     * 删除租户
     * Date: 2020-12-19 21:57:27
     * Update: 2020-12-19 21:57:27
     * Version: 1.00
     */
    public function deleteCustomer($customerId){
        $customer = M('customer');
        $where = array();
        $where['customer_id'] = $customerId;
        $result = $customer->where($where)->save(['is_delete' => 1]);
        if ($result){
            $this->success('删除成功');
        }else {
            $this->error('系统繁忙！！请重试');
        }
    }

    public function customer_del()
    {
        $this->display();
    }

    public function customer_password()
    {
        $this->display();
    }
}