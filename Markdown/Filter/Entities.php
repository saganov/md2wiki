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

require_once __DIR__ . '/../Filter.php';

/**
 * This class escapes symbols & and <
 *
 * Rules from Markdown definition:
 *
 *   - Transform & to &amp; and < to &lt;
 *   - do NOT transform if & is part of html entity, e.g. &copy;
 *   - do NOT transform < if it's part of html tag
 *   - ALWAYS transfrom & and < within code spans and blocks
 *
 *
 * @author Max Tsepkov <max@garygolden.me>
 *
 */
class Markdown_Filter_Entities extends Markdown_Filter
{
    public function filter($text)
    {
        // always escape within code blocks and spans
        $text = preg_replace_callback(
            array('/^( {4,}|\t+).*?$/mu',
                  '/(?<!\\\\)`.*?(?<!\\\\)`/u'
            ),
            function ($match) {
                return htmlspecialchars($match[0], ENT_NOQUOTES);
            },
            $text
        );

        // escape & outside of html entity
        $text = preg_replace('/&(?![A-z]+;)/u', '&amp;', $text);

        // escape < outside of html tag
        $text = preg_replace('/<(?![A-z\\/])/u', '&lt;', $text);

        return $text;
    }
}
