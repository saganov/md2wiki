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

require_once __DIR__ . '/../../Markdown/Filter/Img.php';

class FilterImgTest extends PHPUnit_Framework_TestCase
{
    public function testCommon()
    {
        $f = new Markdown_Filter_Img();
        $this->assertEquals(
'<img src="/path/to/img.jpg" alt="Alt text" />

<img src="/path/to/img.jpg" title="Optional title" alt="Alt text" />

<img src="/path/to/img.jpg" alt="Alt text" />

<img src="/path/to/img.jpg" title="Optional title" alt="Alt text" />',
        $f->transform(
'![Alt text](/path/to/img.jpg)

![Alt text](/path/to/img.jpg "Optional title")

![Alt text](</path/to/img.jpg>)

![Alt text](</path/to/img.jpg> "Optional title")'
    ),
        'Links, inline style');
    $this->assertEquals(
'<img src="url/to/image" title="Optional title attribute" alt="Alt text" />

<img src="url/to/image" title="Optional title attribute" alt="Alt text" />

![Alt text][id3]

',
        $f->transform(
'![Alt text][id1]

[id1]: url/to/image  "Optional title attribute"

![Alt text][id2]

[id2]: <url/to/image>  "Optional title attribute"

![Alt text][id3]

[id4]: url/to/image  "Optional title attribute"'
    ),
        'Links, reference style');
    }
}