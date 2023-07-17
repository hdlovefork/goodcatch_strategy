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
        // 如果不存在operator字段或者不存在conditions字段，直接报错
        if (!isset($config['operator']) || !isset($config['conditions'])) {
            throw new StrategyException('Invalid strategy config');
        }
        $strategyType = $config['operator'];
        $conditions = $config['conditions'];

        $strategies = [];
        foreach ($conditions as $condition) {
            if (isset($condition['operator']) && isset($condition['conditions'])) {
                $subStrategyGroup = self::make($condition);
                $strategies[] = $subStrategyGroup;
            } else {
                $field = $condition['field'];
                $operator = $condition['operator'];
                $value = $condition['value'];

                $strategyClass = self::getStrategyClass($operator);
                $strategy = new $strategyClass($field, $value);
                $strategies[] = $strategy;
            }
        }

        if ($strategyType === 'or') {
            return new StrategyManager(new OrStrategy($strategies));
        } elseif ($strategyType === 'and') {
            return new StrategyManager(new AndStrategy($strategies));
        } elseif ($strategyType === 'not') {
            return new StrategyManager(new NotStrategy(new AndStrategy($strategies)));
        } else {
            throw new StrategyException("Unsupported strategy type: $strategyType");
        }
    }

    // Helper function to map operators to strategy classes
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

    public function isSatisfied($data): bool
    {
        return $this->strategy->isSatisfied($data);
    }
}
