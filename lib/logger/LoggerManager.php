<?php
/**
 * User: HZ
 * Date: 2012.01.10.
 */

class LoggerManager extends Singleton {
    private $xml;

    private $loggers = array();

    protected function __construct() {
        parent::__construct();
        $config = Configuration::getInstance();
        $this->xml = $config->getXML();
        $loggerNodes = $this->xml->getElementsByTagName('logger');
        for($pos=0; $pos < $loggerNodes->length; $pos++) {
            $loggerNode = $loggerNodes->item($pos);
            $class = '';
            foreach ( $loggerNode->attributes as $name => $value ) {
                if ('class' == $name) {
                    $class = $value;
                }
            }
            if ('' != $class) {
                $logger = new $class();
                $level = '';
                $levelNode = $loggerNode->getElementsByTagName('level');
                if ($levelNode->length > 0) {
                    $levelNode = $levelNode->item(0);
                    $level = $levelNode->nodeValue;
                }
                $logger->setLevel($level);
                $writerNodes = $loggerNode->getElementsByTagName('writer');
                for($pos=0; $pos < $writerNodes->length; $pos++) {
                    $writerNode = $writerNodes->item($pos);
                    $class = '';
                    foreach ( $writerNode->attributes as $name => $value ) {
                        if ('class' == $name) {
                            $class = $value;
                        }
                    }
                    if ('' != $class) {
                        $writer = new $class($writerNode);
                        $logger->register($writer);
                    }
                }
            }
        }
    }
}
