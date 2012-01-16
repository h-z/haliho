<?php 

class WebView implements IWebView {

    private $headers;
    private $body;
    private $headElements;

    public function __construct() {
       $this->headers = array();
       $this->body = new DOMText('');
       $this->headElements = array();
    }

    public function addBody(DOMNode $node) {
        $this->body = $node;
    }

    public function getBody() {
        return $this->body;
    }

    public function addHeader(Header $header) {
        $this->headers[] = $header;
    }

    public function getHeaders() {
        return $this->headers;
    } 

    public function addHead(HtmlHead $elem) {
        $this->headElements[] = $elem;
    }

    public function getHeadContent() {
        return $this->headElements;
    }

}

