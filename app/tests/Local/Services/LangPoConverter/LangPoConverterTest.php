<?php namespace Local\Services\LangPoConverter;

use Mockery;
use TestCase;

class LangPoConverterTest extends TestCase {

    protected $parser;

    protected $writer;

    public function setUp()
    {
        parent::setUp();

        $this->parser = Mockery::mock('Local\Services\LangPoConverter\ParserInterface');

        $this->writer = Mockery::mock('Local\Services\LangPoConverter\WriterInterface');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testParserIndexLangs()
    {
        $this->parser->shouldReceive('index')->once()->with('path')->andReturn(true)->mock();

        $converter = new LangPoConverter($this->parser, $this->writer);

        $parsed = $converter->parse('path');
        $this->assertEquals(true, $parsed);
    }

    public function testParserIndexAndReturnsLangs()
    {
        $this->parser->shouldReceive('index')->once()->with('path')->andReturn(['i18n_data'])->mock();

        $converter = new LangPoConverter($this->parser, $this->writer);

        $indexed = $converter->parse('path', true);
        $this->assertEquals(['i18n_data'], $indexed);
    }

    public function testWriterDumpLangs()
    {
        $this->writer->shouldReceive('dump')->once()->mock();

        $converter = new LangPoConverter($this->parser, $this->writer);

        $converter->write('path');
    }

}
