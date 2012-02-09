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
 * Translates email-style blockquotes to <blockquote>
 *
 * Rules from markdown definition:
 *
 *   *  blockquote is indicated by < at the start of line
 *   *  blockquotes can be nested
 *   *  lazy blockquotes are allowed
 *
 * Blockquote ends with \n\n
 *
 * @author Max Tsepkov <max@garygolden.me>
 *
 */
class Markdown_Filter_Blockquote extends Markdown_Filter
{
    public function transform($text)
    {
        foreach($this->searchQuotes($text) as $quote)
        {
            $text = str_replace($quote, $this->transformQuote($quote), $text);
        }

        return $text;
    }

    /**
     * Search markdown for quotes and returns it untouched.
     *
     * @param array $quotes
     */
    protected function searchQuotes($text)
    {
        $quotes = array();

        $inQuote = false;
        $len = strlen($text);
        for ($pos = 0; $pos < $len; $pos++) {
            if (!$inQuote) {
                if ($text[$pos] == '>' && ($pos == 0 || $text[$pos-1] == "\n")) {
                    $inQuote  = true;
                    $quotes[] = '';
                    $quote    =& $quotes[count($quotes) - 1];
                }
            }

            if ($inQuote) {
                if ($text[$pos] == "\n" && $text[$pos-1] == "\n") {
                    $inQuote = false;
                }
                else {
                    $quote .= $text[$pos];
                }
            }
        }

        return $quotes;
    }

    /**
     * Recursive function takes a signle markdown quote
     * and returns its html equivalent.
     *
     * @param string
     * @return string
     */
    protected function transformQuote($text)
    {
        $text = preg_replace('/^\s*>\s*/m', '', $text);

        foreach ($this->searchQuotes($text) as $quote) {
            $text = str_replace($quote, $this->transformQuote($quote), $text);
        }

        return "<blockquote>\n" . $text . "</blockquote>\n";
    }
}
