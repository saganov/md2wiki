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
 * Abstract class for all list's types
 *
 * Rules from markdown definition:
 *
 *   *  list items may consist of multiple paragraphs
 *   *  each subsequent paragraph in a list item
 *      must be indented by either 4 spaces or one tab
 *
 * @author Igor Gaponov <jiminy96@gmail.com>
 *
 */
abstract class Markdown_Filter_List extends Markdown_Filter
{
    /**
     * Type of list
     *
     * @var string
     */
    protected $_listType;

    /**
     * Markers for regular expression
     *
     * @var string
     */
    protected $_markers;

    public function transform($text)
    {
        $space = $this->_tabWidth - 1;
        $text = preg_replace_callback(
            sprintf('/(?:(?<=\n)\n|\A\n?)(?P<list>([ ]{0,%1$d}(%2$s)[ \t]+(?!\ *\3\ ))(?:.+?)(\Z|\n{2,}(?=\S)(?![ \t]*%2$s[ \t]+)))/ms',
                $space,
                $this->_markers
            ),
            array($this, 'transformList'), $text);

        return $text;
    }

    /**
     * Takes a signle markdown list
     * and returns its html equivalent.
     *
     * @param array
     * @return string
     */
    protected function transformList($values) {
        $list = $values['list'] . "\n";
        $list = $this->transformListItems($list);

        return sprintf("\n<%1\$s>\n%2\$s</%1\$s>\n\n", $this->_listType, $list);
    }

    /**
     * Process the contents of a single ordered or unordered list,
     * splitting it into individual list items.
     *
     * @param string
     * @return string
     */
    protected function transformListItems($text)
    {
        $text = rtrim($text, "\n") . "\n";
        $text = preg_replace_callback(
            sprintf(
                '/(\n)?(?P<leading_space>^[ \t]*)(?P<marker>%1$s)[ \t]+(?P<item>(?s:.+?))(?=\n*(\Z|\2(%1$s)[ \t]+))/m',
                $this->_markers
            ),
            array($this, 'transformListItem'), $text);

        return $text;
    }

    /**
     * Takes a signle markdown list item
     * and returns its html equivalent.
     *
     * @param array
     * @return string
     */
    protected function transformListItem($values) {
        $item = $values['item'];
        $leadingSpace = $values['leading_space'];
        $markerSpace = $values['marker'];
        $item = $leadingSpace . str_repeat(' ', strlen($markerSpace)) . $item;
        $item = $this->outdent($item);

        return sprintf("<li>%s</li>\n", $item);
    }

}
