<?php
/**
 * User: hz
 * Date: 2011.11.21.
 */
 
class Head {

  private $id;
  private $headers;
  
  public function __construct($id = "") {
    
  }

  public function add(Header $header) {
    if (!$this->contains($header)) {
      $this->addHeader($header);
    }
  }

  /**
   * @param Header $header
   * @return boolean
   */
  private function contains(Header $header) {
    foreach($this->headers as $h) {
      if ($h->hashCode() == $header->hashCode()) {
        return true;
      }
    }
    return false;
  }

  private function addHeader(Header $header) {
    if (count($header->getDependencies())) {
      foreach($header->getDependencies() as $dependency) {
        if ($dependency instanceof Header) {
          $this->add($dependency);
        }
      }
    }
    $headers[] = $header;
  }

  public function toString() {
    $strHeaders = '';
    foreach ($this->headers as $header) {
      /* @var $header Header */
      $strHeaders .= $header->toString();
    }
    return $strHeaders;
  }
}
