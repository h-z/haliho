<?php
/**
 * User: HZ
 * Date: 2012.01.08.
 */

abstract class Query implements IQuery {

    public function fetchAll() {
      $r = array();
      while ($row = $this->row()) {
        $r[] = $row;
      }
      return $r;
    }

    public function fetchAllAssoc() {
      $r = array();
      while ($row = $this->arow()) {
        $r[] = $row;
      }
      return $r;
    }
}
