<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */

interface IDatabase {

  function config($options = array());

  /**
   * @abstract
   * @return boolean
   */
  function isConnected();

  function connect();

  function close();

  /**
   * @abstract
   * @return resource
   */
  function getConnection();

  /**
   * @abstract
   * @return string
   */
  function lastQuery();

  /**
   * @abstract
   * @param string $str
   * @return string
   */
  function esc($str);
  
  /**
   * @var string $query
   * @var array $values
   * @return IQuery
   */
  function query($query = '', $values = array());

  /**
   * @abstract
   * @return int
   */
  function insertId();

  /**
   * @abstract
   * @return int
   */
  function affectedRows();
}
