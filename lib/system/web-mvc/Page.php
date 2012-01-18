<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */

class Page implements IHandler {
    private $url;
    private $body;
    private $head;
    private $headers;

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
            if (is_subclass_of($class, 'WebController')) {
                /* @var $controller XmlController */
                $controller = new $class($node);
                if (method_exists($controller, $method)) {
                    /* @var $result IView*/
                    $result = $controller->$method($node);
                    return $this->processResult($result);
                }
            }
        }
        return new DOMText('');
    }

    private function processResult($result) {
        $node = new DOMText('');
        if (is_string($result)) {
            $node = new DOMText($result);
        }
        if (is_array($result)) {
           $node = XmlHelper::fromMixed($result, new DOMDocument()); 
        }
        if ($result instanceof DOMNode) {
            $node = $result;
        }
        if ($result instanceof IWebView) {
            $node = $result->getBody();
            foreach ($result->getHeaders() as $header) {
                $this->addHeader($header);
            }
            foreach ($result->getHeadContent() as $head) {
                $this->addHead($head);
            }
        }
        return $node;
    }


    private function addHeader(Header $header) {
        $this->headers[$header]->$header;
    }

    private function addHead(HtmlHead $head) {
        $this->head->add($head);
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
