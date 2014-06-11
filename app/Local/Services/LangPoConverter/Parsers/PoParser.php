<?php namespace Local\Services\LangPoConverter\Parsers;

use Exception;
use Local\Services\LangPoConverter\ParserInterface;

class PoParser implements ParserInterface {

    private $langs = [];

    public function index($path)
    {
        $this->indexDirectory($path);

        return $this->langs;
    }

    private function indexDirectory($path)
    {
        $files = glob($path . '/*.po');
        foreach ($files as $file)
        {
            $lang = $this->getLangFromFilename(basename($file));
            if (empty($lang))
            {
                throw new Exception('Unable to guess lang from filename [' . $file . ']');
            }

            $this->indexFile($file, $lang);
        }
    }

    private function getLangFromFilename($filename)
    {   // laravel-en_US.po
        $dots = explode('.', $filename);
        if (count($dots) == 2)
        {   // laravel-en_US
            $dashs = explode('-', $dots[0]);
            if (count($dashs) == 2)
            {   // en_US
                $unders = explode('_', $dashs[1]);
                if (count($unders) == 2)
                {   // en
                    return $unders[0];
                }
            }
        }

        return false;
    }

    private function indexFile($file, $lang)
    {
        $entries      = explode("\n#: ", str_replace("\r\n", "\n", file_get_contents($file)));
        $countEntries = count($entries);
        if ($countEntries > 0)
        {   // Skip header
            for ($i = 1 ; $i < $countEntries ; $i++)
            {
                $this->indexEntry($entries[$i], $lang);
            }
        }
    }

    private function indexEntry($entry, $lang)
    {
        $lines = explode("\n", $entry);
        if (count($lines) == 4)
        {   // /path/to/file:key
            $dots = explode(":", $lines[0]);
            if (count($dots) != 2)
            {
                throw new Exception('Entry does not contains filename:key couple [' . $lines[0] . ']');
            }

            // msgstr "..."
            $translation = substr($lines[2], 8, -1);

            array_set($this->langs[$lang][$dots[0]], $dots[1], $translation);
        }
    }

}
