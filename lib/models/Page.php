<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class Page implements IHandler {
  private $url;
  private $body;
  private $head;

  public function __construct(URL $url) {
    $this->url = $url;
    $this->body = '';
    $this->head = new Head();
    Core::registerHandle('controller', $this);
  }

  /**
   * @param URL $url
   * @return DOMDocument
   */
  private function getContent(URL $url) {
    return new DOMDocument();
  }

  /**
   * @param DOMNode $node
   * @return DOMNode
   */
  public function handle(DOMNode $node) {
    $class = $this->getAttribute($node, 'class').'Controller';
    $method = $this->getAttribute($node, 'method');
    if (class_exists($class, true)) {
      if (is_subclass_of($class, 'XmlController')) {
        /* @var $controller XmlController */
        $controller = new $class($node);
        if (method_exists($controller, $method)) {
          /* @var $result DOMNode */
          $result = $controller->$method($node);
          foreach ($controller->getHeaders() as $header) {
            $this->head->add($header);
          }
          return $result;
        }
      }
    }
    return new DOMNode();
  }
  
  /**
   * @param string $name
   * @param DOMNode $node
   * @return string
   */
  private function getAttribute(DOMNode $node=null, $name='') {
    $attributes = $node->attributes;
    foreach($attributes as $attr) {
      /* @var $attr DOMAttr */
      if($attr->name == $name) {
        return $attr->value;
      }
    }
    return '';
  }

  
}
