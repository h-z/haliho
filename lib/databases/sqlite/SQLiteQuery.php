<?php
/**
 * User: hz
 * Date: 2012.01.05.
 */
 
class SQLiteQuery extends Query {

  private $result;
  private $query;
  private $db;

  public function __construct(IDatabase $db, $query = '', $values = array()) {
    $this->db = $db;
    $this->query = $query;
    $this->result = sqlite_query($db->getConnection(), $this->query);
  }

  public function row() {
    return sqlite_fetch_array($this->result, SQLITE_NUM);
  }

  public function arow() {
    return sqlite_fetch_array($this->result, SQLITE_ASSOC);
  }

  public function count() {
    return sqlite_num_rows($this->result);
  }

  public function free() {
     $this->result = false;
  }
}
