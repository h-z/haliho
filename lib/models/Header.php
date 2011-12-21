<?php
/**
 * User: hz
 * Date: 2011.11.21.
 */
 
class Header {
  const SCRIPT = 'script';
  const STYLE = 'style';
  const META = 'meta';
  const LINK = 'meta';
  
  private $name;
  private $type;
  private $dependsOn;
  private $body;
  private $hash;
  
  public function __construct($name = "", $type = "", $body = "", $dependencies = array()) {
    $this->name = $name;
    $this->type = $type;
    $this->body = $body;
    $this->dependsOn = $dependencies;
  }

  /**
   * @return string
   */
  public function hashCode() {
    if ($this->hash == null) {
      $this->hash = md5($this->name . $this->type . $this->body);
    }
    return $this->hash;
  }

  public function getDependencies() {
    return $this->dependsOn;
  }

  public function toString() {
    $this->SCRIPT;
    switch ($this->type) {
      case $this->SCRIPT:
        break;


    }
  }
}
