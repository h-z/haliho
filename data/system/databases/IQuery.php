<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */

interface IQuery {

  /**
   * @abstract
   * @return array
   */
  function fetchall();

  /**
   * @abstract
   * @return array
   */
  function row();

  /**
   * @abstract
   * @return array
   */
  function arow();

  /**
   * @abstract
   * @return int
   */
  function count();

  /**
   * @abstract
   * @return void
   */
  function free();
}
