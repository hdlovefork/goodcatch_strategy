# 功能介绍
可以根据一个策略条件判断给定的对象是否满足该策略

# 快速开始
下面定义了一个简单的策略，该策略的意思是：当用户的年龄等于18岁时，该用户满足该策略
```php
// 策略定义
$strategy = [
    'operator' => 'and',
    'conditions' => [
        [
            'operator' => '=',
            'field' => 'age',
            'value' => '18',
        ]
    ]
];

// 待测试的一个用户
$user = [
    'age' => 18,
];
\Goodcatch\Strategy\StrategyManager::make($strategy)->isSatisfied($user);// true

// 待测试的多个用户
$users = [
    [
        'age' => 18,
    ],
    [
        'age' => 19,
    ]
];
\Goodcatch\Strategy\StrategyManager::make($strategy)->allSatisfied($users);// [['age'=>18]]
```

# 策略定义
策略定义是一个数组，数组中包含两个元素，分别是`operator`和`conditions`，`operator`表示`conditions`中的条件之间的关系，`conditions`表示条件数组，`conditions`中的每个元素都是一个条件，条件的格式如下：
```php
[
    'operator' => 'and',
    'conditions' => [
        [
            'operator' => '=',
            'field' => 'age',
            'value' => '18',
        ],
        [
            'operator' => '=',
            'field' => 'gender',
            'value' => 'female'
        ],
    ]
]
```
上面表示的是：当用户的年龄等于18岁并且性别为女性时，该用户满足该策略，我们可以更改`operator`将它更改为`or`
```php
[
    'operator' => 'or',// 这里将operator更改为or
    'conditions' => [
        [
            'operator' => '=',
            'field' => 'age',
            'value' => '18',
        ],
        [
            'operator' => '=',
            'field' => 'gender',
            'value' => 'female'
        ],
    ]
]
```
此时表示的意思是：当用户的年龄等于18岁或者性别为女性时，该用户满足该策略。

此外策略条件也允许嵌套，如下：
```php
[
    'operator' => 'and',
    'conditions' => [
        [
            'operator' => '=',
            'field' => 'age',
            'value' => '18',
        ],
        [
            'operator' => '=',
            'field' => 'gender',
            'value' => 'female'
        ],
        [
            'operator' => 'or',
            'conditions'=>[
                [
                    'operator' => '=',
                    'field' => 'hobby',
                    'value' => 'basketball'
                ],
                [
                    'operator' => '=',
                    'field' => 'city',
                    'value' => 'beijing'
                ]     
            ]
        ]     
    ]
]
```
上面表示的是：当用户的年龄等于18岁并且性别为女性并且爱好为篮球或者所在城市为北京时，该用户满足该策略。

# 策略运算符
策略运算符分为逻辑运算符和比较运算符：
## 逻辑运算符
`and` `or` `not` 三种逻辑运算符，并且只能作用于条件`conditions`之上，不能作用于字段`field`，如下：
```php
[
    'operator' => 'and',
    'conditions' => [
        [
            'operator' => '=',
            'field' => 'age',
            'value' => '18',
        ],
        ...
    ]
]
```
如下是错误的：
```php
[
    'operator' => 'and',
    'conditions' => [
        [
            'operator' => 'and',// 错误
            'field' => 'age',
            'value' => '18',
        ],
        ...
    ]
]
```

## 比较运算符
`<` `<=` `>` `>=` `=` `!=` `in` `not in` `between` `not between`，比较运算符只能作用于字段`field`，不能作用于条件`conditions`，如下：
```php
[
    'operator' => 'and',
    'conditions' => [
        [
            'operator' => '=',
            'field' => 'age',// 正确
            'value' => '18',
        ],
        ...
    ]
]
```
如下是错误的：
```php
[
    'operator' => '=',// 错误
    'conditions' => [
        [
            'operator' => '=',
            'field' => 'age',
            'value' => '18',
        ],
        ...
    ]
]
```
其中`in` `between` `not in` `not between`四种运算符的`value`应该是一个数组，如下：
```php
[
    'operator' => 'and',
    'conditions' => [
        [
            'operator' => 'in',
            'field' => 'age',
            'value' => ['18','19','20'],// 正确
        ],
        ...
    ]
]
```
