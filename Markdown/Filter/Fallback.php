<?php

class Markdown_Filter_Fallback extends Markdown_Filter
{
    public function transform($text)
    {
        return $text;
    }
}
