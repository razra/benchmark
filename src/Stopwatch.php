<?php

namespace Razra\Component\Stopwatch;

class Stopwatch
{
    /**
     * Start stopwatch time
     *
     * @var float
     */
    protected $start;

    /**
     * Stop stopwatch time
     *
     * @var float
     */
    protected $end = 0;

    /**
     * Stopwatch section name
     *
     * @var string
     */
    protected $sectionName;

    /**
     * Stopwatch constructor
     *
     * @param string $sectionName
     */
    public function __construct(string $sectionName)
    {
        $this->start = $this->getMicrotime();
        $this->sectionName = $sectionName;
    }

    /**
     * Start stopwatch
     *
     * @param string|null $sectionName
     *
     * @return \Razra\Component\Stopwatch\Stopwatch
     */
    public static function start(string $sectionName = null): Stopwatch
    {
        $sectionName = $sectionName ?? self::guessSectionName();

        return new self($sectionName);
    }

    /**
     * Get start time
     *
     * @return float
     */
    public function getStart(): float
    {
        return $this->start;
    }

    /**
     * Get stop time
     *
     * @return float
     */
    public function getEnd(): float
    {
        return $this->end;
    }

    /**
     * Get section name
     *
     * @return string
     */
    public function getSectionName(): string
    {
        return $this->sectionName;
    }

    /**
     * Get seconds of
     *
     * @return float
     */
    public function getSeconds(): float
    {
        return round($this->getMilliseconds() / 1000, 2);
    }

    /**
     * Get milliseconds
     *
     * @return float
     */
    public function getMilliseconds(): float
    {
        return round(($this->end - $this->start) * 1000, 2);
    }

    /**
     * Try to find out name of function where stopwatch was called
     *
     * @return string
     */
    private static function guessSectionName(): string
    {
        foreach (debug_backtrace() as $trace) {
            if (isset($trace['class']) && $trace['class'] == Stopwatch::class) {
                continue;
            }

            if (isset($trace['function'])) {
                return $trace['function'];
            }
        }

        return 'default';
    }

    /**
     * Stop stopwatch
     *
     * @return \Razra\Component\Stopwatch\Stopwatch
     */
    public function stop(): Stopwatch
    {
        $this->end = $this->getMicrotime();

        StopwatchCollection::add(clone $this);

        return $this;
    }

    /**
     * Reset stopwatch
     *
     * @return \Razra\Component\Stopwatch\Stopwatch
     */
    public function reset(): Stopwatch
    {
        $this->end = 0;
        $this->start = $this->getMicrotime();

        return $this;
    }

    /**
     * Get current time in milliseconds
     *
     * @return float
     */
    protected function getMicrotime(): float
    {
        return microtime(true);
    }
}
