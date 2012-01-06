<?php
class Configuration extends Singleton {
    private $values;
    private $xml;

    public function __construct($opts = array()) {
        if (!empty($opts)) {
            foreach($opts as $k => $v) {
                $this->values[$k] = $v;
            }
        }

        $this->xml = new DOMDocument();
        $this->xml->load($this->values['rootpath'] . 'configuration/configuration.xml');
        if ($this->xml->documentElement->hasChildNodes()) {
            foreach ($this->xml->documentElement->childNodes as $childNode) {
                if ($childNode->nodeType == XML_ELEMENT_NODE && $childNode->childNodes->length == 1) {
                    $this->values[$childNode->nodeName] = $childNode->nodeValue;
                }
            }
        }
        var_dump($this->values);
    }

    public function get($key) {
        if (isset($this->values[$key])) {
            return $this->values[$key];
        } else {
            return null;
        }
    }

    public function __get($key) {
        return $this->get($key);
    }

    public function getXML() {
      return $this->xml;
    }
}



?>
