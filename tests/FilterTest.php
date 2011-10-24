<?php
namespace Markdown;

require_once __DIR__ . '/../Markdown/Text.php';

class FilterTest extends \PHPUnit_Framework_TestCase
{
    public function testUseOriginalFilter()
    {
        Filter::useOriginalFilter(true);
        $text = new Text('');
        $filters = $text->getFilters();
        $this->assertEquals(new Filter\Original, end($filters));

        Filter::useOriginalFilter(false);
        $text = new Text('');
        $filters = $text->getFilters();
        $this->assertNotEquals(new Filter\Original, end($filters));
    }
}
