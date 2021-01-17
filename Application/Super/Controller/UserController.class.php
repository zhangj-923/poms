<?php

namespace Super\Controller;

use Think\Controller;

class UserController extends Controller
{

    public function _initialize()
    {
        if (session('ADMIN')) {
            $admin = session('ADMIN');
            $this->assign('ADMIN', $admin);
        } else {
            $this->assign('ADMIN', '请先登录！！！');
        }
    }

}