<?php

namespace Goodcatch\Strategy;

/**
 * And策略
 */
class AndStrategy implements StrategyInterface {
    private $strategies;

    public function __construct($strategies) {
        $this->strategies = $strategies;
    }

    public function isSatisfied($data): bool
    {
        foreach ($this->strategies as $strategy) {
            if (!$strategy->isSatisfied($data)) {
                return false;
            }
        }
        return true;
    }
}
