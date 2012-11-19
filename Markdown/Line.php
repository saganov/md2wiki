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

    protected $_line = '';
    protected $_flags = self::NONE;

    public function __construct($line)
    {
        if (strpos($line, "\n") !== false) {
            throw new \InvalidArgumentException('Newline characters in argument.');
        }

        $this->_line = (string) $line;
    }

    public function __toString()
    {
        return $this->_line;
    }

    public function offsetExists($offset)
    {
        return isset($this->_line[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->_line[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->_line[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->_line[$offset]);
    }

    /**
     * Get or set flags.
     *
     * @param int $flags
     */
    public function flags($flags = null)
    {
        if ($flags !== null) {
            if (is_integer($flags)) {
                $this->_flags = $flags;
            }
            else {
                throw new \InvalidArgumentException('Flags must be an integer value.');
            }
        }

        return $this->_flags;
    }
}
