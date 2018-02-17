<?php

namespace Razra\Component\Stopwatch\Tests\Utils;

use Razra\Component\Stopwatch\StopwatchCollection;

class OverriddenCollection extends StopwatchCollection
{
    public static function clear()
    {
        self::$stopwatches = [];
    }
}
