<?php

namespace Goodcatch\Strategy;

/**
 * 策略配置校验器
 */
class StrategyConfigValidator
{
    public static function validateConfig($config)
    {
        if (!isset($config['operator']) || !in_array($config['operator'], ['or', 'and', 'not'])) {
            return false;
        }

        if (!isset($config['conditions']) || !is_array($config['conditions'])) {
            return false;
        }

        foreach ($config['conditions'] as $condition) {
            if (!self::validateCondition($condition)) {
                return false;
            }
        }

        return true;
    }

    public static function validateCondition($condition)
    {
        if (isset($condition['operator']) && in_array($condition['operator'], ['or', 'and', 'not'])) {
            if (!isset($condition['conditions']) || !is_array($condition['conditions'])) {
                return false;
            }

            foreach ($condition['conditions'] as $innerCondition) {
                if (!self::validateCondition($innerCondition)) {
                    return false;
                }
            }
        } else {
            if (!isset($condition['field']) || !isset($condition['operator']) || !isset($condition['value'])) {
                return false;
            }
            if (!in_array($condition['operator'], ['>', '<', '=', '<=', '>=', '!=', '<>', 'in', 'between', 'not in', 'not between', 'notIn', 'notBetween'])) {
                return false;
            }
            if (in_array($condition['operator'], ['in', 'not in', 'notIn', 'between', 'not between', 'notBetween'])) {
                if (!is_array($condition['value']))
                    return false;
                if (in_array($condition['operator'], ['between', 'not between', 'notBetween'])) {
                    if (count($condition['value']) < 2) {
                        return false;
                    }
                    // 如果是between，那么第一个值必须小于第二个值
                    if ($condition['value'][0] > $condition['value'][1]) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

}
