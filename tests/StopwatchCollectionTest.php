<?php

namespace Razra\Component\Stopwatch\Tests;

use Razra\Component\Stopwatch\Stopwatch;
use Razra\Component\Stopwatch\StopwatchCollection;

class StopwatchCollectionTest extends TestCase
{

    public function testAddNewStopwatch()
    {
        $stopwatch = Stopwatch::start('test');

        StopwatchCollection::add($stopwatch);

        $this->assertCount(1, StopwatchCollection::getAll());
    }

    public function testGetByKey()
    {
        $stopwatch = Stopwatch::start('test');

        StopwatchCollection::add($stopwatch);
        $this->assertCount(1, StopwatchCollection::get('test'));

        StopwatchCollection::add($stopwatch);
        $this->assertCount(2, StopwatchCollection::get('test'));
    }
}
