<?php
/**
 * User: hz
 * Date: 2011.11.15.
 */
 
class Util {
    public static function endsWith($string, $ending) {
        $len = strlen($ending);
        $string_end = substr($string, strlen($string) - $len);
        return $string_end == $ending;
    }
}
