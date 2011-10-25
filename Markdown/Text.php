<?php

require_once __DIR__ . '/Filter.php';

class Markdown_Text
{
    protected $_source;
    protected $_html;

    public function __construct($source = '')
    {
        $this->setSource($source);
    }

    public function __toString()
    {
        return $this->getHtml();
    }

    public function getSource()
    {
        return $this->_source;
    }

    public function setSource($source)
    {
        $source = (string) $source;

        // do not flush html cache if nothing is changed
        if ($source !== $this->_source) {
            $this->_source = $source;
            $this->_html   = null;
        }

        return $this;
    }

    public function getHtml()
    {
        if ($this->_html === null) {
            $this->_html = Markdown_Filter::run($this->getSource());
        }

        return $this->_html;
    }
}
