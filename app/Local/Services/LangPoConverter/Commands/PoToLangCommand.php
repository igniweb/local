<?php namespace Local\Services\LangPoConverter\Commands;

use Illuminate\Console\Command;
use Local\Services\LangPoConverter\LangPoConverter;
use Local\Services\LangPoConverter\Parsers\PoParser;
use Local\Services\LangPoConverter\Writers\LangWriter;
use Symfony\Component\Console\Input\InputOption;

class PoToLangCommand extends Command {

    protected $name = 'local:po-to-lang';

    protected $description = 'Scan PO files to match translations and build Laravel lang/ directories accordingly';

    protected $converter;

    public function __construct()
    {
        $this->converter = new LangPoConverter(new PoParser, new LangWriter);

        parent::__construct();
    }

    public function fire()
    {
        $path = base_path();

        $this->line('Scan [' . $path . DIRECTORY_SEPARATOR . 'i18n] directory for PO files');

        $langs = $this->converter->parse($path, true);

        if ( ! empty($langs))
        {
            if ($this->option('dry-run'))
            {
                print_r($langs);
            }
            else
            {
                $this->converter->write($path, $langs);
                $this->info('Generated files have been placed accordingly from base [' . $path . ']');
            }
        }
        else
        {
            $this->error('No PO files found!');
        }
    }

    protected function getOptions()
    {
        return [
            ['dry-run', null, InputOption::VALUE_NONE, 'Only dump structure, does not generate the lang file structure', null],
        ];
    }

}
