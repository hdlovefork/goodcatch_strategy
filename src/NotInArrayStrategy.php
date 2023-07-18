<?php

namespace Goodcatch\Strategy;

/**
 * not in策略
 */
class NotInArrayStrategy extends InArrayStrategy
{
    public function isSatisfied($data): bool
    {
        return !parent::isSatisfied($data);
    }
}
