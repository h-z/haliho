<?php
/**
 * User: HZ
 * Date: 2011.12.11.
 */

class RecursiveController extends WebController {
    public static $count = 0;
    public function o(DOMNode $node) {
        self::$count++;
        if (self::$count < 2) {
            $r = '    <kms:controller class="Recursive" method="o" folder="1" articles="yes" >
                <title><![CDATA[cím]]></title>
                <text><![CDATA[szöveg]]></text>
                </kms:controller>
                ';



            $target = new DOMDocument;
            $target->loadxml('<foo xmlns:myprefix="myprefixUri"></foo>');

            $source = new DOMDocument;
            $source->loadxml($r);

            $fnImportElement = function(DOMDocument $newOwnerDoc, DOMElement $e) {
                return $newOwnerDoc->createElement('kms:'.$e->localName);
            };

            $fnImportAttribute = function(DOMDocument $newOwnerDoc, DOMAttr $a) {
                // could use namespace here, too....
                return $newOwnerDoc->createAttribute($a->name);
            };

            importNS($node->ownerDocument, $source->documentElement, $fnImportElement, $fnImportAttribute);
            echo $node->ownerDocument->savexml();



            $a = $node->ownerDocument->createDocumentFragment();

            $a->appendXML($r);

            return $a;
        }
    }
}
