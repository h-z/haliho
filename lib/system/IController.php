<?php
/**
 * User: hz
 * Date: 2011.11.21.
 */

interface IController {

  /**
   * @abstract
   * @return string
   */
  function toString();

  function getHeaders();

}
