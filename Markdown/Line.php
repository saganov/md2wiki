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

/**
 * Text consist of lines. This is a line.
 *
 * @package Markdown
 * @subpackage Text
 * @author Max Tsepkov <max@garygolden.me>
 * @version 1.0
 */
class Line implements \ArrayAccess
{
    const NONE        = 0;
    const NOMARKDOWN  = 1;
    const CODEBLOCK   = 2;
    const LISTS       = 4;

    public $flags = self::NONE;

    protected $_text = '';

    public function __construct($text = null)
    {
        if ($text !== null) {
            $this->setText($text);
        }
    }

    public function __toString()
    {
        return $this->_text;
    }

    public function setText($text)
    {
        if (strpos($text, "\n") !== false) {
            throw new \InvalidArgumentException('Newline characters in argument.');
        }

        $this->_text = (string) $text;

        return $this;
    }

    public function append($text)
    {
        $this->_text .= $text;
        return $this;
    }

    public function prepend($text)
    {
        $this->_text = $text . $this->_text;
        return $this;
    }

    public function decorate($tag)
    {
        $this->prepend("<$tag>");
        $this->append("</$tag>");
        return $this;
    }

    public function outdent()
    {
        $this->_text = preg_replace('/^(\t| {1,4})/uS', '', $this->_text);
        return $this;
    }

    public function isIndented()
    {
        if (isset($this->_text[0]) && $this->_text[0] == "\t") {
            return true;
        }
        if (substr($this->_text, 0, 4) == '    ') {
            return true;
        }
        else {
            return false;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->_text[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->_text[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->_text[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->_text[$offset]);
    }
}
