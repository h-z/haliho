<?php
/**
 * User: HZ
 * Date: 2012.01.08.
 */

abstract class Database implements IDatabase {
    protected $host;
    protected $port;
    protected $user;
    protected $password;
    protected $db;
    protected $filename;
    protected $connnection;
    protected $lastquery;
    protected $querycount = 0;
    protected $bindmarker = '?';
    protected $availableConfigs = array('host', 'port', 'user', 'password', 'db', 'filename');

    public function configXML(DOMNode $xml) {
        $configuration = array();
        foreach ($this->availableConfigs as $conf) {
            $items = $xml->getElementsByTagName($conf);
            if ($items->length > 0) {
                $configuration[$conf] = $items->item(0)->nodeValue;
            }
        }
        $this->config($configuration);
    }
    public function config($options = array()) {
      if (is_array($options))	{
  			foreach ($options as $key => $val) {
  				$this->$key = $val;
  			}
  		}
    }

    public function lastQuery() {
        return $this->lastquery;
    }

    public function isConnected() {
        return $this->connnection != null;
    }

    public function getConnection() {
      return $this->connnection;
    }

    /**
     * @param string $query
     * @return bool
     */
    protected function isQuerySelect($query) {
        if (strpos(strtoupper(trim($query)), 'SELECT') === 0) {
            return true;
        }
        return false;
    }

    /**
     * @param string $query
     * @param array $values
     * @return string
     */
    protected function parseBindings($query = '', $values = array()) {
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

}
