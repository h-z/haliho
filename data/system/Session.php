<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class Session extends Singleton {

  /**
   * @param string $key
   * @return object
   */
  public function get(string $key) {
    $key = $this->key($key);
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }
    return null;
  }

  /**
   * @param string $key
   * @param object $value
   * @return object
   */
  public function set($key, $value) {
    $key = $this->key($key);
    $_SESSION[$key] = $value;
    return $value;
  }

  /**
   * @param string $key
   * @param object $value
   * @return object
   */
  public function store($key, $value = null) {
    $key = $this->key($key);
    if ($value != null) {
      $_SESSION[$key] = $value;
    }
    return $_SESSION[$key];
  }

  /**
   * @param string $key
   * @param object $value
   * @return object
   */
  public function flash($key, $value = null) {
    $key = $this->flashkey($key);
    if ($value != null) {
      $_SESSION[$key] = $value;
    }
    return $_SESSION[$key];
  }

  /**
   * @param string $key
   * @return string
   */
  private function key($key) {
    return 'kms__'.$key;
  }

  /**
   * @param string $key
   * @return string
   */
  private function flashkey($key) {
    return 'flash__'.$key;
  }
}
