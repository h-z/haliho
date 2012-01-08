<?php
/**
 * User: hz
 * Date: 2012.01.05.
 */

class SQLite extends Database {

    public function connect() {
        $this->connnection = @sqlite_open(Configuration::getInstance()->tmpdir . '/' . $this->filename, 0666);
        return $this->connnection;
    }

    public function close() {
        return @sqlite_close($this->connnection);
    }


    public function esc($str) {
        $str =  str_replace("'", "''", $str);
        $str =  str_replace("\''", "\'", $str);
        return $str;
    }

    public function query($query = '', $values = array()) {
        $q = new SQLiteQuery($this, $query, $values);
        $this->lastquery = $q;
        $this->querycount++;
        if (!$this->isQuerySelect($query)) {
            return true;
        }
        return $q;
    }

    public function insertId() {
        return @sqlite_last_insert_rowid($this->connnection);
    }

    public function affectedRows() {
        return @sqlite_changes($this->connnection);
    }

}
