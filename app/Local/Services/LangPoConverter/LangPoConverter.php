<?php namespace Local\Services\LangPoConverter;

class LangPoConverter {

    protected $parser;

    protected $writer;

    private $langs;

    public function __construct(ParserInterface $parser, WriterInterface $writer)
    {
        $this->parser = $parser;

        $this->writer = $writer;

        $this->langs = [];
    }

    public function parse($path, $returns = false)
    {
        $this->langs = $this->parser->index($path);

        if ($returns === true)
        {
            return $this->langs;
        }
    }

    public function write($path)
    {
        $this->writer->dump($path, $this->langs);
    }
    
}
