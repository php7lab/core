<?php

namespace PhpLab\Core\Libs\Store;

use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;

class ActiveStore
{

    public static $dir = '@common/data';
    public static $type = 'php';
    protected static $storeInstance = null;

    public static function one($where)
    {
        $data = [];
        if (is_array($where)) {
            $all = static::all();
            $filtered = static::runConditionList($all, $where, 1);
            if ( ! empty($filtered)) {
                $data = ArrayHelper::first($filtered);
            }
        } else {
            $data = static::storeInstance()->load(static::fileName(), $where);
        }
        return $data;
    }

    public static function all($where = null, $condition = [])
    {
        $all = static::storeInstance()->load(static::fileName());
        $limit = ! empty($condition['limit']) ? $condition['limit'] : false;
        $filtered = static::runConditionList($all, $where, $limit);
        return $filtered;
    }

    /**
     * @return Store
     */
    protected static function storeInstance()
    {
        if (empty(static::$storeInstance)) {
            static::$storeInstance = new Store(static::$type);
        }
        return static::$storeInstance;
    }

    protected static function fileName()
    {
        return static::$dir . '/' . static::$name . '.' . static::$type;
    }

    protected static function runConditionList($all, $where, $limit = false)
    {
        if (empty($where)) {
            return $all;
        }
        $filtered = [];

        foreach ($all as $pk => $row) {
            if ($limit === 0) {
                break;
            }
            if (static::runCondition($row, $where)) {
                $filtered[$pk] = $row;
                if ($limit !== false) {
                    $limit--;
                }
            }
        }

        return $filtered;
    }

    protected static function runCondition($item, $where)
    {
        $result = true;
        if (empty($where)) {
            return true;
        }
        foreach ($where as $key => $value) {
            if ($item[$key] != $value) {
                $result = false;
            }
        }
        return $result;
    }

}