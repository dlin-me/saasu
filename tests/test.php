<?php
/**
 * 
 * User: davidlin
 * Date: 8/06/13
 * Time: 1:24 PM
 * 
 */

class A{

    private $a;

    public function __construct()
    {
        $this->a = 'hello';
    }

    public function getA(){
        return $this->a;
    }


    public function __set($name, $value){
        echo $this->getA();
    }

}


class B extends  A{

        public function __construct(){
            parent::__construct();
        }

}


$b = new B();
$b->foo = 10;
