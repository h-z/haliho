<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */

class MySQL extends Database {

    public function connect() {
        if ($this->port != '') {
            $this->host .= ':'.$this->port;
        }
        $this->connnection = @mysql_connect($this->host, $this->user, $this->password, TRUE);
        @mysql_select_db($this->db, $this->connnection);
        @mysql_query('SET NAMES \'UTF8\'');
        return $this->connnection;
    }

    public function close() {
        return @mysql_close($this->connnection);
    }

    public function esc($str) {
        $str =  str_replace("'", "''", $str);
        $str =  str_replace("\''", "\'", $str);
        return $str;
    }

    public function query($query = '', $values = array()) {
        $q = new MySQLQuery($this, $query, $values);
        $this->lastquery = $q;
        $this->querycount++;
        if (!$this->isQuerySelect($query)) {
            return true;
        }
        return $q;
    }

    public function insertId() {
        return @mysql_insert_id($this->connnection);
    }

    public function affectedRows() {
        return @mysql_affected_rows($this->connnection);
    }

}
