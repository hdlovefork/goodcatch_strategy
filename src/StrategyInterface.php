<?php

namespace Goodcatch\Strategy;

/**
 * 策略接口
 * Class NotBetweenStrategy
 */
interface StrategyInterface
{
    /**
     * 判断数据是否满足策略
     * @param $data mixed 数据
     * @return bool 如果不满足条件返回false，否则返回true
     */
    public function isSatisfied(mixed $data): bool;
}
