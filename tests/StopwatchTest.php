<?php

namespace Razra\Component\Stopwatch\Tests;

use Razra\Component\Stopwatch\Stopwatch;
use Razra\Component\Stopwatch\StopwatchCollection;

class StopwatchTest extends TestCase
{
    public function testGuessCorrectName()
    {
        $stopwatch = Stopwatch::start();

        $this->assertEquals(__FUNCTION__, $stopwatch->getSectionName());
    }

    public function testCustomSectionName()
    {
        $stopwatch = Stopwatch::start('application');

        $this->assertEquals('application', $stopwatch->getSectionName());
    }

    public function testEndGatherThanZeroAfterStop()
    {
        $stopwatch = Stopwatch::start();

        sleep(1);

        $this->assertEquals(0, $stopwatch->getEnd());

        $stopwatch->stop();

        $this->assertGreaterThan(0, $stopwatch->getEnd());
    }

    public function testEndEqualsZeroAfterReset()
    {
        $stopwatch = Stopwatch::start();

        $stopwatch->stop()->reset();

        $this->assertEquals(0, $stopwatch->getEnd());
    }

    public function testAddToCollectionAfterStop()
    {
        $stopwatch = Stopwatch::start();

        $stopwatch->stop()->reset();

        $this->assertCount(1, StopwatchCollection::getAll());
    }

    public function testGetSeconds()
    {
        $stopwatch = Stopwatch::start();

        sleep(1);

        $stopwatch->stop();

        $this->assertEquals(1, $stopwatch->getSeconds());
    }

    public function testGetMilliseconds()
    {
        $stopwatch = Stopwatch::start();

        sleep(1);

        $stopwatch->stop();

        $this->assertGreaterThan(1, $stopwatch->getMilliseconds());
    }
}
