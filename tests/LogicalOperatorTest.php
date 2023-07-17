<?php

namespace Goodcatch\Strategy\Test;

use Goodcatch\Strategy\StrategyManager;
use PHPUnit\Framework\TestCase;

/**
 * 测试And,Or,Not策略
 */
class LogicalOperatorTest extends TestCase
{
    /**
     * 测试And策略
     * @test
     */
    public function should_satisfy_and_strategy()
    {
        // 配置
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => '>=',
                    'value' => 18
                ],
                [
                    'field' => 'gender',
                    'operator' => '=',
                    'value' => 'female'
                ]
            ]
        ];
        // 测试数据
        // 生成测试数据
        $testData = [
            ['age' => 20, 'gender' => 'female', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 25, 'gender' => 'male', 'occupation' => 'teacher', 'city' => 'Los Angeles'],
            ['age' => 30, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'Chicago'],
            ['age' => 17, 'gender' => 'male', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 21, 'gender' => 'female', 'occupation' => 'student', 'city' => 'Los Angeles'],
            ['age' => 20, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'New York'],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(4, $result);
    }

    /**
     * 测试Or策略
     */
    public function should_satisfy_or_strategy()
    {
        // 配置
        $config = [
            'operator' => 'or',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => '>=',
                    'value' => 18
                ],
                [
                    'field' => 'gender',
                    'operator' => '=',
                    'value' => 'female'
                ]
            ]
        ];
        // 测试数据
        // 生成测试数据
        $testData = [
            ['age' => 20, 'gender' => 'female', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 25, 'gender' => 'male', 'occupation' => 'teacher', 'city' => 'Los Angeles'],
            ['age' => 30, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'Chicago'],
            ['age' => 17, 'gender' => 'male', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 21, 'gender' => 'female', 'occupation' => 'student', 'city' => 'Los Angeles'],
            ['age' => 20, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'New York'],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(5, $result);
    }

    /**
     * 测试Not策略
     * @test
     */
    public function should_satisfy_not_strategy()
    {
        // 配置
        $config = [
            'operator' => 'not',
            'conditions' => [
                [
                    'field' => 'age',
                    'operator' => '>=',
                    'value' => 18
                ],
                [
                    'field' => 'gender',
                    'operator' => '=',
                    'value' => 'female'
                ]
            ]
        ];
        // 测试数据
        // 生成测试数据
        $testData = [
            ['age' => 20, 'gender' => 'female', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 25, 'gender' => 'male', 'occupation' => 'teacher', 'city' => 'Los Angeles'],
            ['age' => 30, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'Chicago'],
            ['age' => 17, 'gender' => 'male', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 21, 'gender' => 'female', 'occupation' => 'student', 'city' => 'Los Angeles'],
            ['age' => 20, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'New York'],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(2, $result);
    }

    /**
     * 测试And复杂策略
     * @test
     */
    public function should_satisfy_and_adv_strategy()
    {
        // 配置
        $config = [
            'operator' => 'and',
            'conditions' => [
                [
                    'operator' => 'and',
                    'conditions' => [
                        [
                            'field' => 'age',
                            'operator' => '>=',
                            'value' => 18
                        ],
                        [
                            'field' => 'gender',
                            'operator' => '=',
                            'value' => 'female'
                        ]
                    ]
                ],
                [
                    'field' => 'occupation',
                    'operator' => '=',
                    'value' => 'student'
                ],
                [
                    'operator' => 'or',
                    'conditions' => [
                        [
                            'field' => 'city',
                            'operator' => '=',
                            'value' => 'New York'
                        ],
                        [
                            'field' => 'city',
                            'operator' => '=',
                            'value' => 'Chicago'
                        ]
                    ]
                ]
            ]
        ];
        // 测试数据
        // 生成测试数据
        $testData = [
            ['age' => 20, 'gender' => 'female', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 25, 'gender' => 'male', 'occupation' => 'teacher', 'city' => 'Los Angeles'],
            ['age' => 30, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'Chicago'],
            ['age' => 17, 'gender' => 'male', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 21, 'gender' => 'female', 'occupation' => 'student', 'city' => 'Los Angeles'],
            ['age' => 20, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'New York'],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(1, $result);
    }

    /**
     * 测试Or复杂策略
     * @test
     */
    public function should_satisfy_or_adv_strategy()
    {
        // 配置
        $config = [
            'operator' => 'or',
            'conditions' => [
                [
                    'operator' => 'and',
                    'conditions' => [
                        [
                            'field' => 'age',
                            'operator' => '>=',
                            'value' => 18
                        ],
                        [
                            'field' => 'gender',
                            'operator' => '=',
                            'value' => 'female'
                        ]
                    ]
                ],
                [
                    'field' => 'occupation',
                    'operator' => '=',
                    'value' => 'student'
                ],
                [
                    'operator' => 'or',
                    'conditions' => [
                        [
                            'field' => 'city',
                            'operator' => '=',
                            'value' => 'New York'
                        ],
                        [
                            'field' => 'city',
                            'operator' => '=',
                            'value' => 'Chicago'
                        ]
                    ]
                ]
            ]
        ];
        // 测试数据
        // 生成测试数据
        $testData = [
            ['age' => 20, 'gender' => 'female', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 25, 'gender' => 'male', 'occupation' => 'teacher', 'city' => 'Los Angeles'],
            ['age' => 30, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'Chicago'],
            ['age' => 17, 'gender' => 'male', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 21, 'gender' => 'female', 'occupation' => 'student', 'city' => 'Los Angeles'],
            ['age' => 20, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'New York'],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(5, $result);
    }

    /**
     * 测试Not复杂策略
     * @test
     */
    public function should_satisfy_not_adv_strategy()
    {
        // 配置
        $config = [
            'operator' => 'not',
            'conditions' => [
                [
                    'operator' => 'and',
                    'conditions' => [
                        [
                            'field' => 'age',
                            'operator' => '>=',
                            'value' => 18
                        ],
                        [
                            'field' => 'gender',
                            'operator' => '=',
                            'value' => 'female'
                        ]
                    ]
                ],
                [
                    'field' => 'occupation',
                    'operator' => '=',
                    'value' => 'student'
                ],
                [
                    'operator' => 'or',
                    'conditions' => [
                        [
                            'field' => 'city',
                            'operator' => '=',
                            'value' => 'New York'
                        ],
                        [
                            'field' => 'city',
                            'operator' => '=',
                            'value' => 'Chicago'
                        ]
                    ]
                ]
            ]
        ];
        // 测试数据
        // 生成测试数据
        $testData = [
            ['age' => 20, 'gender' => 'female', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 25, 'gender' => 'male', 'occupation' => 'teacher', 'city' => 'Los Angeles'],
            ['age' => 30, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'Chicago'],
            ['age' => 17, 'gender' => 'male', 'occupation' => 'student', 'city' => 'New York'],
            ['age' => 21, 'gender' => 'female', 'occupation' => 'student', 'city' => 'Los Angeles'],
            ['age' => 20, 'gender' => 'female', 'occupation' => 'engineer', 'city' => 'New York'],
        ];

        $result = StrategyManager::make($config)->allSatisfied($testData);
        $this->assertCount(5, $result);
    }
}
