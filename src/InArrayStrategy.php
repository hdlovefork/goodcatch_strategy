<?php

namespace Goodcatch\Strategy;

class InArrayStrategy implements StrategyInterface {
    private $field;
    private $values;

    public function __construct($field, $values) {
        $this->field = $field;
        $this->values = $values;
    }

    public function isSatisfied($data): bool
    {
        if(!isset($data[$this->field]))
            throw new StrategyException("in array strategy field:{$this->field} not found，data:".json_encode($data));
        return in_array($data[$this->field], $this->values);
    }
}
