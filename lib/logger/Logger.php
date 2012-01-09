<?php
/**
 * User: HZ
 * Date: 2012.01.10.
 */

class Logger implements ILogger {

    private static $instance;

    private $writers = array();

    public static function getLogger() {
        if (!self::$instance) {
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    protected function __construct() {

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
