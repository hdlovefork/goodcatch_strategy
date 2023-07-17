<?php

namespace Goodcatch\Strategy;

class NotBetweenStrategy extends BetweenStrategy
{
    public function isSatisfied($data): bool
    {
        return !parent::isSatisfied($data);
    }
}
