<?php

namespace Goodcatch\Strategy;

class NotInArrayStrategy extends InArrayStrategy
{
    public function isSatisfied($data): bool
    {
        return !parent::isSatisfied($data);
    }
}
