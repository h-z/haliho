<?php
/**
 * User: hz
 * Date: 2011.11.13.
 */
 
class Singleton {
  private static $instance;
  private function __construct() {}

  function getInstance() {
    if (!isset(self::$instance )) {
      self::$instance = new static();
      
    }
    return self::$instance;
  }
}
