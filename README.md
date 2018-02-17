# Stopwatch component

## Installation
To be continued...

## How to use
1. You can define stopwatch in 2 ways
    
    First: 
    ```php
    $stopwatch = new Stopwatch('someName');
    ```
    Second:
    ```php
    $stopwatch = Stopwatch::start('someName');
    // or without parameter (that stopwatch will try to get name of method where its called)
    $stopwatch = Stopwatch::start();
    ```
2. Stop the stopwatch
    ```php
    $stopwatch->stop();
    ```
3. Generate html report 
    ```php
    // it will create html page with report of stopwatches in given path
    $reporter = new HtmlReported('path/to/your/folder');
    $reporter->report();
    ```

## Availability to create custom reporter
You can always create you report if you want. You can get all executed stopwatches from `StopwatchCollection::getAll()`, it will return array of `Stopwatch` objects all execute stopwatches.

Example structure:
```
    [
        'sectionName' => [
            new Stopwatch(),
            new Stopwatch(),
            new Stopwatch(),
            ...
        ],
        'anotherSectionName' => [
            new Stopwatch(),
            new Stopwatch(),
            new Stopwatch(),
            ...
        ],
        ...
    ]
```
    
Usage example:
```php

<?php

require_once __DIR__ . '/vendor/autoload.php';

use Razra\Component\Stopwatch\HtmlReported;
use Razra\Component\Stopwatch\Stopwatch;

// start our first stopwatch
$stopwatch = Stopwatch::start('Application');

class StopwatchExample
{
    public function first()
    {
        // start our second stopwatch
        $stopwatch = Stopwatch::start();

        for ($i =0; $i < 100000000; $i++) {
        }

        // stop second stopwatch and reset
        $stopwatch->stop()->reset();

        // do something...
        
        // stop second stopwatch and reset
        // it will have time difference between prev reset and this stop
        $stopwatch->stop()->reset();

        // do something
        
        // stop second stopwatch
        $stopwatch->stop();
    }

    public function second()
    {
        // start our third stopwatch
        $stopwatch = Stopwatch::start();

        // stop third stopwatch
        $stopwatch->stop();
    }

    public function third()
    {
        // start our fourth stopwatch
        $stopwatch = Stopwatch::start();

        // stop fourth stopwatch
        $stopwatch->stop();
    }
}

// call methods
$stopwatchExample = new StopwatchExample();
$stopwatchExample->first();
$stopwatchExample->second();
$stopwatchExample->third();

$pathForReports = __DIR__ . '/reported';

if (! is_dir($pathForReports)) {
    mkdir($pathForReports);
}

// stop our first stopwatch
$stopwatch->stop();

// report our stopwatches, will put html page in $pathForReports path
$reporter = new HtmlReported($pathForReports);
$reporter->report();

```
