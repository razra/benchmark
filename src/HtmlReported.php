<?php

namespace Razra\Component\Stopwatch;

use DateTime;
use InvalidArgumentException;

class HtmlReported implements StopwatchReporter
{
    /**
     * Path where need put generated html report.
     *
     * @var string
     */
    protected $pathToReport;

    /**
     * HtmlReported constructor.
     *
     * @param string $pathToReport Directory where need generate html
     */
    public function __construct(string $pathToReport)
    {
        if (! is_dir($pathToReport)) {
            throw new InvalidArgumentException("Given path [{$pathToReport}] is not directory");
        }

        if (! is_writable($pathToReport)) {
            throw new InvalidArgumentException("Given path [{$pathToReport}] is not writable");
        }

        $this->pathToReport = rtrim($pathToReport, '\\/');
    }

    /**
     * {@inheritdoc}
     */
    public function report(): void
    {
        $stopwatches = StopwatchCollection::getAll();

        if (empty($stopwatches)) {
            return;
        }

        $layout = $this->getHtmlLayout();

        $layout = $this->replaceCommonMarkers($layout);
        $layout = $this->replaceContentMarkers($layout, $stopwatches);

        file_put_contents($this->pathToReport.DIRECTORY_SEPARATOR.'report_'.time().'.html', $layout);
    }

    /**
     * Get html layout.
     *
     * @return string
     */
    protected function getHtmlLayout(): string
    {
        return file_get_contents(__DIR__.'/resources/stubs/reports/html/layout.html');
    }

    /**
     * Get body section.
     *
     * @return string
     */
    protected function getHtmlContentBody(): string
    {
        return file_get_contents(__DIR__.'/resources/stubs/reports/html/content_body.html');
    }

    /**
     * Get section head.
     *
     * @return string
     */
    protected function getHtmlContentHead(): string
    {
        return file_get_contents(__DIR__.'/resources/stubs/reports/html/content_header.html');
    }

    /**
     * Replace markers in main section.
     *
     * @param string $layout
     * @param array $stopwatches An array of Stopwatches objects
     *
     * @return string
     */
    protected function replaceContentMarkers($layout, $stopwatches): string
    {
        $contentHead = $this->getHtmlContentHead();
        $contentBody = $this->getHtmlContentBody();

        $contentSections = [];

        foreach ($stopwatches as $sectionName => $stopwatchesArray) {
            $content = str_replace('{{SECTION_NAME}}', $sectionName, $contentHead);

            foreach ($stopwatchesArray as $stopwatch) {
                /*
                 * @var \Razra\Component\Stopwatch\Stopwatch $stopwatch
                 */
                $content .= str_replace([
                    '{{SECONDS}}', '{{MILLISECONDS}}',
                ], [
                    $stopwatch->getSeconds(), $stopwatch->getMilliseconds(),
                ], $contentBody);
            }

            $contentSections[] = $content;
        }

        return str_replace('{{CONTENT}}', implode(' ', $contentSections), $layout);
    }

    /**
     * Replace markers in main layout.
     *
     * @param string $template
     *
     * @return string
     */
    protected function replaceCommonMarkers(string $template): string
    {
        $now = new DateTime();

        $replace = [
            '{{DATE_CREATION}}' => $now->format('Y-m-d H:i:s'),
        ];

        return str_replace(array_keys($replace), array_values($replace), $template);
    }
}
