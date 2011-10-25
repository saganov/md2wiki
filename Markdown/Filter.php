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


abstract class Markdown_Filter
{
    protected static $_defaultFilters;

    protected static $_useFallbackFilter = true;

    public static function useFallbackFilter($flag = null)
    {
        if ($flag === null) {
            return self::$_useFallbackFilter;
        }
        else {
            self::$_useFallbackFilter = (bool) $flag;
            return self::$_useFallbackFilter;
        }
    }

    public static function getDefaultFilters()
    {
        if (!is_array(self::$_defaultFilters)) {

            // load default filter set
            require_once __DIR__ . '/Filter/Blockquote.php';
            self::$_defaultFilters[] = new Markdown_Filter_Blockquote();

            require_once __DIR__ . '/Filter/Code.php';
            self::$_defaultFilters[] = new Markdown_Filter_Code();

            require_once __DIR__ . '/Filter/Emphasis.php';
            self::$_defaultFilters[] = new Markdown_Filter_Emphasis();

            require_once __DIR__ . '/Filter/HeaderAtx.php';
            self::$_defaultFilters[] = new Markdown_Filter_HeaderAtx();

            require_once __DIR__ . '/Filter/HeaderSetext.php';
            self::$_defaultFilters[] = new Markdown_Filter_HeaderSetext();

            require_once __DIR__ . '/Filter/Hr.php';
            self::$_defaultFilters[] = new Markdown_Filter_Hr();

            require_once __DIR__ . '/Filter/Img.php';
            self::$_defaultFilters[] = new Markdown_Filter_Img();

            require_once __DIR__ . '/Filter/Linebreak.php';
            self::$_defaultFilters[] = new Markdown_Filter_Linebreak();

            require_once __DIR__ . '/Filter/ListBulleted.php';
            self::$_defaultFilters[] = new Markdown_Filter_ListBulleted();

            require_once __DIR__ . '/Filter/ListNumbered.php';
            self::$_defaultFilters[] = new Markdown_Filter_ListNumbered();

            require_once __DIR__ . '/Filter/Paragraph.php';
            self::$_defaultFilters[] = new Markdown_Filter_Paragraph();
        }

        return self::$_defaultFilters;
    }

    public static function setDefaultFilters(array $filters)
    {
        foreach ($filters as $filter) {
            if (!$filter instanceof self) {
                throw new InvalidArgumentException(
                    'Invalid filter. Must be an instance of ' . __CLASS__
                );
            }
        }

        self::$_defaultFilters = $filters;
    }

    public static function run($text)
    {
        $html = $text;

        $filters = self::getDefaultFilters();

        // fallback filter
        if (self::useFallbackFilter()) {
            require_once __DIR__ . '/Filter/Fallback.php';
            $filters[] = new Markdown_Filter_Fallback();
        }

        foreach($filters as $filter) {
            $html = $filter->transform($html);
        }

        return $html;
    }

    abstract public function transform($text);
}
