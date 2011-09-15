<?php
namespace Markdown;

abstract class Filter
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