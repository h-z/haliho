<?php
/**
 * User: hz
 * Date: 2011.11.12.
 */

class KMS_DB {
    private $db;
    private $log;
    private $tables = array(
        'menu'=>'mnu',
        'cikk'=>'ckk',
        'site'=>'ste',
        'ckk2mnu'=>'c2m',
        'lang'=>'lng',
        'nyelvielem'=>'nye',
        'termek'=>'trm',
        'termekcsoport'=>'tcs',
        'hirleveltag'=>'hlt',
        'hirlevel'=>'hlv',
        'user'=>'usr',
        'config'=>'cnf',
        'link'=>'lnk',
        'tag'=>'tag',
        'cimcsoport'=>'ccs',
        'tag2ccs'=>'t2c',
        'history'=>'hst'
    );

    function __construct(IDatabase $db) {
        $this->db = $db;
        $this->log = true;
    }

    function pre($table) {
        if(isset($this->tables[$table])) {
            return $this->tables[$table];
        } else {
            return false;
        }
    }

    function fetch($table, $id) {
        $pre = $this->pre($table);
        return $this->db->query('SELECT * FROM '.$this->db->esc($table).' WHERE '.$pre.'_id='.$this->db->esc($id))->arow();
    }

    function insert($table, $values = array()) {
        $pre = $this->pre($table);
        if(!$pre) {
            return false;
        }
        unset($values[$pre.'_id']);
        $values[$pre.'_usr_id'] = $_SESSION['user']['usr_id'];
        $values[$pre.'_moddatum'] = date('Y-m-d H:i:s', time());
        foreach($values as $k=>$v) {
            $v = is_array($v) ? implode(',',$v) : $v;
            $arr[$k] = $this->db->esc($v);
        }
        $keys = implode(',', array_keys($values));
        $values = "'".implode("','", $values)."'";
        $q = 'INSERT INTO '.$table.' ('.$keys.') VALUES ('.$values.')';
        $this->db->query($q);
        $id = $this->db->insertId();
        $_POST[$pre.'_id'] = $id;
        return $id;
    }

    function update($table, $id, $values = array()) {
        $pre = $this->pre($table);
        if(!$pre) {
            return false;
        }
        $q = 'UPDATE '.$table.' SET ';
        unset($values[$pre.'_id']);
        $values[$pre.'_usr_id'] = $_SESSION['user']['usr_id'];
        $values[$pre.'_moddatum'] = date('Y-m-d H:i:s', time());
        foreach($values as $k => $v) {
            $v = is_array($v)?implode(',',$v):$v;
            $q .= $k."='".$this->db->esc($v)."',";
        }
        $q = substr($q, 0, -1);
        $q .= ' WHERE '.$pre.'_id='.(int)$id.' AND '.$pre.'_del=0';
        if($this->log) {
            $logq = 'SELECT * FROM '.$table.' WHERE '.$pre.'_id='.(int)$id.'';
            $orig = $this->db->query($logq)->arow();
            $orig = serialize($orig);
            $origq = str_replace("'", "", $q);
            $orig = str_replace("'", "", $orig);
            $this->insert(array(
                    'hst_query'=>$this->db->esc($origq),
                    'hst_originaldata'=>$this->db->esc($orig)),
                'history');
        }
        $this->db->query($q);
        return $this->db->affectedRows();
    }

    function delete($table, $id) {
        $t = time();
        $pre = $this->pre($table);
        if(!$pre) {
            return false;
        }
        $q = 'UPDATE '.$table.' SET '.$pre.'_del='.$t.', '.$pre.'_usr_id='.$_SESSION['user']['usr_id'].' WHERE '.$pre.'_id='.(int)$id;
        //$q = 'UPDATE '.$table.' SET '.$pre.'_del='.$t.' WHERE '.$pre.'_id='.(int)$id;
        $this->db->query($q);
        return ($this->db->affectedRows()==1);
    }

}
