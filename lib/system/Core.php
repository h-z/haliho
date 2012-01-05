<?php

session_start();

/**
 * User: hz
 * Date: 2011.11.14.
 */

class Core {

    private $maxLoop = 10;
    private static $handles = array();

    private static $loadedDirectories;
    public static $configuration;

    public function __construct() {
        spl_autoload_register(array('Core', 'autoloader'));
        self::$configuration = new Configuration();
    }

    public function page($type = '') {
        $page = new Page(new URL("a"));
        $i18n = new I18n();
    }

    public static function registerHandle($nodeName = '', $handlerObject = array()) {
        self::$handles[$nodeName] = $handlerObject;
    }

    private function create() {
        $loop = 0;
        $xml = $this->xmlContent;
        if ($loop < $this->maxLoop) {
            $xml0 = $this->parseXml($xml);
            //TODO equals
            if ($xml0 == $xml) {
                $this->xmlContent = $xml0;
                return;
            }
            $loop++;
        }
    }

    /**
     * @param DOMDocument $xml
     * @return DOMDocument
     */
    private function parseXml(DOMDocument $xml) {
        if (!empty(self::$handles)) {
            foreach (self::$handles as $nodeName => $handle) {
                //$handle = array($handle, 'handle');
                $tags = $xml->getElementsByTagName($nodeName);
                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        /* @var $tag DOMNode */
                        if ($handle instanceof IHandler) {
                            $tag->parentNode->replaceChild(call_user_func(array($handle, 'handle'), $tag), $tag);
                        }
                    }
                }
            }
        }
        return $xml;
    }

    private static function getdirs($dir) {
        if (!is_dir($dir)) {
            return null;
        }
        $handle = opendir($dir);
        $subdirs = array();
        while (($file = readdir($handle)) !== false) {
            if (!in_array($file, array('.', '..', '.svn', '.idea'))) {
                if (is_dir($dir. '/' . $file)) {
                    $subdirs[$file] = self::getdirs($dir . '/' . $file);
                }
            }
        }
        closedir($handle);
        return $subdirs;
    }

    private static function createpaths($pre, $dirs) {
        $paths = array();
        foreach($dirs as $d => $subs) {
            $current = $pre.'/'.$d;
            $paths[] = $current;
            if ($subs) {
                $paths = array_merge($paths, self::createpaths($current, $subs));
            }
        }
        return $paths;
    }

    public static function autoloader($className) {
        //$className = strtolower($className);
        $startDir = "/home/hz/projects/php/kms";
        $startDir = '..';
        if (self::$loadedDirectories == null) {
            $dirs = self::getdirs($startDir);
            self::$loadedDirectories = self::createpaths($startDir, $dirs);
        }
 //       var_dump(self::$loadedDirectories);
        foreach (self::$loadedDirectories as $dir) {
            $file = $dir.'/'.$className.'.php';
            if ( file_exists($file) ) {
                require_once($file);
            }
        }
    }
}


