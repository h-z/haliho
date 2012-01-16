<?php
/**
 * User: HZ
 * Date: 2011.12.11.
 */

class SimpleController extends WebController {
    private $logger; // = LoggerManager::getLogger();


    public function __construct(DOMNode $node) {
        parent::__construct($node);
        $this->logger = LoggerManager::getLogger();
    }


    public function simple() {
        $my_header = new Header('', Header::SCRIPT, 'alert(1);');
        $this->addHeader($my_header);
    }

    public function m(DOMNode $node) {
        //$this->logger->info('eee');
 //       Log::logit('heloka');
        $a = $node->ownerDocument->createDocumentFragment();
        $a->appendXML('<foobar><bar/><foo/></foobar>');
        $r = $this->db->query("select * from atable")->fetchAllAssoc();
        foreach($r as $row) {
            foreach($row as $k => $v) {
                $a->appendChild($node->ownerDocument->createElement($k, $v));

            }

        }
        return $a;
    }

    public function n(DOMNode $node) {
 //       var_dump('only text');
        return 'only text';
    }

    public function o(DOMNode $node) {
        return '<rr></rr>';
    }
}
