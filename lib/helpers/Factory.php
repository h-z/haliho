<?php
/**
 * User: hz
 * Date: 2011.11.15.
 */

class Factory {

    private static $databases = array();
    /**
     * @param int $index
     * @return IDatabase
     */
    public static function getDB($index = 0) {
        if (isset(self::$databases[$index])) {
            return self::$databases[$index];
        }
        $_db = null;
        $config = new Configuration();
        $dom = $config->getXML();
        $dbs = $dom->getElementsByTagName('database');
        $item = $dbs->item($index);
        switch(strtolower($item->getElementsByTagName('driver')->item(0)->nodeValue)) {
            case 'sqlite':
                $_db = new SQLite();
                break;
            case 'postgresql':
                $_db = new PostgreSQL();
                break;
            case 'mysql':
            default:
                $_db = new MySQL();
                break;
        }
        $_db->configXML($item);
        $_db->connect();
        self::$databases[$index] = $_db;
        return $_db;
    }

    public static function getRequest() {
        return Request::getInstance();
    }

    public static function getSession() {
        return Session::getInstance();
    }

    public static function getResponse() {
        return Response::getInstance();
    }

    public static function getConfiguration() {
        return Configuration::getInstance();
    }

}
