<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class Request extends Singleton {

  /**
   * @param string $key
   * @return object
   */
  public function get($key) {
    return $_GET[$key];
  }

  /**
   * @param string $key
   * @return object
   */
  public function post($key) {
    return $_POST[$key];
  }
}
