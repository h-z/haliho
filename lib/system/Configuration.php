<?php
class Configuration extends Singleton {
    private static $values;
    private $xml;

    public function __construct($opts = array()) {
        if (!empty($opts)) {
            foreach($opts as $k => $v) {
                self::$values[$k] = $v;
            }
        }
        $this->xml = new DOMDocument();
        $this->xml->load(self::$values['rootpath'] . 'configuration/configuration.xml');
        if ($this->xml->documentElement->hasChildNodes()) {
            foreach ($this->xml->documentElement->childNodes as $childNode) {
                if ($childNode->nodeType == XML_ELEMENT_NODE && $childNode->childNodes->length == 1) {
                    self::$values[$childNode->nodeName] = $childNode->nodeValue;
                }
            }
        }
    }

    public function get($key) {
        if (isset(self::$values[$key])) {
            return self::$values[$key];
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
