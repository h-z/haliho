<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */

class PostgreSQL extends Database {

    public function connect() {
        if ($this->port != '') {
            $this->host .= ':'.$this->port;
        }
        $this->connnection = @pg_connect('host='.$this->host.' port='.$this->port.' dbname='.$this->db.' user='.$this->user.' password='.$this->password);
        return $this->connnection;
    }

    public function close() {
        return @pg_close($this->connnection);
    }

    public function query($query = '', $values = array()) {
        $q = new PostgreSQLQuery($this, $query, $values);
        $this->lastquery = $q;
        $this->querycount++;
        if (!$this->isQuerySelect($query)) {
            return true;
        }
        return $q;
    }

    public function insertId() {
        return @pg_last_oid($this->connnection);
    }

    public function affectedRows() {
        return @pg_affected_rows($this->connnection);
    }
}
