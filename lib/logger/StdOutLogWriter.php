<?php
/**
 * User: HZ
 * Date: 2012.01.10.
 */

class StdOutLogWriter implements ILogWriter {

    public function write($msg = '') {
        var_dump($msg);

    }
}
