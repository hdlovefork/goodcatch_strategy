<?php

namespace Goodcatch\Strategy\Test;


use Goodcatch\Strategy\StrategyManager;
use PHPUnit\Framework\TestCase;

/**
 * 测试GreaterThan、GreaterThanOrEqual、LessThan、LessThanOrEqual、NotEqual、Equal、In、NotIn、Between、NotBetween策略
 */
class ComparisonOperatorsTest extends TestCase
{
    /**
     * 测试GreaterThan策略
     * @test
     */
    public function should_satisfy_greater_than_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => '>',
                    'value' => 18
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(4, $result);
    }

    /**
     * 测试GreaterThanOrEqual策略
     * @test
     */
    public function should_satisfy_greater_than_or_equal_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => '>=',
                    'value' => 18
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(4, $result);
    }

    /**
     * 测试LessThan策略
     * @test
     */
    public function should_satisfy_less_than_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => '<',
                    'value' => 18
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(1, $result);
    }

    /**
     * 测试LessThanOrEqual策略
     * @test
     */
    public function should_satisfy_less_than_or_equal_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => '<=',
                    'value' => 18
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(1, $result);
    }

    /**
     * 测试NotEqual策略
     * @test
     */
    public function should_satisfy_not_equal_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => '!=',
                    'value' => 18
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(5, $result);
    }

    /**
     * 测试Equal策略
     * @test
     */
    public function should_satisfy_equal_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => '=',
                    'value' => 18
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 18],
            ['age' => 31],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(1, $result);
    }

    /**
     * 测试In策略
     * @test
     */
    public function should_satisfy_in_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'in',
                    'value' => [18, 19, 20, 21]
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
            ['age' => 19],
            ['age' => 21],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(3, $result);
    }

    /**
     * 测试NotIn策略
     * @test
     */
    public function should_satisfy_not_in_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'notIn',
                    'value' => [18, 19, 20, 21]
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
            ['age' => 19],
            ['age' => 21],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(4, $result);
    }

    /**
     * 测试NotIn策略（运算空格分隔）
     * @test
     */
    public function should_satisfy_not_in_blank_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'not in',
                    'value' => [18, 19, 20, 21]
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
            ['age' => 19],
            ['age' => 21],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(4, $result);
    }

    /**
     * 测试Between策略
     * @test
     */
    public function should_satisfy_between_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'between',
                    'value' => [18, 25]
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
            ['age' => 19],
            ['age' => 21],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(4, $result);
    }

    /**
     * 测试NotBetween策略（运算空格分隔）
     * @test
     */
    public function should_satisfy_not_between_blank_strategy()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'not between',
                    'value' => [18, 25]
                ]
            ]
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
            ['age' => 19],
            ['age' => 21],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(3, $result);
    }

    /**
     * 简单条件测试
     * @test
     */
    public function should_satisfy_simple_condition(){
        $config =  [
            'field' => 'age',
            'operator' => '>',
            'value' => 18
        ];

        $testData = [
            ['age' => 20],
            ['age' => 25],
            ['age' => 30],
            ['age' => 17],
            ['age' => 31],
            ['age' => 19],
            ['age' => 21],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(6, $result);
    }

}
