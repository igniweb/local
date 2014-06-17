<?php namespace Local\Services\LangPoConverter\Parsers;

use TestCase;

class LangParserTest extends TestCase {

    protected $parser;

    public function setUp()
    {
        parent::setUp();

        $this->parser = new LangParser;
    }

    public function testImplementsParserInterface()
    {
        $this->assertInstanceOf('Local\Services\LangPoConverter\ParserInterface', $this->parser);
    }

    public function testIndexLangFiles()
    {
        $langs = $this->parser->index(__DIR__ . '/../stubs');
        $index = json_decode(file_get_contents(__DIR__ . '/../stubs/parsed.json'), true);

        $this->assertEquals($langs, $index);
    }

}
