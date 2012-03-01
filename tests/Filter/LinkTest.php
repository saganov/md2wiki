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

require_once __DIR__ . '/../../Markdown/Filter/Link.php';

class FilterLinkTest extends PHPUnit_Framework_TestCase
{
    public function testCommon()
    {
        $f = new Markdown_Filter_Link();
        $this->assertEquals(
'This is <a href="http://example.com/" title="Title">an example</a> inline link.

<a href="http://example.net/">This link</a> has no title attribute.

See my <a href="/about/">About</a> page for details.

<a href="/nested/">Nested [brackets]</a>',
        $f->transform(
'This is [an example](http://example.com/ "Title") inline link.

[This link](http://example.net/) has no title attribute.

See my [About](/about/) page for details.

[Nested [brackets]](/nested/)'
    ),
        'Links, inline style');
    $this->assertEquals(
'This is <a href="http://example.com/" title="Optional Title Here">an example</a> reference-style link.

This is <a href="http://example.com/" title="Optional Title Here">an example</a> reference-style link.

<a href="http://example.com/" title="Optional Title Here">link [text]</a>
<a href="http://example.com/" title="Optional Title Here">![img][] text</a>
<a href="http://example.com/" title="Optional Title Here">foo3</a>

<a href="http://example.com/" title="Optional Title Here">Example1</a>
<a href="http://example.com/longish/path/to/resource/here" title="Optional Title Here">Example2</a>
<a href="http://google.com/" title="Google">Google</a>

Visit <a href="http://daringfireball.net/">Daring Fireball</a> for more information.

I get 10 times more traffic from <a href="http://google.com/" title="Google">Google</a> than from
<a href="http://search.yahoo.com/" title="Yahoo Search">Yahoo</a> or <a href="http://search.msn.com/" title="MSN Search">MSN</a>.

I get 10 times more traffic from <a href="http://google.com/" title="Google">Google</a> than from
<a href="http://search.yahoo.com/" title="Yahoo Search">Yahoo</a> or <a href="http://search.msn.com/" title="MSN Search">MSN</a>.

[Bing][]

',
        $f->transform(
'This is [an example][id] reference-style link.

This is [an example] [id] reference-style link.

[id]: http://example.com/  "Optional Title Here"

[link [text]][Foo1]
[![img][] text][foo2]
[foo3][]

[foo1]: http://example.com/  "Optional Title Here"
[Foo2]: http://example.com/  \'Optional Title Here\'
[fOO3]: http://example.com/  (Optional Title Here)

[Example1][angle brackets]
[angle brackets]: <http://example.com/>  "Optional Title Here"

[Example2][Next Line]
[next line]: http://example.com/longish/path/to/resource/here
    "Optional Title Here"

[Google][]

[Google]: http://google.com/

Visit [Daring Fireball][] for more information.

[Daring Fireball]: http://daringfireball.net/

I get 10 times more traffic from [Google] [1] than from
[Yahoo] [2] or [MSN] [3].

  [1]: http://google.com/        "Google"
  [2]: http://search.yahoo.com/  "Yahoo Search"
  [3]: http://search.msn.com/    "MSN Search"

I get 10 times more traffic from [Google][] than from
[Yahoo][] or [MSN][].

  [google]: http://google.com/        "Google"
  [yahoo]:  http://search.yahoo.com/  "Yahoo Search"
  [msn]:    http://search.msn.com/    "MSN Search"

[Bing][]

[duckduckgo]: duckduckgo.com "DuckDuckGo"'
    ),
        'Links, reference style');
    }
}