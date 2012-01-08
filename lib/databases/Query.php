<?php
/**
 * User: HZ
 * Date: 2012.01.08.
 */

abstract class Query implements IQuery {
    protected $result;
    protected $query;
    protected $db;

    public function __construct(IDatabase $db, $query = '', $values = array()) {
        $this->db = $db;
        $this->query = $query;
    }

    public function fetchAll() {
        $r = array();
        while ($row = $this->row()) {
            $r[] = $row;
        }
        return $r;
    }

    public function fetchAllAssoc() {
        $r = array();
        while ($row = $this->arow()) {
            $r[] = $row;
        }
        return $r;
    }
}
