<?php

namespace Razra\Component\Stopwatch\Tests;

use InvalidArgumentException;
use Razra\Component\Stopwatch\HtmlReported;
use Razra\Component\Stopwatch\Stopwatch;
use Razra\Component\Stopwatch\Tests\Utils\OverriddenCollection;
use Razra\Component\Stopwatch\Tests\Utils\OverriddenHtmlReporter;

class HtmlReporterTest extends TestCase
{
    /**
     * @var string
     */
    protected $pathForReports;

    public function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->pathForReports = __DIR__ . '/pathForReports';

        if (! is_dir($this->pathForReports)) {
            mkdir($this->pathForReports);
        }
    }

    public function tearDown()
    {
        parent::tearDown();

        chmod($this->pathForReports, 0777);

        foreach (glob($this->pathForReports . DIRECTORY_SEPARATOR . '*.html') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Given path [someRandomPath] is not directory
     */
    public function testExceptionIfGivenWrongPath()
    {
        new HtmlReported('someRandomPath');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testExceptionIfGivenNotWritableDirectoryPath()
    {
        chmod($this->pathForReports, 0555);

        new HtmlReported($this->pathForReports);
    }

    public function testCorrectPathForHtmlTemplates()
    {
        $reporter = new OverriddenHtmlReporter($this->pathForReports);

        $this->assertNotEmpty($reporter->getHtmlContentHead());
        $this->assertNotEmpty($reporter->getHtmlContentBody());
        $this->assertNotEmpty($reporter->getHtmlLayout());
    }

    public function testDontReportIfTheStopwatchHasNotBeenStarted()
    {
        $reporter = new HtmlReported($this->pathForReports);

        $reporter->report();

        $this->assertEmpty(glob($this->pathForReports . DIRECTORY_SEPARATOR . '/*'));
    }

    public function testReportCreateNewReport()
    {
        Stopwatch::start()->stop();

        $reporter = new HtmlReported($this->pathForReports);

        $reporter->report();

        $this->assertNotEmpty(glob($this->pathForReports . DIRECTORY_SEPARATOR . '/*'));
    }
}
