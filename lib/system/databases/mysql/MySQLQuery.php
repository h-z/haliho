<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class MySQLQuery implements IQuery {

  private $result;
  private $query;
  private $db;

  function __construct(IDatabase $db, $query = "", $values = array()) {
    $this->db = $db;
    $this->query = $query;
    $this->result = mysql_query($this->query, $db->getConnection());
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
    return mysql_fetch_array($this->result);
  }

  function arow() {
    return mysql_fetch_assoc($this->result);
  }

  function count() {
    return mysql_num_rows($this->result);
  }

  function free() {
    if (is_resource($this->result)) {
      mysql_free_result($this->result);
      $this->result = false;
    }
  }
}
