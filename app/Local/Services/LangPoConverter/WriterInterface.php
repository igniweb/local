<?php namespace Local\Services\LangPoConverter;

interface WriterInterface {

    public function dump($path, array $langs);

}
