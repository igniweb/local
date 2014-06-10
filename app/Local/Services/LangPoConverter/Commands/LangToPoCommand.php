<?php namespace Local\Services\LangPoConverter\Commands;

use Illuminate\Console\Command;
use Local\Services\LangPoConverter\Converters\LangToPoConverter;
use Symfony\Component\Console\Input\InputOption;

class LangToPoCommand extends Command
{

    protected $name = 'local:lang-to-po';

    protected $description = 'Scan a directory recursively for Laravel lang/ directory and generate a formatted PO file';

    protected $converter;

    public function __construct(LangToPoConverter $converter)
    {
        $this->converter = $converter;

        parent::__construct();
    }

    public function fire()
    {
        $path = base_path();

        $this->line('Scan [' . $path . '] directory');
        
        $indexed = $this->converter->parse($path, true);

        if ( ! empty($indexed))
        {
            if ($this->option('dry-run'))
            {
                print_r($indexed);
                echo PHP_EOL;
            }
            else
            {
                $this->converter->write($path, $indexed);
                $this->info('Generated files have been placed in [' . $path . ']');
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
