<?php
/**
 * User: HZ
 * Date: 2011.12.11.
 */

class SimpleController extends XmlController {

    public function simple() {
        $my_header = new Header('', Header::SCRIPT, 'alert(1);');
        $this->addHeader($my_header);
    }

    public function m(DOMNode $node) {

        $a = $node->ownerDocument->createDocumentFragment();
        $a->appendXML('<foobar><bar/><foo/></foobar>');
        var_dump($this->db);
        $r = $this->db->query("select * from atable")->fetchAll();
        var_dump($r);
        return $a;
    }
}
