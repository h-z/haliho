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
   * @param string $xml
   */
  public function __construct($xml) {
    parent::__construct();
    $this->xml = $xml;
    $this->doc = new DOMDocument();
    $this->doc->loadXML($this->xml);
    foreach ($this->doc->attributes as $name => $attr) {
      $this->attribs[$name] = $attr->textContent;
    }
  }

  public function toString() {
    
    return $this->xml;
  }
}
