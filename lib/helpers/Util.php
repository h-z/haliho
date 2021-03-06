<?php
/**
 * User: hz
 * Date: 2011.11.15.
 */
 
class Util {
    public static function endsWith($string, $ending) {
        $tmp = explode($ending, $string);
        if (count($tmp) == 2) {
            if ('' == $tmp[1]) {
                return $tmp[0];
            }
        }
        return false;
    }

    public static function attr(DOMNode $node, $attr = '') {
        foreach ( $node->attributes as $name => $value ) {
            if ($attr == $name) {
                return $value->nodeValue;
            }
        }
        return null;

    }
}
