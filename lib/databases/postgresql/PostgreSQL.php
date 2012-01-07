<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class PostgreSQL implements IDatabase {
  
  private $lastquery;
  private $connnection;
  private $host;
  private $port;
  private $user;
  private $password;
  private $db;
  private $querycount = 0;
  private $bindmarker = '?';

  function config($options = array()) {
    if (is_array($options))	{
			foreach ($options as $key => $val) {
				$this->$key = $val;
			}
		}
  }


  function connect() {
	  if ($this->port != '') {
			$this->host .= ':'.$this->port;
		}
		$this->connnection = @pg_connect('host='.$this->host.' port='.$this->port.' dbname='.$this->db.' user='.$this->user.' password='.$this->password);
    return $this->connnection;
  }

  function isConnected() {
    return $this->connnection != null;
  }

  function close() {
    return @pg_close($this->connnection);
  }

  function lastQuery() {
    return $this->lastquery;
  }

  function esc($str) {
    $str =  str_replace("'", "''", $str);
		$str =  str_replace("\''", "\'", $str);
		return $str;
  }

  function query($query = '', $values = array()) {
    $q = new PostgreSQLQuery($this, $query, $values);
    $this->lastquery = $q;
    $this->querycount++;
    if (!$this->isQuerySelect($query)) {
      return true;
    }
    return $q;
  }

  function insertId() {
    return @pg_last_oid($this->connnection);
  }

  function affectedRows() {
    return @pg_affected_rows($this->connnection);
  }

  /**
   * @param string $query
   * @return bool
   */
  private function isQuerySelect($query) {
    if (strpos(strtoupper($query), 'SELECT') === 0) {
      return true;
    }
    return false;
  }

  /**
   * @param string $query
   * @param array $values
   * @return string
   */
  private function parseBindings($query = '', $values = array()) {
    if (strpos($query, $this->bindmarker) === false) {
      return $query;
    }
	  if (!is_array($values)) {
			$values = array($values);
		}
		$segments = explode($this->bindmarker, $query);
		if (count($values) >= count($segments)) {
			$values = array_slice($values, 0, count($segments)-1);
		}
		$result = $segments[0];
		$i = 0;
		foreach ($values as $bind) {
			$result .= $this->esc($bind).$segments[++$i];
		}
		return $result;
  }

  function getConnection() {
    return $this->connnection;
  }
  


}
