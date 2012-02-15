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

require_once __DIR__ . '/../../Markdown/Filter/Code.php';

class FilterCodeTest extends PHPUnit_Framework_TestCase
{
    public function testCommon()
    {
        $f = new Markdown_Filter_Code();
        $this->assertEquals(
' This text is not code.

<pre><code>start code

    indent code //comment
        indent more

# foo bar
* list

&lt;div class="footer"&gt;
    &amp;copy; 2012 Foo Corporation
&lt;/div&gt;

end code
</code></pre>

  not code',
        $f->transform(
' This text is not code.

    start code

        indent code //comment
            indent more

    # foo bar
    * list

    <div class="footer">
        &copy; 2012 Foo Corporation
    </div>

    end code

  not code'
    ));
    }
}