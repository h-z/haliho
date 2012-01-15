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
        return new DOMNode();
    }

    private function processResult($result) {
        $node = new DOMNode();
        if (is_string($result)) {
            $node = new DOMText($result);
        }
        if ($result instanceof DOMNODE) {
            $node = $result;
        }
        if ($result instanceof IWebView) {
            $node = $result->getBody();
            foreach ($result->getHeaders() as $header) {
                $this->addHeader($header);
            }
            foreach ($result->getHeadElements() as $head) {
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
     * @param DOMNode $node
     * @return DOMNode
     */
    public function oldhandle(DOMNode $node) {
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
