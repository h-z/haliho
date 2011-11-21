<?php
/**
 * User: hz
 * Date: 2011.11.15.
 */
 
abstract class Controller implements IController {

  protected $db;
  protected $sn;
  protected $rq;

  function __construct() {
    $this->db = Factory::getDB();
    $this->sn = Factory::getSession();
    $this->rq = Factory::getRequest();
  }


}
