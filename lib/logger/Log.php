<?php 

class Log {

    public static function logit($msg) {
        $manager = LoggerManager::getInstance();
        $manager->getLogger()->log($msg);
    }
}

