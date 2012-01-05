<?php

session_start();

/**
 * User: hz
 * Date: 2011.11.14.
 */

class Core {

    private static $loadedDirectories;
    public static $configuration;
    public function __construct() {
        spl_autoload_register(array('Core', 'autoloader'));
        self::$configuration = new Configuration();
    }

    public function page($type = '') {

    }

    private static function getdirs($dir) {
        if (!is_dir($dir)) {
            return null;
        }
        $handle = opendir($dir);
        $subdirs = array();
        while (($file = readdir($handle)) !== false) {
            if (is_dir($file) && !in_array($file, array('.', '..'))) {
                $subdirs[$file] = self::getdirs($file);
            }
        }
        closedir($handle);
        return $subdirs;
    }

    private static function createpaths($pre, $dirs) {
        print_r($dirs);
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
        if (self::$loadedDirectories == null) {
            self::$loadedDirectories == self::createpaths('.', self::getdirs('.'));
        }

        foreach (self::$loadedDirectories as $dir) {
            $file = $dir.'/'.$className.'.php';
            if ( file_exists($file) ) {
                require_once($file);
            }
        }
    }
}


