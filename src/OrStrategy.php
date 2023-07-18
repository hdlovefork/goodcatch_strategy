<?php

namespace Goodcatch\Strategy;

/**
 * or策略
 */
class OrStrategy implements StrategyInterface {
    private $strategies;

    public function __construct($strategies) {
        $this->strategies = $strategies;
    }

    public function isSatisfied($data): bool
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->isSatisfied($data)) {
                return true;
            }
        }
        return false;
    }
}
