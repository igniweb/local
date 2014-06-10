<?php namespace Local\Services\LangPoConverter\Converters;

use Local\Services\LangPoConverter\Converters\Parsers\LangParser;
use Local\Services\LangPoConverter\Converters\Writers\PoWriter;

class LangToPoConverter {

    protected $parser;

    protected $writer;

    private $langs;

    public function __construct(LangParser $parser, PoWriter $writer)
    {
        $this->parser = $parser;

        $this->writer = $writer;

        $this->langs = [];
    }

    public function parse($path = false, $returns = false)
    {
        $path = $this->path($path);

        $this->langs = $this->parser->index($path);

        if ($returns === true)
        {
            return $this->langs;
        }
    }

    public function write($path = false)
    {
        $path = $this->path($path);

        $this->writer->dump($path, $this->langs);
    }

    private function path($path)
    {
        return ! empty($path) ? $path : base_path();
    }
    
}
