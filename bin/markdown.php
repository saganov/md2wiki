#!/usr/bin/env php
<?php

require_once __DIR__ . '/../Markdown/Text.php';
require_once __DIR__ . '/../Markdown/Filter.php';

use \Markdown\Filter;

echo Filter::run(stream_get_contents(STDIN));
echo PHP_EOL;
