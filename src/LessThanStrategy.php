<?php

namespace Goodcatch\Strategy;

use Illuminate\Support\Arr;

/**
 * 小于策略(<)
 */
class LessThanStrategy implements StrategyInterface {
    private $field;
    private $value;

    public function __construct($field, $value) {
        $this->field = $field;
        $this->value = $value;
    }

    public function isSatisfied($data): bool
    {
        if(!isset($data[$this->field]))
            throw new StrategyException("less than strategy field:{$this->field} not found，data:".json_encode($data));
        return Arr::get($data, $this->field) < $this->value;
    }
}
