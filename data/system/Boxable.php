<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class Boxable implements IBoxable {

  private $xml;

  function get() {
    
  }

  function __construct($options = array()) {

    if ($options['xml']) {
      $this->xml = $options['xml'];
    }
  }

  function toString() {
    return '';
  }
}
