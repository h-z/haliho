<?php 

class Log {

    public static function logit($msg) {
        $manager = LoggerManager::getInstance();
        foreach($manager->getLoggers() as $logger) {
            $logger->log($msg);
        }
    }
}

