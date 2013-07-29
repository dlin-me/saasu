<?php
/**
 * 
 * User: davidlin
 * Date: 30/07/13
 * Time: 1:12 AM
 * 
 */

namespace Dlin\Saasu\Tests\Util;


use Dlin\Saasu\Tests\Entity\TestBase;
use Dlin\Saasu\Util\DateTime;

class DateTimeTest extends TestBase  {

    public function testDateTime(){

        echo DateTime::getDate(time());

        echo DateTime::getDateTimes(time());

        echo DateTime::getDate('+1day');

        echo DateTime::getDateTimes('+1day');

    }

}