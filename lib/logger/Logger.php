<?php
/**
 * User: HZ
 * Date: 2012.01.10.
 */

class Logger implements ILogger {

    private $writers = array();

    private $level = 0;
    public function __construct() {

    }
    
    public function setLevel($i) {
        $this->level = $i;
    }

    public function register(ILogWriter $writer) {
        $this->writers[] = $writer;
    }

    public function log($msg, $level=null) {
        // TODO: Implement log() method.
    }

    public function info($msg) {
        // TODO: Implement info() method.
    }

    public function warn($msg) {
        // TODO: Implement warn() method.
    }

    public function debug($msg) {
        // TODO: Implement debug() method.
    }

    public function error($msg) {
        // TODO: Implement error() method.
    }
}
