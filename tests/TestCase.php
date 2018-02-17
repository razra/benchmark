<?php

namespace Razra\Component\Stopwatch\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Razra\Component\Stopwatch\Tests\Utils\OverriddenCollection;

class TestCase extends BaseTestCase
{
    public function tearDown()
    {
        OverriddenCollection::clear();
    }
}
