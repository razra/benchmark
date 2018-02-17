<?php

namespace Razra\Component\Stopwatch;

interface StopwatchReporter
{
    /**
     * Report stopwatches
     *
     * @return void
     */
    public function report(): void;
}
