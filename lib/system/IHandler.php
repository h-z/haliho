<?php
/**
 * User: hz
 * Date: 2011.11.21.
 */

interface IHandler {

  /**
   * @abstract
   * @param DOMNode
   * @return DOMNode
   */
  function handle(DOMNode $node);

}
