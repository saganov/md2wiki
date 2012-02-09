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

require_once __DIR__ . '/../../Markdown/Filter/Entities.php';

class FilterEntitiesTest extends PHPUnit_Framework_TestCase
{
    public function testSingles()
    {
        $f = new Markdown_Filter_Entities();
        $this->assertEquals('&amp;', $f->transform('&'));
        $this->assertEquals('&amp;', $f->transform('&amp;'));
        $this->assertEquals('&lt;', $f->transform('<'));
        $this->assertEquals('<head>', $f->transform('<head>'));
    }

    public function testCodeSpan()
    {
        $f = new Markdown_Filter_Entities();
        $this->assertEquals('foo\\`<bar>`', $f->transform('foo\\`<bar>`'));
    }

    public function testCommon()
    {
        $f = new Markdown_Filter_Entities();
        $this->assertEquals(
'Markdown states that symbols &amp; and &lt; must be escaped to ease writing.
However if &amp; is part of html entity like &copy; it must not be escaped.
Similary, if &lt; is part of html tag like <head> it must not be escaped as well.
Inside code spans like this `&lt;html&gt;&lt;head&gt;&lt;/head&gt;&lt;/html&gt;` &lt; is always escaped.
Same rule apply to code blocks like this:

    &lt;html&gt;
        &lt;head&gt;&lt;title&gt;"Markdown"&lt;/title&gt;&lt;/title&gt;&lt;/head&gt;
        &lt;a href="http://example.com?foo=bar&amp;bar=baz"&gt;Link&lt;/a&gt;
	&lt;/html&gt;',
        $f->transform(
'Markdown states that symbols & and < must be escaped to ease writing.
However if & is part of html entity like &copy; it must not be escaped.
Similary, if < is part of html tag like <head> it must not be escaped as well.
Inside code spans like this `<html><head></head></html>` < is always escaped.
Same rule apply to code blocks like this:

    <html>
        <head><title>"Markdown"</title></title></head>
        <a href="http://example.com?foo=bar&bar=baz">Link</a>
	</html>' // intentionally place TAB here, code can be indented with TABs
    ));
    }
}