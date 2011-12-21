<?php
/**
 * User: hz
 * Date: 2011.11.15.
 */
 
class Factory {

  /**
   * @param int $index
   * @return IDatabase
   */
  public static function getDB($index = 0) {
    $dom = new DOMDocument();
    $dom->load('../configuration/db.xml');
    $dbs = $dom->getElementsByTagName('database');
    $item = $dbs->item($index);
    $_db = null;
    switch(strtolower($item->getElementsByTagName('driver')->item(0)->nodeValue)) {
      case 'mysql':
      default:
       $_db = new MySQL();
    }
    if (!$_db->isConnected()) {
      $configuration = array(
        'host' => $item->getElementsByTagName('host')->item(0)->nodeValue,
        'port' => $item->getElementsByTagName('port')->item(0)->nodeValue,
        'user' => $item->getElementsByTagName('user')->item(0)->nodeValue,
        'password' => $item->getElementsByTagName('password')->item(0)->nodeValue,
        'db' => $item->getElementsByTagName('db')->item(0)->nodeValue
      );
      $_db->config($configuration);
      $_db->connect();
    }
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
