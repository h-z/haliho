<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class PostgreSQLQuery extends Query {

  private $result;
  private $query;
  private $db;

  public function __construct(IDatabase $db, $query = '', $values = array()) {
    $this->db = $db;
    $this->query = $query;
    $this->result = pg_query($this->query, $db->getConnection());
  }

  public function row() {
    return pg_fetch_array($this->result);
  }

  public function arow() {
    return pg_fetch_assoc($this->result);
  }

  public function count() {
    return pg_num_rows($this->result);
  }

  public function free() {
    if (is_resource($this->result)) {
      pg_free_result($this->result);
      $this->result = false;
    }
  }
}
