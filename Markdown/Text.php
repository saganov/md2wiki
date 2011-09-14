<?php

class Markdown_Text
{
    protected $_src;
    protected $_html;
    protected $_filters = array();

    public static function factory($src = null)
    {
        $obj = new self($src);
        $obj->addFilters();

        return $obj;
    }

    public function __contruct($src = null)
    {
        if ($src !== null) {
            $this->setSrc($src);
        }
    }

    public function __toString()
    {
        return $this->_html;
    }

    public function getSrc()
    {
        return $this->_src;
    }

    public function setSrc($src)
    {
        $this->_src = (string) $src;
        return $this;
    }

    public function addFilters($filters = null)
    {
        if ($filters === null) {
            $this->addFilters(Markdown_Filter::all());
        }
        else if (is_array($filters)) {
            foreach ($filters as $filter) {
                $this->addFilters($filter);
            }
        }
        else if ($filters instanceof Markdown_Filter) {
            $this->_filters[get_class($filters)] = $filters;
        }
        else {
            throw new InvalidArgumentException(
                'Filter must be an instance of Markdown_Filter.'
            );
        }

        return $this;
    }
}
