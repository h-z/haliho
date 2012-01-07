<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class Page implements IHandler {
  private $url;
  private $xmlContent;
  private $body;
  private $head;
  private $loop = 0;
  private $maxLoop = 10;

  public function __construct(URL $url) {
    $this->url = $url;
    $this->body = '';
    $this->head = new Head();
    $this->xmlContent = $this->getContent($this->url);
    Core::registerHandle('controller', $this);
    //$this->create();
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
    $class = $this->getAttribute('class', $node)."Controller";
    $method = $this->getAttribute('method', $node);
    var_dump(array($class, $method));
    if (class_exists($class, true)) {
      var_dump("r");
      if (is_subclass_of($class, 'XmlController')) {
        /* @var $controller XmlController */
        $controller = new $class($node);
        if (method_exists($controller, $method)) {
          /* @var $result DOMNode */
          $result = $controller->$method();
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
  private function getAttribute($name="", DOMNode $node=null) {
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
