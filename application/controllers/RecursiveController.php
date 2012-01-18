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
            $a = $node->ownerDocument->createDocumentFragment();
            $a->appendXML($r);

            return $a;
        }
    }
}
