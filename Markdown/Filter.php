<?php

abstract class Markdown_Filter
{
    abstract public function filter($text);

    /**
     * Returns all available filter objects.
     *
     * @return array
     */
    public static function all()
    {
        return array();
    }
}