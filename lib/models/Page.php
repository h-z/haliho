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

  private function create() {
    $xml = $this->xmlContent;
    if ($this->loop < $this->maxLoop) {
      $xml0 = $this->parseXml($xml);
      //TODO equals
      if ($xml0 == $xml) {
        $this->xmlContent = $xml0;
        return;
      }
      $this->loop++;
    }
  }

  /**
   * @param DOMDocument $xml
   * @return DOMDocument
   */
  private function parseXml(DOMDocument $xml) {
    $tags = $xml->getElementsByTagName('kms:controller');
    foreach ($tags as $tag) {
      /* @var $tag DOMNode */
      $tag->parentNode->replaceChild($this->getController($tag), $tag);
    }
    return $xml;
  }

  /**
   * @param DOMNode $node
   * @return DOMNode
   */
  public function handle(DOMNode $node) {
    $name = $this->getAttribute('name', $node);
    $method = $this->getAttribute('method', $node);
    if (class_exists($name, true)) {
      if (is_subclass_of($name, 'XmlController')) {
        /* @var $controller XmlController */
        $controller = new $name($node);
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
