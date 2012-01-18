<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HZ
 * Date: 2011.12.10.
 * Time: 17:55
 * To change this template use File | Settings | File Templates.
 */

class XmlHelper {
  public static function equals(DOMDocument $xml1, DOMDocument $xml2) {
    $x1= new DOMDocument;
    $x1->preserveWhiteSpace = FALSE;
    $x1->load($xml1);

    $x2= new DOMDocument;
    $x2->preserveWhiteSpace = FALSE;
    $x2->load($xml2);

  }

  public static function fromMixed($mixed, DOMDocument $doc, DOMElement $domElement = null) {
    $domElement = is_null($domElement) ? $doc : $domElement;
    if (is_array($mixed)) {
      foreach( $mixed as $index => $mixedElement ) {
        if ( is_int($index) ) {
          if ( $index == 0 ) {
            $node = $domElement;
          } else {
            $node = $doc->createElement($domElement->tagName);
            $domElement->parentNode->appendChild($node);
          }
        }
        else {
          $node = $doc->createElement($index);
          $domElement->appendChild($node);
        }
        self::fromMixed($mixedElement, $doc, $node);
      }
    } else {
      $domElement->appendChild($doc->createTextNode($mixed));
    }
  }

  public static function importNS(DOMNode $target, DOMNode $source, $fnImportElement, $fnImportAttribute) {
    switch($source->nodeType) {
      case XML_ELEMENT_NODE:
        // invoke the callback that creates the new DOMElement node
        $newNode = $fnImportElement($target->ownerDocument, $source);
        if ( !is_null($newNode) && !is_null($source->attributes) ) {
          foreach( $source->attributes as $attr) {
            self::importNS($newNode, $attr, $fnImportElement, $fnImportAttribute);
          }
        }
        break;
      case XML_ATTRIBUTE_NODE:
        // invoke the callback that creates the new DOMAttribute node
        $newNode = $fnImportAttribute($target->ownerDocument, $source);
        break;
      default:
        // flat copy
        $newNode = $target->ownerDocument->importNode($source);
    }

    if ( !is_null($newNode) ) {
      // import all child nodes
      if ( !is_null($source->childNodes) ) {
        foreach( $source->childNodes as $c) {
          self::importNS($newNode, $c, $fnImportElement, $fnImportAttribute);
        }
      }
      $target->appendChild($newNode);
    }
  }

}
