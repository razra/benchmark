<?php

namespace Razra\Component\Stopwatch\Tests\Utils;

use Razra\Component\Stopwatch\HtmlReported;

class OverriddenHtmlReporter extends HtmlReported
{
    public function getHtmlContentBody(): string
    {
        return parent::getHtmlContentBody();
    }

    public function getHtmlContentHead(): string
    {
        return parent::getHtmlContentHead();
    }

    public function getHtmlLayout(): string
    {
        return parent::getHtmlLayout();
    }
}
