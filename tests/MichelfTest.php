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

require_once __DIR__ . '/vendor/michelf/markdown.php';
require_once __DIR__ . '/../Markdown/Text.php';

class MichelfTest extends \PHPUnit_Framework_TestCase
{
    protected $_markdown;

    /**
     * Generate a large markdown document.
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        // 1M
        $size = 1024 * 1024 * 1;

        $charset = "\n\t";
        for ($i = 32; $i <= 126; $i++) {
            $charset .= chr($i);
        }

        while($size > 0) {
            $this->_markdown .= substr(str_shuffle($charset), 0, 64);
            $size -= 64;
        }
    }

    public function testPerformance()
    {
        $start = microtime(true);
        \Markdown($this->_markdown);
        $end1 = microtime(true) - $start;

        $start = microtime(true);
        (string) new Text($this->_markdown);
        $end2 = microtime(true) - $start;

        echo PHP_EOL . PHP_EOL;
        echo 'Performance results' . PHP_EOL;
        echo '-------------------' . PHP_EOL;
        printf('Michelf: %.4f', $end1);
        echo PHP_EOL;
        printf('Self:    %.4f', $end2);

        $this->addToAssertionCount(1);
    }
}
