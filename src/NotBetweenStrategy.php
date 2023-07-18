<?php

namespace Goodcatch\Strategy;

/**
 * not between策略
 */
class NotBetweenStrategy extends BetweenStrategy
{
    public function isSatisfied($data): bool
    {
        return !parent::isSatisfied($data);
    }
}
