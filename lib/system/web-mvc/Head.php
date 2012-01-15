<?php
/**
 * User: hz
 * Date: 2011.11.21.
 */

class Head {

    private $id;
    private $htmlheads;

    public function __construct($id = '') {

    }

    public function add(HtmlHead $htmlhead) {
        if (!$this->contains($htmlhead)) {
            $this->addHtmlHead($htmlhead);
        }
    }

    /**
     * @param HtmlHead $htmlhead
     * @return boolean
     */
    private function contains(HtmlHead $htmlhead) {
        foreach($this->headers as $h) {
            if ($h->hashCode() == $htmlhead->hashCode()) {
                return true;
            }
        }
        return false;
    }

    private function addHtmlHead(HtmlHead $htmlhead) {
        if (count($htmlhead->getDependencies())) {
            foreach($htmlhead->getDependencies() as $dependency) {
                if ($dependency instanceof HtmlHead) {
                    $this->add($dependency);
                }
            }
        }
        $htmlheads[] = $htmlhead;
    }

    public function toString() {
        $strHtmlHeads = '';
        foreach ($this->headers as $htmlhead) {
            /* @var $htmlhead HtmlHead */
            $strHtmlHeads .= $htmlhead->toString();
        }
        return $strHtmlHeads;
    }
}
