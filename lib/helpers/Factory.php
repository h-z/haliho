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
        //$dom = new DOMDocument();
        $dom = (new Configuration())->getXML();
        $availableConfigs = array('host', 'port', 'user', 'password', 'db', 'filename');
        //$dom->load('../../configuration/db.xml');
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
        if (!$_db->isConnected()) {
            $configuration = array();
            foreach ($availableConfigs as $conf) {
                $items = $item->getElementsByTagName($conf);
                if ($items->length > 0) {
                    $configuration[$conf] = $items->item(0)->nodeValue;
                }
            }
            $_db->config($configuration);
            $_db->connect();
        }
        self::$databases[$index] = $_db;
        return $_db;
    }

    public static function getRequest() {
        return new Request();
    }

    public static function getSession() {
        return new Session();
    }

    public static function getResponse() {
        return new Response();
    }

}
