<?php
/**
 * User: HZ
 * Date: 2012.01.10.
 */

class StdOutLogWriter implements ILogWriter {

    public function write($msg = '', $level='') {
        $msg = date('Y-m-d H:i:s') . ' [' . $level . '] ' . $msg;
        print($msg."\n");

    }
}
