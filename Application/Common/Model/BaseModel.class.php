<?php
namespace Common\Model;

use Common\Util\DbCache;
use Think\Model;

class BaseModel extends Model
{


    public function __construct($name = '', $tablePrefix = '', $connection = '')
    {
        parent::__construct($name, $tablePrefix, $connection);
        $this->dbCache = DbCache::getInstance();
        G('a');
    }


    /**
     * @var DbCache
     */
    protected $dbCache;


    /**
     * 获取数量
     * @param array $options
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 13:03:49
     * Update: 2021-01-17 13:03:49
     * Version: 1.00
     */
    public function getCount($options = [])
    {
        // 如果是获取数量 则直接返回数量 并且不是分组查询 才能使用count函数直接返回结果数量
        $this->exeQuery($options);
        if (empty($options['group'])) {
            $result = $this->count();
        } else {
            // 只查主键 提高效率
            $pk = empty($options['alias']) ? $this->getPk() : $options['alias'] . '.' . $this->getPk();
            $this->field($pk);
            $result = $this->select();
        }
        if (false === $result) {
            return 0;
        }
        return is_array($result) ? count($result) : (int)$result;
    }

    /**
     * 获取列表
     * @param array $options
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 13:04:01
     * Update: 2021-01-17 13:04:01
     * Version: 1.00
     */
    public function queryList($options = [])
    {
        $this->dbCache->setModel($this);
        return $this->dbCache->select($options);
    }

    /**
     * 获取信息
     * @param array $options
     * @return array ['code'=>200, 'msg'=>'', 'data'=>null]
     * Date: 2021-01-17 13:04:15
     * Update: 2021-01-17 13:04:15
     * Version: 1.00
     */
    public function queryRow($options = [])
    {
        $this->dbCache->setModel($this);
        return $this->dbCache->find($options);
    }


    /**
     * 执行查询参数的连贯操作
     * @param array $options
     * where 用于查询或者更新条件的定义 字符串、数组和对象
     * table 用于定义要操作的数据表名称 字符串和数组
     * alias 用于给当前数据表定义别名 字符串
     * field 用于定义要查询的字段（支持字段排除） 字符串和数组
     * order 用于对结果排序 字符串和数组
     * group 用于对查询的group支持 字符串
     * having 用于对查询的having支持 字符串
     * join 用于对查询的join支持 字符串和数组
     * union 用于对查询的union支持 字符串、数组和对象
     * distinct 用于查询的distinct支持 布尔值
     * lock 用于数据库的锁机制 布尔值
     * cache 用于查询缓存 支持多个参数
     * relation 用于关联查询（需要关联模型支持） 字符串
     * result 用于返回数据转换 字符串
     * scope 用于命名范围 字符串、数组
     * bind 用于数据绑定操作 数组
     * comment 用于SQL注释 字符串
     * fetchSql 不执行SQL而只是返回SQL 布尔值
     * @return $this
     * Version: 1.0
     */
    public function exeQuery($options = [])
    {
        // 支持的连贯操作
        $exeArr = [
            'where', 'table', 'alias', 'field', 'order', 'group', 'having', 'join', 'distinct',
            'lock', 'cache', 'relation', 'result', 'scope', 'bind', 'comment', 'fetchSql'
        ];
        // 执行查询
        foreach ($options as $key => $value) {
            switch ($key) {
                case 'cache':
                    if (!empty($value)) call_user_func_array(array(&$this, 'cache'), $value);
                    break;
                default:
                    // 允许的操作执行
                    if (!empty($value) && in_array($key, $exeArr)) $this->$key($value);
                    break;
            }
        }
        return $this;
    }

    /**
     * 解析分页参数 计算 获取limit连贯操作的两个参数
     * @param array $options \
     * - skip 跳过多少条记录
     * - take 取多少条记录
     * - page 页数
     * - limit 取多少条
     * @return array ['code'=>200,'msg'=>'','data'=>[]]
     * Version: 1.0
     */
    public function parsePage($options = [])
    {
        // take和limit的值统一 如果take设置了就取take 没设置取limit -1表示取所有 mysql新版不支持 这里设置最大值
        if (isset($options['take']) && $options['take'] > 0) {
            $options['limit'] = $options['take'];
        } elseif (isset($options['limit']) && $options['limit'] > 0) {
            $options['take'] = $options['limit'];
        } elseif (
            (
                (isset($options['take']) && $options['take'] < 0) ||
                (isset($options['limit']) && $options['limit'] < 0)
            ) &&
            (isset($options['skip']) && $options['skip'] > 0)
        ) {
            $options['take'] = $options['limit'] = self::MAX_TAKE;
        } else {
            $options['take'] = 0;
            $options['limit'] = 0;
        }

        // skip 和 page
        if (isset($options['skip']) && isset($options['take']) && $options['skip'] > 0 && $options['take'] == 0) {
            $options['take'] = $options['limit'] = self::MAX_TAKE;
        } elseif (isset($options['page']) && isset($options['take']) && $options['page'] > 0 && $options['take'] == 0) {
            // 默认取20条
            $options['take'] = 0;
            $options['limit'] = 0;
            $options['skip'] = ($options['page'] - 1) * $options['take'];
        } elseif (isset($options['page']) && isset($options['take']) && $options['page'] > 0 && $options['take'] > 0) {
            $options['skip'] = ($options['page'] - 1) * $options['take'];
        } else {
            $options['skip'] = (isset($options['skip']) && $options['skip'] > 0) ? $options['skip'] : 0;
        }
        return $options;
    }

    public function __destruct()
    {
        G('b');
    }
}