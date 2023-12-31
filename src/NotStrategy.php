<?php

namespace Goodcatch\Strategy;

/**
 * not策略
 */
class NotStrategy implements StrategyInterface
{
    private $strategy;

    public function __construct($strategy)
    {
        $this->strategy = $strategy;
    }

    public function isSatisfied($data): bool
    {
        return !$this->strategy->isSatisfied($data);
    }
}
