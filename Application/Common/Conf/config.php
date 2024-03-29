<?php
return array(
    //'配置项'=>'配置值'
    //数据库配置信息
    'DB_TYPE' => 'mysql', // 数据库类型
    'DB_HOST' => 'localhost', // 服务器地址
    'DB_NAME' => 'poms_db', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => '123456', // 密码
    'DB_PORT' => 3306, // 端口
    'DB_PARAMS' => array(), // 数据库连接参数
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_CHARSET' => 'utf8', // 字符集
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志

    //'配置项'=>'配置值'
    'TMPL_PARSE_STRING' => array(
        '__ADMIN__' => __ROOT__ . '/Data/admin',
        '__HOME__' => __ROOT__ . '/Data/home',
        '__PULL__' => __ROOT__ . '/Data/pull',
        '__STATIC__' => __ROOT__ . '/Data/static',
        '__LESSEE__' => __ROOT__ . '/Data/lessee',
    ),
);