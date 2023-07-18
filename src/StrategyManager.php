<?php

namespace Goodcatch\Strategy;

class StrategyManager implements StrategyInterface
{
    protected $strategy;

    public function __construct($strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * 根据配置生成策略
     * @param $config
     * @return $this
     * @throws StrategyException
     */
    public static function make($config)
    {
        // 验证策略配置是否有效，如果无效则抛出异常
        StrategyValidator::validate($config);
        // 如果为简单策略，则直接返回
        if (!isset($config['conditions'])) {
            return new StrategyManager(static::makeSimpleStrategy($config));
        }
        $operator = $config['operator'];
        $conditions = $config['conditions'];
        $strategies = [];
        foreach ($conditions as $condition) {
            if (isset($condition['operator']) && isset($condition['conditions'])) {
                $subStrategyGroup = static::make($condition);
                $strategies[] = $subStrategyGroup;
            } else {
                $strategy = static::makeSimpleStrategy($condition);
                $strategies[] = $strategy;
            }
        }

        if ($operator === 'or') {
            return new StrategyManager(new OrStrategy($strategies));
        } elseif ($operator === 'and') {
            return new StrategyManager(new AndStrategy($strategies));
        } elseif ($operator === 'not') {
            return new StrategyManager(new NotStrategy(new AndStrategy($strategies)));
        } else {
            throw new StrategyException("Unsupported strategy type: $operator");
        }
    }

    /**
     * 根据操作符获取策略类
     * @param $operator
     * @return string
     * @throws StrategyException
     */
    protected static function getStrategyClass($operator)
    {
        $map = [
            '>' => 'GreaterThanStrategy',
            '<' => 'LessThanStrategy',
            '=' => 'EqualToStrategy',
            '<=' => 'LessThanOrEqualToStrategy',
            '>=' => 'GreaterThanOrEqualToStrategy',
            '!=' => 'NotEqualToStrategy',
            '<>' => 'NotEqualToStrategy',
            'in' => 'InArrayStrategy',
            'not in' => 'NotInArrayStrategy',
            'notIn' => 'NotInArrayStrategy',
            'between' => 'BetweenStrategy',
            'not between' => 'NotBetweenStrategy',
            'notBetween' => 'NotBetweenStrategy',
        ];

        if (!isset($map[$operator])) {
            throw new StrategyException("Unsupported operator: $operator");
        }
        // 返回当前命令空间加上类名
        return __NAMESPACE__ . '\\' . $map[$operator];
    }

    /**
     * 根据配置生成简单策略
     * @param $condition
     * @return mixed
     * @throws StrategyException
     */
    protected static function makeSimpleStrategy($condition)
    {
        $field = $condition['field'];
        $operator = $condition['operator'];
        $value = $condition['value'];

        $strategyClass = static::getStrategyClass($operator);
        return new $strategyClass($field, $value);
    }

    /**
     * 判断是否满足策略
     * @param $data array 要判断的多个数据
     * @return array 返回所有满足策略的数据
     */
    public function allSatisfied($data): array
    {
        $items = is_array($data) ? $data : [$data];
        $result = [];
        foreach ($items as $item) {
            if ($this->strategy->isSatisfied($item)) {
                $result[] = $item;
            }
        }
        return $result;
    }

    /**
     * 判断是否满足策略
     * @param $data array 要判断的单个数据
     * @return bool 是否满足策略，满足返回true，否则返回false
     */
    public function isSatisfied($data): bool
    {
        return $this->strategy->isSatisfied($data);
    }
}
