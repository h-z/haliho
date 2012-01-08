<?php
/**
 * User: hz
 * Date: 2012.01.05.
 */

class SQLiteQuery extends Query {

    public function __construct(IDatabase $db, $query = '', $values = array()) {
        parent::__construct($db, $query, $values);
        $this->result = sqlite_query($this->query, $db->getConnection());
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
