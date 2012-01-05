<?php
  class Configuration extends Singleton {
    private $values;

    public function __construct() {
      $dom = new DOMDocument();
      $dom->load('../configuration/configuration.xml');
      if ($dom->documentElement->hasChildNodes()) {
      foreach ($dom->documentElement->childNodes as $childNode) {
          if ($childNode->nodeType == XML_ELEMENT_NODE) {
            $this->values[$childNode->nodeName] = $childNode->nodeValue;
          }
        }
      }
      print_r($this->values);
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
