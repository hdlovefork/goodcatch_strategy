<?php

namespace Goodcatch\Strategy;

class BetweenStrategy implements StrategyInterface {
    private $field;
    private $startValue;
    private $endValue;

    public function __construct($field,$value) {
        $this->field = $field;
        if(count($value) != 2)
            throw new StrategyException("between strategy value count must be 2，value:".json_encode($value));
        $this->startValue = $value[0];
        $this->endValue = $value[1];
    }

    public function isSatisfied($data): bool
    {
        if(!isset($data[$this->field]))
            throw new StrategyException("between strategy field:{$this->field} not found，data:".json_encode($data));
        $value = $data[$this->field];
        return $value >= $this->startValue && $value <= $this->endValue;
    }
}
