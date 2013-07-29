<?php
namespace Dlin\Saasu\Tests\Util;

use Dlin\Saasu\Tests\Entity\TestBase;
use Dlin\Saasu\Util\Throttler;

class ThrottlerTest extends TestBase {

    public function testThrottle(){

        $throttler = new Throttler(5,1);
        $start = time();
        for($i=0 ; $i<10; $i++){
            $throttler->throttle();
        }
        $this->assertGreaterThanOrEqual(1, time()-$start);


        $throttler = new Throttler(1,1);
        $start = time();
        for($i=0 ; $i<5; $i++){
            $throttler->throttle();
        }
        $this->assertGreaterThanOrEqual(4, time()-$start);


        $throttler = new Throttler(1,2);
        $start = time();
        for($i=0 ; $i<5; $i++){
            $throttler->throttle();
        }
        $this->assertGreaterThanOrEqual(8, time()-$start);

    }
}