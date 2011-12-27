<?php
/**
 * User: hz
 * Date: 2011.11.11.
 */
 
class Request extends Singleton {

  private $host;
  private $domain;
  private $method;
  private $headers;
  private $port;
  private $protocol;
  private $queryString;
  private $clientIp;
  private $url;
  private $params;  

  protected function __construct() {
    $this->host = $_SERVER['HTTP_HOST'];
    $this->domain = $this->host;
    $this->method = $_SERVER['REQUEST_METHOD'];

    $this->port = $_SERVER['SERVER_PORT'];
    $this->protocol = $_SERVER['SERVER_PROTOCOL'];
    $this->queryString = $_SERVER['QUERY_STRING'];
    $this->clientIp = $_SERVER['REMOTE_ADDR'];
    $this->url = $this->protocol . '://' . $this->host;
    $this->params = array();

    if (!empty($_GET)) {
      foreach ($_GET as $k => $v) {
        $this->params[$k] = $v;
      }
    }

    if (!empty($_POST)) {
      foreach ($_POST as $k => $v) {
        $this->params[$k] = $v;
      }
    }

  }

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
