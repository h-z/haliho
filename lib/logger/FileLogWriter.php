<?php
/**
 * User: HZ
 * Date: 2012.01.10.
 */

class FileLogWriter implements ILogWriter {

    private $file;
    public function __construct(DOMNode $node) {
        $config = Configuration::getInstance();

        $this->file = $config->rootpath . Util::attr($node, 'file');
        touch($this->file);
   }

    public function write($msg = '', $level = '') {
        $msg = date('Y-m-d H:i:s') . ' [' . $level . '] ' . $msg. "\n";
        file_put_contents($this->file, $msg, FILE_APPEND);
    }
}
