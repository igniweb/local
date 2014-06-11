<?php namespace Local\Services\LangPoConverter\Writers;

use Local\Services\LangPoConverter\WriterInterface;

class LangWriter implements WriterInterface {

    public function dump($path, array $langs = [])
    {
        if ( ! empty($langs))
        {
            foreach ($langs as $files)
            {
                foreach ($files as $filePath => $translations)
                {
                    $content  = "<?php\n\nreturn [\n\n";
                    $content .= $this->dumpArray($translations);
                    $content .= "\n];\n";

                    $filePath = $path . $filePath;
                    $this->writeFile($filePath, $content);
                }
            }
        }
    }

    private function dumpArray($translations, $indent = 1, & $dump = '')
    {
        $keyMaxLen = $this->getKeyMaxLen($translations);

        foreach ($translations as $key => $val)
        {
            $dump .= str_repeat("\t", $indent) . "'" . $key . "'" . str_repeat(" ", $keyMaxLen - strlen($key)) . " => ";
            if (is_array($val))
            {
                $dump .= "[\n";
                $this->dumpArray($val, $indent + 1, $dump);
                $dump .= str_repeat("\t", $indent) . "],\n";
            }
            else
            {
                $dump .= "'" . str_replace("'", "\\'", $val) . "',\n";
            }
        }

        return $dump;
    }

    private function getKeyMaxLen($translations)
    {
        $max = 0;

        foreach ($translations as $key => $val)
        {
            $max = max($max, strlen($key));
        }

        return $max;
    }

    private function writeFile($filePath, $content)
    {
        $fileDir = dirname($filePath);
        if ( ! is_dir($fileDir))
        {
            mkdir(dirname($fileDir), 0755, true);
        }

        file_put_contents($filePath, $content);
    }

}
