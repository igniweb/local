<?php namespace Local\Services\LangPoConverter\Writers;

use Local\Services\LangPoConverter\WriterInterface;

class PoWriter implements WriterInterface {

    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function dump($path, array $langs = [])
    {
        if ( ! empty($langs))
        {
            $i18nPath = $path . '/i18n';
            if ( ! is_dir($i18nPath))
            {
                mkdir($i18nPath, 0755, true);
            }

            foreach ($langs as $langIso => $files)
            {
                $content = $this->headers($path, $langIso);
                foreach ($files as $fileId => $fileEntries)
                {
                    foreach ($fileEntries as $key => $val)
                    {
                        $content .= $this->entry($fileId, $key, $val);
                    }
                }

                file_put_contents($i18nPath . '/' . basename($path) . '-' . $langIso . '.po', $content);
            }
        }
    }

    private function headers($path, $langIso)
    {
        $headers[] = 'msgid ""';
        $headers[] = 'msgstr ""';
        $headers[] = '"Project-Id-Version: ' . strtoupper(basename($path)) . '\\n"';
        $headers[] = '"POT-Creation-Date: ' . date('Y-m-d H:iO') . '\\n"';
        $headers[] = '"PO-Revision-Date: ' . date('Y-m-d H:iO') . '\\n"';
        $headers[] = '"Last-Translator: ' . $this->config['name'] . ' <' . $this->config['email'] . '>\\n"';
        $headers[] = '"Language-Team: ' . $this->config['name'] . ' <' . $this->config['email'] . '>\\n"';
        $headers[] = '"Language: ' . $langIso . '\\n"';
        $headers[] = '"MIME-Version: 1.0\\n"';
        $headers[] = '"Content-Type: text/plain; charset=UTF-8\\n"';
        $headers[] = '"Content-Transfer-Encoding: 8bit\\n"';

        return implode("\n", $headers) . "\n\n";
    }

    private function entry($fileId, $key, $val)
    {
        $entry[] = '#: ' . $fileId . ':' . $key;
        $entry[] = 'msgid "' . $val . '"';
        $entry[] = 'msgstr "' . $val . '"';

        return implode("\n", $entry) . "\n\n";
    }

}
