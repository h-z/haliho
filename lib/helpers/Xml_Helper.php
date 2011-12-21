<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HZ
 * Date: 2011.12.10.
 * Time: 17:55
 * To change this template use File | Settings | File Templates.
 */
 
class Xml_Helper {
  public static function equals(DOMDocument $xml1, DOMDocument $xml2) {
        $x1= new DOMDocument;
        $x1->preserveWhiteSpace = FALSE;
        $x1->load($xml1);

        $x2= new DOMDocument;
        $x2->preserveWhiteSpace = FALSE;
        $x2->load($xml2);
    
  }
}
