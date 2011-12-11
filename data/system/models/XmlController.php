<?php
/**
 * User: hz
 * Date: 2011.11.16.
 */
 
class XmlController extends Controller {

  /*
   call_user_func_array(array($foo, "bar"), array("three", "four"));
   */

  protected $xml;
  protected $attribs;
  protected $doc;

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


  function getHeaders() {
    // TODO: Implement getHeaders() method.
  }
}
