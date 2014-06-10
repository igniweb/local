<?php namespace Local\Services\LangPoConverter\Parsers;

use Local\Services\LangPoConverter\ParserInterface;

class PoParser implements ParserInterface {

    private $path;

    private $langs = [];

    public function index($path)
    {
        $this->path = $path;

        $this->indexDirectory($this->path . '/app');

        if (is_dir($this->path . '/workbench'))
        {
            $this->indexDirectory($this->path . '/workbench');
        }

        return $this->langs;
    }

    private function indexDirectory($path)
    {
        $directories = glob($path . '/*', GLOB_ONLYDIR);
        foreach ($directories as $directory)
        {
            if (basename($directory) === 'lang')
            {
                $this->indexLangDirectory($directory);
            }

            $this->indexDirectory($directory);
        }
    }

    private function indexLangDirectory($path)
    {
        $langDirectories = glob($path . '/*', GLOB_ONLYDIR);
        foreach ($langDirectories as $langDirectory)
        {
            $langIso = $this->getLangIso(basename($langDirectory));
            if ( ! empty($langIso))
            {
                $this->indexLangIsoDirectory($langDirectory, $langIso);
            }
        }
    }

    private function indexLangIsoDirectory($path, $langIso)
    {
        $files = glob($path . '/*.php');
        foreach ($files as $file)
        {
            $lang = include $file;
            if ( ! empty($lang) and is_array($lang))
            {
                $this->langs[$langIso][$this->getFileKey($file)] = array_dot($lang);
            }
        }
    }

    private function getLangIso($lang)
    {
        switch ($lang)
        {
            case 'en':
                $langIso = 'en_US';
                break;
            case 'fr':
                $langIso = 'fr_FR';
                break;
            default:
                $langIso = false;
        }

        return $langIso;
    }

    private function getFileKey($file)
    {
        return str_replace(DIRECTORY_SEPARATOR, '/', substr($file, strlen($this->path)));
    }

}
