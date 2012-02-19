<?php 
require_once '../init.php';

class SingletonImpl extends Singleton {
    public function a() {
    
    }


}

class SingletonImpl2 extends Singleton {
}

class SingletonTest extends PHPUnit_Framework_TestCase {
    public function testSingliness() {
        $a = SingletonImpl::getInstance();
        $b = SingletonImpl::getInstance();
        $this->assertSame($a, $b);
    }

    public function testImplementations() {
        $a = SingletonImpl::getInstance();
        $b = SingletonImpl2::getInstance(); 
        $this->assertNotSame($a, $b);
    }

}
