<?php


namespace Common\Controller;

use Think\Controller;
use Think\Build;

/**
 *
 * 公共控制器类，做一些公共的事情
 * Class BaseController
 * @package Common\Controller
 * Date: 2021-01-16 13:19:44
 * Update: 2021-01-16 13:19:44
 * Version: 1.00
 */
class BaseController extends Controller\RestController
{

    /**
     * 响应函数。默认使用JSON
     * @param $data
     * @param string $type
     * @param int $code  HTTP状态
     * @param int $json_option
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-16 13:23:08
     * Update: 2021-01-16 13:23:08
     * Version: 1.00
     */
    protected function apiResponse($data, $type = 'json', $code = 200, $json_option = 256)
    {
        $this->sendHttpStatus($code);
        if (empty($data)) $data = '';
        if (is_array($data)) {
            $data['time'] = G('a', 'b') . 's';
        }
        if ('json' == $type) {
            // 返回JSON数据格式到客户端 包含状态信息
            $data = json_encode($data, $json_option);
        } elseif ('xml' == $type) {
            // 返回xml格式数据
            $data = xml_encode($data);
        } elseif ('php' == $type) {
            $data = serialize($data);
        }// 默认直接输出
        $this->setContentType($type);
        exit($data);
    }
}