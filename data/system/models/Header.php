<?php
/**
 * User: hz
 * Date: 2011.11.21.
 */
 
class Header {
  private $name;
  private $value;
  
  public function __construct($header = "", $value = "") {
    if ($header != "") {
      if ($value != "") {
        $this->name = $header;
        $this->value = $value;
      } else {
        
      }
    }
  }

  private function split($str) {
    
  }
}
