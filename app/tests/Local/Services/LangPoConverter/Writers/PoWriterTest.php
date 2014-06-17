<?php namespace Local\Services\LangPoConverter\Writers;

use File;
use TestCase;

class PoWriterTest extends TestCase {

    protected $writer;

    private $path;

    public function setUp()
    {
        parent::setUp();

        $this->writer = new PoWriter(['name' => 'name', 'email' => 'email']);

        $this->path = __DIR__ . '/stubs';
        File::makeDirectory($this->path, 0777, true);
    }

    public function tearDown()
    {
        File::deleteDirectory($this->path);
    }

    public function testImplementsWriterInterface()
    {
        $this->assertInstanceOf('Local\Services\LangPoConverter\WriterInterface', $this->writer);
    }

    public function testDumpPoFiles()
    {
        $stubs = __DIR__ . '/../stubs/';
        $langs = json_decode(file_get_contents($stubs . 'parsed.json'), true);

        $this->writer->dump($this->path, $langs, '2014-06-17 21:13+0000');

        $this->assertFileExists($this->path . '/i18n/stubs-en_US.po');
        $this->assertFileExists($this->path . '/i18n/stubs-fr_FR.po');
        $this->assertFileEquals($stubs . 'i18n/stubs-en_US.po', $this->path . '/i18n/stubs-en_US.po');
        $this->assertFileEquals($stubs . 'i18n/stubs-fr_FR.po', $this->path . '/i18n/stubs-fr_FR.po');
    }

}
