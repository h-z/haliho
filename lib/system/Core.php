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
        self::$configuration = Factory::getConfiguration($opts);
        $logmanager = LoggerManager::getInstance();
    }

    public function page($type = '') {
        $page = new Page(new URL('a'));

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
        if (!empty(self::$handles)) {
            foreach (self::$handles as $nodeName => $handle) {
                //$handle = array($handle, 'handle');
                if ($handle instanceof IHandler) {
                   $tags = $xml->getElementsByTagNameNS('http://hz.muszaki.info/ns/1.0', $nodeName);
                    $nodes = array();
                    if (!empty($tags)) {
                        for ($i=0; $i<$tags->length; $i++) {
                            $nodes[] = $tags->item($i);
                        }
                        foreach ($nodes as $orignode) {
                            $d = call_user_func(array($handle, 'handle'), $orignode);
                            $d = $xml->importNode($d, true);               
                            $orignode->parentNode->replaceChild($d, $orignode);
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


if (!function_exists('get_called_class')) {

    function get_called_class() { 
        $bt = debug_backtrace(); 
        $lines = file($bt[1]['file']); 
        preg_match('/([a-zA-Z0-9\_]+)::'.$bt[1]['function'].'/', $lines[$bt[1]['line']-1], $matches); 

        if(empty($matches[1])) { 
            $pp = serialize( $bt[1]['object']);
            $nx = strpos($pp,'"')+1; 
            $nx = substr($pp,$nx,strpos($pp,'"')); 
            if (!empty($nx)) { 
                return $nx; 
            } 
        } 
        return $matches[1]; 
    } 
}
