<?php
namespace Markdown;

require_once __DIR__ . '/../Markdown/Text.php';

class TextTest extends \PHPUnit_Framework_TestCase
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
        $text = new Text(self::$_md['syntax']);
        $this->assertEquals(self::$_md['syntax'], $text->getSource());
        $this->assertEquals(Filter::getDefaultFilters(), $text->getFilters());

        $filters = array(
            new Filter\Hr(),
            new Filter\Img()
        );
        $text = new Text(self::$_md['syntax'], $filters);
        $this->assertEquals($filters, $text->getFilters());
    }

    public function testSetGetSource()
    {
        $text = new Text(self::$_md['syntax']);
        $this->assertEquals(self::$_md['syntax'], $text->getSource());
        $text->setSource(self::$_md['basics']);
        $this->assertEquals(self::$_md['basics'], $text->getSource());
    }

    public function testSetFilters()
    {
        Filter::useOriginalFilter(false);

        $text = new Text('');

        $filters = array(
            new Filter\Hr(),
            new Filter\Img()
        );
        $text->setFilters($filters);
        $this->assertEquals($filters, $text->getFilters());

        $newFilter = new Filter\Blockquote();
        $text->appendFilter($newFilter);
        $this->assertEquals(array_merge($filters, $newFilter), $text->getFilters());

        $text->setFilters($filters);
        $text->prependFilter($newFilter);
        $this->assertEquals(array_merge($newFilter, $filters), $text->getFilters());
    }

    public function testTransformation()
    {
        $text = new Text(self::$_md['syntax']);
        $this->assertEquals(self::$_md['syntax'], (string) $text);
        $this->assertEquals(self::$_md['syntax'], $text->getHtml());
    }
}
