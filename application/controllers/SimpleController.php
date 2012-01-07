<?php
/**
 * User: HZ
 * Date: 2011.12.11.
 */
 
class SimpleController extends XmlController {

  public function simple() {
    $my_header = new Header('', Header::SCRIPT, 'alert(1);');
    $this->addHeader($my_header);
  }

  public function m(DOMNode $node) {
      $a = new DOMDocument();
      $a->loadXML("<foobar><bar/><foo/></foobar>");

      return $a;
  }
}
