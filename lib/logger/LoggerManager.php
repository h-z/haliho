<?php
/**
 * User: HZ
 * Date: 2012.01.10.
 */

class LoggerManager extends Singleton {
    private $xml;

    private static $loggers = array();

    protected function __construct() {
        parent::__construct();
        $config = Configuration::getInstance();
        $this->xml = $config->getXML();
        $loggerNodes = $this->xml->getElementsByTagName('logger');
        for($i=0; $i < $loggerNodes->length; $i++) {
            $loggerNode = $loggerNodes->item($i);
            $class = '';
            foreach ( $loggerNode->attributes as $name => $value ) {
                if ('class' == $name) {
                    $class = $value->nodeValue;
                }
            }
            if ('' != $class) {
                //var_dump($class);
                $logger = new $class();
                $level = '';
                $levelNode = $loggerNode->getElementsByTagName('level');
                if ($levelNode->length > 0) {
                    $levelNode = $levelNode->item(0);
                    $level = $levelNode->nodeValue;
                }
                $logger->setLevel($level);
                $writerNodes = $loggerNode->getElementsByTagName('writer');
                for($j=0; $j < $writerNodes->length; $j++) {
                    $writerNode = $writerNodes->item($j);
                    $class = '';
                    foreach ( $writerNode->attributes as $name => $value ) {
                        if ('class' == $name) {
                            $class = $value->nodeValue;
                        }
                    }
                    if ('' != $class) {
                        if (!Util::endsWith($class, 'LogWriter')) {
                            $class .= 'LogWriter';
                        }
                        $writer = new $class($writerNode);
                        $logger->register($writer);
                    }
                }
                self::$loggers[] = $logger;
            }
        }
    }

    public static function getLoggers() {
        return self::$loggers;
    }

    public static function getLogger() {
        return self::$loggers[0];
    }
}
