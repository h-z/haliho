<?php
class Configuration extends Singleton {
    private static $values;
    private static $dirs;
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
            $dirnode = $this->xml->getElementsByTagName('dirs');
            if ($dirnode->item(0) && $dirnode->item(0)->hasChildNodes()) {
                foreach ($dirnode->item(0)->childNodes as $dirChild) {
                    if ($dirChild->nodeType == XML_ELEMENT_NODE && $dirChild->childNodes->length == 1) {
                        self::$dirs[$dirChild->nodeName] = $dirChild->nodeValue;
                    }
                }
            }

        }
    }

    public function get($key) {
        if (Util::endsWith($key, 'dir')) {
            return self::$values[$key] . '/' . self::$dirs[$key];
        } elseif (isset(self::$values[$key])) {
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
