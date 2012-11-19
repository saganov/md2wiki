<?php
/**
 * Copyright (C) 2011, Maxim S. Tsepkov
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Markdown;

require_once __DIR__ . '/../Markdown/Text.php';

class TextTest extends \PHPUnit_Framework_TestCase
{
    const SAMPLE_MARKDOWN = <<<MD
This is a sample markdown
=========================

With a single paragraph.
MD;

    public function testConstruct()
    {
        $text = new Text(self::SAMPLE_MARKDOWN);

        $this->assertEquals(
            $text->getFilters(),
            $text->setFilters($text::getDefaultFilters()),
            'Default filters are returned when custom filters are not set.'
        );
    }

    public function testSetFilter()
    {
        $text = new Text(self::SAMPLE_MARKDOWN);

#        $text->setFilters('not array');
    }

    public function testGetHtml()
    {
        $text = new Text(self::SAMPLE_MARKDOWN);

#        var_dump($text->getHtml());
    }

    public function filesystem()
    {
        $data = array();

        foreach(glob(__DIR__ . '/data/*.html') as $html) {
            $basename = basename($html);
            $markdown = dirname($html) . '/' . substr($basename, 0, -5);
            if (is_readable($markdown)) {
                $data[] = array(
                        file_get_contents($markdown),
                        file_get_contents($html)
                );
            }
        }

        return $data;
    }

    public function testGetDefaultFiltersNonEmpty()
    {
        $this->assertNotEmpty(Text::getDefaultFilters());
    }

    /**
     * @depends testGetDefaultFiltersNonEmpty
     */
    public function testSetDefaultFilters()
    {
        $filters = array('Linebreak', 'Hr');
        Text::setDefaultFilters($filters);
        $this->assertEquals(Text::getDefaultFilters(), $filters);
        Text::setDefaultFilters(Text::getFactoryDefaultFilters());
    }

    /**
     * @dataProvider filesystem
     */
    public function testWithDataFiles($md, $html)
    {
        $this->assertEquals($html, (string) new Text($md));
    }

}
