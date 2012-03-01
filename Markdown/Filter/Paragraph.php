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
 * Translates paragraphs to <p>
 *
 * Rules from markdown definition:
 *
 *   *  paragraph is simply one or more consecutive lines of text,
 *      separated by one or more blank lines
 *
 * @author Igor Gaponov <jiminy96@gmail.com>
 *
 */
class Markdown_Filter_Paragraph extends Markdown_Filter
{
    protected $_blockTags = 'p|div|h[1-6]|blockquote|pre|table|dl|ol|ul|script|noscript|form|fieldset|iframe|math|ins|del|article|aside|header|hgroup|footer|nav|section|figure|figcaption';

    public function filter($text)
    {
        $text = trim($text, "\n");
        $paragraphs = preg_split(
            sprintf(
                '#\n{2,}|\n*(?=<(%s)>)|(?<=/%s>)\n*#',
                $this->_blockTags,
                str_replace('|', '>|/', $this->_blockTags)
            ),
            $text, -1, PREG_SPLIT_NO_EMPTY);
        $htmlBlocks = array();
        foreach($paragraphs as $paragraph) {
            if(preg_match(sprintf('/\n{2,}|<\/?(%1$s)>/', $this->_blockTags), $paragraph)) {
                $htmlBlocks[] = $paragraph;
            } else {
                $htmlBlocks[] = sprintf("<p>%s</p>", ltrim($paragraph, " \t"));
            }
        }
        $text = implode("\n\n", $htmlBlocks);
        return $text;
    }
}
