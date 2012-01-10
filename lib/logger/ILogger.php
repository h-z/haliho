<?php
/**
 * User: HZ
 * Date: 2012.01.10.
 */

interface ILogger {

    function setLevel($i);

    function register(ILogWriter $writer);

    function log($msg, $level);

    function info($msg);

    function warn($msg);

    function debug($msg);

    function error($msg);
}
