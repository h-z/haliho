<?php
/**
 * User: hz
 * Date: 2011.11.16.
 */
 
class XmlController extends Controller {

  protected $xml;
  protected $attribs;
  protected $doc;
  protected $headers;

  /**
   * @param DOMNode $node
   */
  public function __construct(DOMNode $node) {
    parent::__construct();
    $this->doc = $node;
    foreach ($this->doc->attributes as $name => $attr) {
      $this->attribs[$name] = $attr->textContent;
    }
  }

  public function toString() {
    
    return $this->xml;
  }


  /**
   * @param Header $header
   * @return void
   */
  protected function addHeader(Header $header) {
    if (!isset($this->headers[$header->hashCode()])) {
      $this->headers[$header->hashCode()] = $header;
    }
  }

  public function getHeaders() {
    return $this->headers;
  }
}
