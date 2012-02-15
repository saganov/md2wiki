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

require_once __DIR__ . '/../../Markdown/Filter/Emphasis.php';

class FilterBlockquoteTest extends PHPUnit_Framework_TestCase
{
    public function testCommon()
    {
        $f = new Markdown_Filter_Emphasis();
        $this->assertEquals(
'This is plain text.

This is <em>empasis</em> word.
Another <em>empasis</em> word.
<em>Whole sentense is emphasis</em>
<em>Even
multiline works!</em>

I can also do <strong>bolded</strong> words.
<strong>Really</strong>, markdown is amazing!

All this can be done with * and _ characters, yes * and _

Just surround word like this \\*word\\* or \\_word\\_ for <em>.
Or \\*\\*word\\*\\* or \\_\\_word\\_\\_ for <strong>
',

        $f->transform(
'This is plain text.

This is *empasis* word.
Another _empasis_ word.
_Whole sentense is emphasis_
_Even
multiline works!_

I can also do **bolded** words.
__Really__, markdown is amazing!

All this can be done with * and _ characters, yes * and _

Just surround word like this \\*word\\* or \\_word\\_ for <em>.
Or \\*\\*word\\*\\* or \\_\\_word\\_\\_ for <strong>
'
    ));

    }
}