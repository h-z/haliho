<?php
  class Configuration extends Singleton {
    private $values;

    private function __construct() {
      $dom = new DOMDocument();
      $dom->load('../configuration/configuration.xml');

    }

    public function get($key) {
      return $this->values[$key];
    }
   
    
  }



?>
