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
 * This class removes backslashes (\) before special symbols.
 *
 * This filter is run last, to let other filters be aware of backslashes.
 *
 * @author Max Tsepkov <max@garygolden.me>
 *
 */
class Markdown_Filter_Unescape extends Markdown_Filter
{
    public function transform($text)
    {
        $text = preg_replace(
            '/\\\\([' . preg_quote(implode('', self::$_escapableChars), '/') . '])/',
            '$1',
            $text
        );

        return $text;
    }
}
