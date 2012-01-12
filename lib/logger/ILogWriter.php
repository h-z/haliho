<?php
/**
 * User: HZ
 * Date: 2012.01.10.
 */

interface ILogWriter {
    function write($msg='', $level='');
}
