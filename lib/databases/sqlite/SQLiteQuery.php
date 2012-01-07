<?php
/**
 * User: hz
 * Date: 2012.01.05.
 */
 
class SQLiteQuery implements IQuery {

  private $result;
  private $query;
  private $db;

  function __construct(IDatabase $db, $query = '', $values = array()) {
    $this->db = $db;
    $this->query = $query;
    $this->result = sqlite_query($db->getConnection(), $this->query);
  }

  function fetchAll() {
    $r = array();
    while ($row = $this->row()) {
      $r[] = $row;
    }
    return $r;
  }

  function fetchAllAssoc() {
    $r = array();
    while ($row = $this->arow()) {
      $r[] = $row;
    }
    return $r;
  }

  function row() {
    return sqlite_fetch_array($this->result, SQLITE_NUM);
  }

  function arow() {
    return sqlite_fetch_array($this->result, SQLITE_ASSOC);
  }

  function count() {
    return sqlite_num_rows($this->result);
  }

  function free() {
     $this->result = false;
  }
}
