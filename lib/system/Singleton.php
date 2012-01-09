<?php
/**
 * User: hz
 * Date: 2011.11.13.
 */

class Singleton {
    protected static $instance;
    protected function __construct($opts = array()) {}

    public static function getInstance($opts = array()) {
        if (!isset(self::$instance )) {
            self::$instance = new static($opts);

        }
        return self::$instance;
    }
}
