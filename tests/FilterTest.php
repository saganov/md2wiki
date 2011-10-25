<?php

require_once __DIR__ . '/../Markdown/Text.php';

class FilterTest extends PHPUnit_Framework_TestCase
{
    public function testUseFallbackFilter()
    {
        // enabled by default
        $this->assertTrue(Markdown_Filter::useFallbackFilter());
    }
}
