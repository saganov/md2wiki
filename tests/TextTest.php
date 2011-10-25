<?php
require_once __DIR__ . '/../Markdown/Text.php';

class TextTest extends PHPUnit_Framework_TestCase
{
    protected static $_md   = array();
    protected static $_html = array();

    public static function setUpBeforeClass()
    {
        $mds = glob(__DIR__ . '/data/*.md');
        foreach($mds as $filename) {
            $key = basename($filename, '.md');
            self::$_md[$key] = file_get_contents($filename);
        }

        $htmls = glob(__DIR__ . '/data/*.html');
        foreach($htmls as $filename) {
            $key = basename($filename, '.html');
            self::$_html[$key] = file_get_contents($filename);
        }
    }

    public function testConstruct()
    {
        $text = new Markdown_Text(self::$_md['syntax']);
        $this->assertEquals(self::$_md['syntax'], $text->getSource());
    }

    public function testSetGetSource()
    {
        $text = new Markdown_Text();
        $text->setSource(self::$_md['basics']);
        $this->assertEquals(self::$_md['basics'], $text->getSource());
    }

    /**
     * @todo atomic tests for each element (text on input, html on output)
     */
    public function testGetHtml()
    {
        $text = new Markdown_Text(self::$_md['syntax']);
        $this->assertEquals(
            self::$_html['syntax'],
            $text->getHtml(),
            'Resulting html does not match produced by original Markdown.pl 1.0.1'
        );
        $this->assertEquals(
            self::$_html['syntax'],
            (string) $text,
            'Resulting html does not match produced by original Markdown.pl 1.0.1'
        );
    }
}
