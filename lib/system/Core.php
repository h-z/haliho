<?php

session_start();

/**
 * User: hz
 * Date: 2011.11.14.
 */

class Core {

    private $maxLoop = 10;
    private $data = array();
    private $xmlContent;

    private static $loadedDirectories;
    private static $rootpath = '';
    private static $separator = '/';
    private static $handles = array();

    public static $configuration;

    public function __construct($opts = array()) {
        spl_autoload_register(array('Core', 'autoloader'));
        self::$rootpath = $opts['rootpath'];
        self::$configuration = new Configuration($opts);
    }

    public function page($type = '') {
        $page = new Page(new URL("a"));

        $this->data['page'] = $page;
        $this->data['i18n'] = new I18n();
        $this->loadXML($type);
        $this->create();
        return $this->toString();
    }
    
    private function loadXML($type = '') {
        $this->xmlContent = new DOMDocument();
        $this->xmlContent->load(self::$rootpath . 'public/test/page.xml');
    }

    private function toString() {
        return $this->xmlContent->saveXML();
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
        var_dump("\n");
        if (!empty(self::$handles)) {
            foreach (self::$handles as $nodeName => $handle) {
                var_dump("..and now: ".$nodeName);
                //$handle = array($handle, 'handle');
                $tags = $xml->getElementsByTagNameNS('http://hz.muszaki.info/ns/1.0', $nodeName);
                var_dump($tags->length);
                var_dump("ee");
                if (!empty($tags)) {
                    foreach ($tags as $tag) {
                        var_dump("e");
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
                if (is_dir($dir . self::$separator . $file)) {
                    $subdirs[$file] = self::getdirs($dir . self::$separator . $file);
                }
            }
        }
        closedir($handle);
        return $subdirs;
    }

    private static function createpaths($pre, $dirs) {
        $paths = array();
        foreach($dirs as $d => $subs) {
            $current = $pre . self::$separator . $d;
            $paths[] = $current;
            if ($subs) {
                $paths = array_merge($paths, self::createpaths($current, $subs));
            }
        }
        return $paths;
    }

    public static function autoloader($className) {
        //$className = strtolower($className);
        $startDir = self::$rootpath;
        if (self::$loadedDirectories == null) {
            $dirs = self::getdirs($startDir);
            self::$loadedDirectories = self::createpaths($startDir, $dirs);
        }
        foreach (self::$loadedDirectories as $dir) {
            $file = $dir . self::$separator . $className.'.php';
            if ( file_exists($file) ) {
                require_once($file);
            }
        }
    }
}


