<?php
/**
 * User: hz
 * Date: 2011.11.13.
 */

abstract class Singleton {
    protected static $instances;
    protected function __construct($opts = array()) {}

        public static function getInstance($opts = array()) {
            $class = get_called_class();
        if (!isset(self::$instances[$class] )) {
            //$class = get_called_class();
            var_dump($class);
            self::$instances[$class] = new $class($opts);

        }
        return self::$instances[$class];
    }
}
