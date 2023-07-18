<?php

namespace Goodcatch\Strategy\Test;

use Goodcatch\Strategy\StrategyValidator;
use PHPUnit\Framework\TestCase;

class StrategyValidatorTest extends TestCase
{
    /**
     * and应该是一个有效的operator
     * @test
     */
    public function the_and_should_valid_operator()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'between',
                    'value' => [18, 30]
                ]
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertTrue($result);
    }

    /**
     * or应该是一个有效的operator
     * @test
     */
    public function the_or_should_valid_operator()
    {
        $config = [
            'operator' => 'or',
            'conditions' => [
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertTrue($result);
    }

    /**
     * not应该是一个有效的operator
     * @test
     */
    public function the_not_should_valid_operator()
    {
        $config = [
            'operator' => 'not',
            'conditions' => [
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertTrue($result);
    }

    /**
     * xor应该不是一个有效的operator
     * @test
     */
    public function the_xor_should_valid_operator()
    {
        $config = [
            'operator' => 'xor',
            'conditions' => [
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertFalse($result);
    }

    /**
     * <、>、<=、>=、=、!=、in、notIn、between、notBetween应该是一个有效的operator
     * @test
     */
    public function the_comparison_operators_should_valid_operator()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => '>',
                    'value' => 18
                ],
                [
                    'field' => 'age',
                    'operator' => '<',
                    'value' => 18
                ],
                [
                    'field' => 'age',
                    'operator' => '>=',
                    'value' => 18
                ],
                [
                    'field' => 'age',
                    'operator' => '<=',
                    'value' => 18
                ],
                [
                    'field' => 'age',
                    'operator' => '=',
                    'value' => 18
                ],
                [
                    'field' => 'age',
                    'operator' => '!=',
                    'value' => 18
                ],
                [
                    'field' => 'age',
                    'operator' => 'in',
                    'value' => [18, 19, 20]
                ],
                [
                    'field' => 'age',
                    'operator' => 'notIn',
                    'value' => [18, 19, 20]
                ],
                [
                    'field' => 'age',
                    'operator' => 'not in',
                    'value' => [18, 19, 20]
                ],
                [
                    'field' => 'age',
                    'operator' => 'between',
                    'value' => [18, 30]
                ],
                [
                    'field' => 'age',
                    'operator' => 'notBetween',
                    'value' => [18, 30]
                ],
                [
                    'field' => 'age',
                    'operator' => 'not between',
                    'value' => [18, 30]
                ],
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertTrue($result);
    }

    /**
     * !应该是一个无效的operator
     * @test
     */
    public function the_exclamation_should_invalid_operator()
    {
        $config = [
            'operator' => '!',
            'conditions' => [
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertFalse($result);
    }

    /**
     * in运算符应该是一个数组
     * @test
     */
    public function the_in_should_be_an_array()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'in',
                    'value' => 18
                ],
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertFalse($result);
    }

    /**
     * not in运算符应该是一个数组
     * @test
     */
    public function the_not_in_should_be_an_array()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'not in',
                    'value' => 18
                ],
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertFalse($result);
    }

    /**
     * in运算符可以是一个空数组
     * @test
     */
    public function the_in_can_be_an_empty_array()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'in',
                    'value' => []
                ],
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertTrue($result);
    }

    /**
     * between运算符应该是一个数组
     * @test
     */
    public function the_between_should_be_an_array()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'between',
                    'value' => 18
                ],
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertFalse($result);
    }

    /**
     * not between运算符应该是一个数组
     * @test
     */
    public function the_not_between_should_be_an_array()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'not between',
                    'value' => 18
                ],
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertFalse($result);
    }

    /**
     * between、not between运算符应该至少有2个值
     * @test
     */
    public function the_between_should_have_at_least_two_values()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'between',
                    'value' => [18]
                ]
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertFalse($result);
    }

    /**
     * between运算符第2个值应该大于第1个值
     * @test
     */
    public function the_between_should_have_second_value_greater_than_first_value()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => 'between',
                    'value' => [30, 18]
                ]
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertFalse($result);
    }

    /**
     * conditions可以嵌套另一个conditions
     * @test
     */
    public function the_conditions_can_be_nested_another_conditions()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'operator' => 'and',
                    'conditions' => [
                    ]
                ],
                [
                    'operator' => 'or',
                    'conditions' => [
                    ]
                ],
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertTrue($result);
    }

    /**
     * conditions下面可以包含一个简单条件
     * @test
     */
    public function the_conditions_can_contain_a_simple_condition()
    {
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'operator' => 'and',
                    'conditions' => [
                    ]
                ],
                [
                    'field' => 'age',
                    'operator' => '=',
                    'value' => 18
                ]
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertTrue($result);
    }

    /**
     * 允许$conditions为简单条件
     * @test
     */
    public function the_conditions_can_be_a_simple_condition()
    {
        $config =  [
            'field' => 'age',
            'operator' => '=',
            'value' => 18
        ];

        $result = StrategyValidator::validate($config);
        $this->assertTrue($result);
    }

    /**
     * 多个简单条件不能作为根元素
     * @test
     */
    public function the_multiple_simple_conditions_cannot_be_root_element()
    {
        $config =  [
            [
                'field' => 'age',
                'operator' => '=',
                'value' => 18
            ],
            [
                'field' => 'age',
                'operator' => '=',
                'value' => 21
            ]
        ];

        $result = StrategyValidator::validate($config);
        $this->assertFalse($result);
    }
}
