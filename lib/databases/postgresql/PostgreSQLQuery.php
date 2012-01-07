<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class PostgreSQLQuery implements IQuery {

  private $result;
  private $query;
  private $db;

  function __construct(IDatabase $db, $query = '', $values = array()) {
    $this->db = $db;
    $this->query = $query;
    $this->result = pg_query($this->query, $db->getConnection());
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
    return pg_fetch_array($this->result);
  }

  function arow() {
    return pg_fetch_assoc($this->result);
  }

  function count() {
    return pg_num_rows($this->result);
  }

  function free() {
    if (is_resource($this->result)) {
      pg_free_result($this->result);
      $this->result = false;
    }
  }
}
