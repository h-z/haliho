<?php
/**
 * User: HZ
 * Date: 2012.01.10.
 */

class Logger implements ILogger {

    private $writers = array();
    private $levels; // = array('ALL', 'DEBUG', 'INFO', 'WARN', 'ERROR', 'OFF');
    private $level = 0;
    private $defaultLevel = 4;

    public function __construct() {
        $this->levels = LoggerManager::$levels;
    }
    
    public function setLevel($i) {
        $this->level = $i;
    }

    private function getLevel($l) {
        if (is_string($l)) {
            $l = array_search(strtoupper($l), $this->levels); 
        }
        if (is_numeric($l)) {
            if (($l < -1) && ($l >= count($this->levels))) {
                return $l;
            }   
        } 
        return $this->defaultLevel;
    }

    private function write($msg = '', $level = '') {
        $level = $this->levels[$this->getLevel($level)];
        if (!empty($this->writers)) {
            foreach ($this->writers as $writer) {
                $writer->write($msg, $level);
            }
        }
    }

    public function register(ILogWriter $writer) {
        $this->writers[] = $writer;
    }

    public function log($msg='', $level='') {
        if ('' == $level) {
            $level = $this->defaultLevel;
        }
        if ($this->level <= $this->getLevel($level)) {
            $this->write($msg, $level);
        }
    }

    public function info($msg) {
        $this->log($msg, 'INFO');
    }

    public function warn($msg) {
        $this->log($msg, 'WARN');
    }

    public function debug($msg) {
        $this->log($msg, 'DEBUG');
    }
                
    public function error($msg) {
        $this->log($msg, 'ERROR');
    }
}
