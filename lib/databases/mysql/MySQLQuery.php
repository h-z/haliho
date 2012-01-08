<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */

class MySQLQuery extends Query {

    public function __construct(IDatabase $db, $query = '', $values = array()) {
        parent::__construct($db, $query, $values);
        $this->result = mysql_query($this->query, $db->getConnection());
    }

    public function row() {
        return mysql_fetch_array($this->result);
    }

    public function arow() {
        return mysql_fetch_assoc($this->result);
    }

    public function count() {
        return mysql_num_rows($this->result);
    }

    public function free() {
        if (is_resource($this->result)) {
            mysql_free_result($this->result);
            $this->result = false;
        }
    }
}
