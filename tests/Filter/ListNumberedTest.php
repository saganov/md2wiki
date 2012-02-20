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

require_once __DIR__ . '/../../Markdown/Filter/ListNumbered.php';

class FilterListNumberedTest extends PHPUnit_Framework_TestCase
{
    public function testCommon()
    {
        $f = new Markdown_Filter_ListNumbered();
        $this->assertEquals(
'
<ol>
<li>Bird</li>
<li>McHale</li>
<li>Parish</li>

<li>This is a list item with two paragraphs.
Vestibulum enim wisi, viverra nec, fringilla in, laoreet

Suspendisse id sem consectetuer libero luctus adipiscing.</li>

</ol>

Lorem ipsum dolor sit amet, consectetuer adipiscing elit.

<ol>
<li> What a great season.</li>

</ol>

1986\. What a great season.
',
        $f->transform(
'
3. Bird
1. McHale
8. Parish

1.  This is a list item with two paragraphs.
Vestibulum enim wisi, viverra nec, fringilla in, laoreet

  Suspendisse id sem consectetuer libero luctus adipiscing.

Lorem ipsum dolor sit amet, consectetuer adipiscing elit.

1986. What a great season.

1986\. What a great season.
'
    ));
    }
}