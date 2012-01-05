<?php

class I18n {

  public function __construct() {
    //$this->xmlContent = $this->getContent($this->url);
    Core::registerHandle('kms:i18n', array($this, 'getTranslation'));
    //$this->create();
  }

  public static function getTranslation(DOMNode $node) {

  }

 
}
