<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class URL {
  const HTTP = 'http';
  const HTTPS = 'https';
  private $path;
  private $domain;
  private $protocol;

  /**
   * @param string $path
   */
  public function __construct($path = "") {
    
  }

  public function toString() {
    $s = '';
    if ($this->protocol) {
      $s .= $this->protocol;
    } else {
      $s .= $this->HTTP;
    }
    return $s;
  }
}
