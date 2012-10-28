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

class FilterTest extends \PHPUnit_Framework_TestCase
{
    protected static $_md   = array();
    protected static $_html = array();

    public static function setUpBeforeClass()
    {
        $mds = glob(__DIR__ . '/data/*.md');
        foreach($mds as $filename) {
            $key = basename($filename, '.md');
            self::$_md[$key] = file_get_contents($filename);
        }

        $htmls = glob(__DIR__ . '/data/*.html');
        foreach($htmls as $filename) {
            $key = basename($filename, '.html');
            self::$_html[$key] = file_get_contents($filename);
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFactoryNonAlnum()
    {
        Filter::factory('/etc/passwd');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testFactoryNonExistent()
    {
        Filter::factory('suchfilterdoesntexists');
    }

    public function testFactory()
    {
        $this->assertInstanceOf('\Markdown\Filter', Filter::factory('Hr'));
    }

    public function testGetDefaultFiltersNonEmpty()
    {
        $this->assertNotEmpty(Filter::getDefaultFilters());
    }

    /**
     * @depends testGetDefaultFiltersNonEmpty
     */
    public function testSetDefaultFilters()
    {
        $filters = array('Linebreak', 'Hr');
        Filter::setDefaultFilters($filters);
        $this->assertEquals(Filter::getDefaultFilters(), $filters);
        Filter::setDefaultFilters(Filter::getFactoryDefaultFilters());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testRunWithInvalidFiltersParameter()
    {
        Filter::run('', array('Filter', 1, false, true));
    }

    public function testWithDataFiles()
    {
        foreach (self::$_md as $key => $md)
        {
            $this->assertEquals(self::$_html[$key], (string) Filter::run($md));
        }
    }
}
