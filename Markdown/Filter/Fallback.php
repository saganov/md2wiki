<?php

/**
 * This filter spawns original Markdown perl script as a subprocess,
 * pass text to its stdin and then return its stdout.
 *
 * This is used as fallback option to make library usable
 * until native PHP support is implemented.
 *
 * Output of this filter is canonical, PHP filters must produce equal output.
 *
 * @package markdown-oo-php
 * @subpackage Filter
 * @author Max Tsepkov <max@garygolden.me> http://www.garygolden.me
 * @link http://daringfireball.net/projects/markdown/
 * @version 0.9
 *
 */
class Markdown_Filter_Fallback extends Markdown_Filter
{
    /**
     * Pass text through original Markdown perl script.
     *
     * @param string $text
     * @return string
     * @throws RuntimeException
     */
    public function transform($text)
    {
        $cmdline = 'perl ' . __DIR__ . '/Fallback/Markdown.pl';
        $child = proc_open(
            $cmdline,
            array(
                0 => array('pipe', 'r'),
                1 => array('pipe', 'w'),
                2 => array('pipe', 'w'),
            ),
            $pipes
        );

        if (is_resource($child)) {
            fwrite($pipes[0], $text);
            fclose($pipes[0]);

            $text = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $err = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            $returnCode = proc_close($child);
            if ($returnCode > 0) {
                throw new RuntimeException(
                    'Child process exited with status ' . $returnCode . PHP_EOL
                    . 'STDERR: ' . $err
                );
            }
        }
        else {
            throw RuntimeException('Could not create process.');
        }

        return $text;
    }
}
