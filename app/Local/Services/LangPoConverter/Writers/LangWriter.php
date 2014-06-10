<?php namespace Local\Services\LangPoConverter\Writers;

use Local\Services\LangPoConverter\WriterInterface;

class LangWriter implements WriterInterface {

    protected $config;

    public function dump($path, $langs = [])
    {
        if ( ! empty($langs))
        {
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
                file_put_contents($path . '/laravel-' . $langIso . '.po', $content);
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
