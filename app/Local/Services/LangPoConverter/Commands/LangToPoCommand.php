<?php namespace Local\Services\LangPoConverter\Commands;

use Illuminate\Console\Command;
use Local\Services\LangPoConverter\LangPoConverter;
use Local\Services\LangPoConverter\Parsers\LangParser;
use Local\Services\LangPoConverter\Writers\PoWriter;
use Symfony\Component\Console\Input\InputOption;

class LangToPoCommand extends Command
{

    protected $name = 'local:lang-to-po';

    protected $description = 'Scan a directory recursively for Laravel lang/ directory and generate a formatted PO file';

    protected $converter;

    public function __construct(array $config)
    {
        $this->converter = new LangPoConverter(new LangParser, new PoWriter($config));

        parent::__construct();
    }

    public function fire()
    {
        $path = base_path();

        $this->line('Scan [' . $path . '] directory for lang/ directories');
        
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
                $this->info('Generated files have been placed in [' . $path . DIRECTORY_SEPARATOR . 'i18n]');
            }
        }
        else
        {
            $this->error('No lang files found!');
        }
    }

    protected function getOptions()
    {
        return [
            ['dry-run', null, InputOption::VALUE_NONE, 'Only dump structure, does not generate the PO file', null],
        ];
    }

}
