<?php
  class Configuration extends Singleton {
    private $values;

    private function __construct() {
      $dom = new DOMDocument();
      $dom->load('../configuration/configuration.xml');
      $c = $dom->getElementsByTagName('configuration')[0];
      if ($c->hasChildNodes) {
        foreach ($c->childNodes as $childNode) {
          $this->values[$childNode->nodeName] = $childNode->nodeValue;
        }
      }
    }

    public function get($key) {
      if (isset($this->values[$key])) {
        return $this->values[$key];
      } else {
        return null;
      }
    }

    public function __get($key) {
      return $this->get($key);
    }
   
    
  }



?>
