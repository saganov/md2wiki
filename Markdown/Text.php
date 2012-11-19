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

namespace Markdown;

require_once __DIR__ . '/Filter.php';

/**
 * Represents a piece of text.
 *
 * @package Markdown
 * @subpackage Text
 * @author Max Tsepkov <max@garygolden.me>
 * @version 1.0
 */
class Text extends \ArrayObject
{
    const NONE        = 0;
    const NOMARKDOWN  = 1;
    const CODEBLOCK   = 2;
    const LISTS       = 4;

    /**
     * Flag indicating that object has been passed through filters.
     *
     * @var bool
     */
    protected $_isFiltered = false;

    protected static $_defaultFilters = null;

    protected static $_factoryDefaultFilters = array(
        'Hr',
        'ListBulleted',
        'ListNumbered',
        'Blockquote',
        'Code',
        'Emphasis',
        'Entities',
        'HeaderAtx',
        'HeaderSetext',
        'Img',
        'Linebreak',
        'Link',
        'Paragraph',
        'Unescape'
    );

    /**
     * Array of custom filters.
     * Default filters is used if not set.
     *
     * @var array
     */
    protected $_filters = array();

    /**
     * Array of flags for each line of text.
     * Number of lines as keys, flags as values.
     * If a line has no entry in this array, then no flags was set.
     *
     * @var array
     */
    protected $_lineflags = array();

    /**
     *
     * @param array|string $markdown
     */
    public function __construct($markdown, array $filters = null)
    {
        if (is_string($markdown) || method_exists($markdown, '__toString')) {
            $markdown = explode("\n", (string) $markdown);
            $markdown = array_map(function($markdown) { return trim($markdown, "\r"); }, $markdown);
        }
        if (is_array($markdown)) {
            parent::__construct($markdown);
        }
        else {
            throw new \InvalidArgumentException('Text constructor expects array, string or stringable object.');
        }

        if ($filters !== null) {
            $this->setFilters($filters);
        }
        else {
            $this->setFilters(self::getDefaultFilters());
        }
    }

    public function __toString()
    {
        return $this->getHtml();
    }

    public function getHtml()
    {
        if (!$this->_isFiltered) {
            foreach ($this->_filters as $filter) {
                $filter->preFilter($this);
            }

            foreach ($this->_filters as $filter) {
                $filter->filter($this);
            }

            foreach ($this->_filters as $filter) {
                $filter->postFilter($this);
            }

            $this->_isFiltered = true;
        }

        return implode("\n", (array) $this);
    }

    public function getFilters()
    {
        return $this->_filters;
    }

    /**
     * Define filters for this Text instance.
     *
     * Each filter may be defined either as a string or as a Filter instance.
     * If filter is a string, corresponding class will be attempted to autoload.
     *
     * Returns filters array with all members instantiated.
     *
     * @param array $filters
     * @throws \InvalidArgumentException
     * @return array
     */
    public function setFilters(array $filters)
    {
        $this->_filters = array();

        foreach ($filters as $key => $filter) {
            if (is_string($filter) && ctype_alnum($filter)) {
                $classname = __NAMESPACE__ . '\\Filter_'   . $filter;
                $classfile = __DIR__ . '/Filter/' . $filter . '.php';
                if (!class_exists($classname) && is_readable($classfile)) {
                    require_once $classfile;
                }

                $filter = new $classname;
            }

            if (!$filter instanceof Filter) {
                throw new \InvalidArgumentException(
                    '$filters must be an array which elements ' .
                    'are either an alphanumeric string or a Filter instance'
                );
            }

            $this->_filters[$key] = $filter;
        }

        return $this->_filters;
    }

    /**
     * Get or set flags for line number $no.
     *
     * @param int $no
     * @param int $flags
     */
    public function lineflags($no, $flags = null)
    {
        if ($flags !== null) {
            if (is_integer($flags)) {
                $this->_lineflags[$no] = $flags;
            }
            else {
                throw new \InvalidArgumentException('Flags must be an integer value.');
            }
        }

        return isset($this->_lineflags[$no]) ? $this->_lineflags[$no] : self::NONE;
    }

    public static function getFactoryDefaultFilters()
    {
        return self::$_factoryDefaultFilters;
    }

    /**
     * @return array
     */
    public static function getDefaultFilters()
    {
        if (!self::$_defaultFilters) {
            self::$_defaultFilters = self::getFactoryDefaultFilters();
        }

        return self::$_defaultFilters;
    }

    /**
     * @param array $filters
     * @return Filter
     */
    public static function setDefaultFilters(array $filters)
    {
        self::$_defaultFilters = $filters;
    }
}
