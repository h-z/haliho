<?php
/**
 * User: HZ
 * Date: 2012.01.03.
 */
class Model {
    protected static $instances = array();

    protected $id;

    public function __construct() {
        $this->store();

    }

    protected function store() {
        self::$instances[$this->id] = &$this;
    }

    protected function load() {

    }

    protected function _generateKey($id) {
        return get_class($this) . '-' . $id;
    }


    public function identify() {

    }

    public static function find($id = 0) {
        if (isset(self::$instances[$id])) {
            return self::$instances[$id];
        }
        return null;
    }


}
