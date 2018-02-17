<?php

namespace Razra\Component\Stopwatch;

class StopwatchCollection
{
    /**
     * Array of Stopwatch objects
     *
     * @var array
     */
    protected static $stopwatches = [];

    /**
     * Add stopwatch to collection
     *
     * @param \Razra\Component\Stopwatch\Stopwatch $stopwatch
     */
    public static function add(Stopwatch $stopwatch): void
    {
        $sectionName = $stopwatch->getSectionName();

        if (isset(self::$stopwatches[$sectionName])) {
            self::$stopwatches[$sectionName][] = $stopwatch;
        } else {
            self::$stopwatches[$sectionName] = [$stopwatch];
        }
    }

    /**
     * Get stopwatches by section name
     *
     * @param string $sectionName
     *
     * @return array|null
     */
    public static function get(string $sectionName): ?array
    {
        return self::$stopwatches[$sectionName] ?? null;
    }

    /**
     * Get all stopwatches
     *
     * @return array
     */
    public static function getAll(): array
    {
        return self::$stopwatches;
    }
}
