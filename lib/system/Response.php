<?php
/**
 * User: hz
 * Date: 2011.11.21.
 */

class Response extends Singleton {

    private $head;
    private $body;
    private $headers;
    private $cookies;
    
    protected function __construct($opts = array()) {
        parent::__construct($opts);
    }

    function head() {

    }


}
