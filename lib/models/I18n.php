<?php

class I18n implements IHandler {

  public function __construct() {
    //$this->xmlContent = $this->getContent($this->url);
    Core::registerHandle('kms:i18n', $this);
    //$this->create();
  }

  public static function handle(DOMNode $node) {

  }

 
}
