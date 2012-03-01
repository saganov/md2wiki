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
 * Translates atx-style headers to <h#>
 *
 * Rules from markdown definition:
 *
 *   *  use 1-6 hash characters at the start of the line
 *   *  number of opening hashes determines the header level
 *   *  closing hashes don’t even need to match the number of hashes used to open
 *
 * @author Igor Gaponov <jiminy96@gmail.com>
 *
 */
class Markdown_Filter_HeaderAtx extends Markdown_Filter
{
    public function filter($text)
    {
        $text = preg_replace_callback('/^(?P<level>\#{1,6})[ \t]*(?P<text>.+?)[ \t]*\#*\n+/m',
            array($this, 'transformHeaderAtx'), $text);
        return $text;
    }

    /**
     * Takes a signle markdown header
     * and returns its html equivalent.
     *
     * @param array
     * @return string
     */
    protected function transformHeaderAtx($values)
    {
        $level = min(strlen($values['level']), 6);
        return sprintf("<h%1\$d>%2\$s</h%1\$d>\n\n", $level, $values['text']);
    }
}
