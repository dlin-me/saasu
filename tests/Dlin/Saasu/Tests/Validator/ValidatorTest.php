<?php
/**
 *
 * User: davidlin
 * Date: 5/07/13
 * Time: 12:10 AM
 *
 */

namespace Dlin\Saasu\Tests\Validator;


use Dlin\Saasu\Entity\Activity;
use Dlin\Saasu\Validator\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{


    public function testValidation()
    {

        //required
        $this->assertTrue(Validator::instance()->lookAt(null, 'required')->required(true)->hasError('required'));
        $this->assertFalse(Validator::instance()->lookAt(null, 'required')->required(false)->hasError('required'));
        //enum
        $this->assertFalse(Validator::instance()->lookAt('a', 'enum')->enum('a',0)->hasError('enum'));
        $this->assertFalse(Validator::instance()->lookAt(0, 'enum')->enum('a',0)->hasError('enum'));
        $this->assertTrue(Validator::instance()->lookAt(1, 'enum')->enum('a',0)->hasError('enum'));
        //in_array
        $this->assertFalse(Validator::instance()->lookAt('a', 'in_array')->inArray(array('a',0))->hasError('in_array'));
        $this->assertFalse(Validator::instance()->lookAt(0, 'in_array')->inArray(array('a',0))->hasError('in_array'));
        $this->assertTrue(Validator::instance()->lookAt(1, 'in_array')->inArray(array('a',0))->hasError('in_array'));
        //numeric
        $this->assertFalse(Validator::instance()->lookAt('1', 'numeric')->numeric()->hasError('numeric'));
        $this->assertFalse(Validator::instance()->lookAt('1.32', 'numeric')->numeric()->hasError('numeric'));
        $this->assertTrue(Validator::instance()->lookAt('1x', 'numeric')->numeric()->hasError('numeric'));

        //int
        $this->assertFalse(Validator::instance()->lookAt('1', 'int')->int()->hasError('int'));
        $this->assertTrue(Validator::instance()->lookAt('1.32', 'int')->int()->hasError('int'));
        $this->assertTrue(Validator::instance()->lookAt('1x', 'int')->int()->hasError('int'));

        //bool
        $this->assertTrue(Validator::instance()->lookAt('1', 'bool')->bool()->hasError('bool'));
        $this->assertTrue(Validator::instance()->lookAt('1.32', 'bool')->bool()->hasError('bool'));
        $this->assertTrue(Validator::instance()->lookAt('yes', 'bool')->bool()->hasError('bool'));
        $this->assertFalse(Validator::instance()->lookAt('true', 'bool')->bool()->hasError('bool'));
        $this->assertFalse(Validator::instance()->lookAt('false', 'bool')->bool()->hasError('bool'));
        $this->assertFalse(Validator::instance()->lookAt('False', 'bool')->bool()->hasError('bool'));
        $this->assertFalse(Validator::instance()->lookAt('TrUe', 'bool')->bool()->hasError('bool'));

        //length
        $this->assertTrue(Validator::instance()->lookAt('TrUe', 'length')->length(0,3)->hasError('length'));
        $this->assertTrue(Validator::instance()->lookAt('TrUe', 'length')->length(6,7)->hasError('length'));
        $this->assertFalse(Validator::instance()->lookAt('TrUe', 'length')->length(3,7)->hasError('length'));
        $this->assertFalse(Validator::instance()->lookAt(null, 'length')->length(0,7)->hasError('length'));

        //email
        $this->assertFalse(Validator::instance()->lookAt('hello@hello.com', 'email')->email()->hasError('email'));
        $this->assertTrue(Validator::instance()->lookAt('hello@hell@o.com', 'email')->email()->hasError('email'));
        $this->assertTrue(Validator::instance()->lookAt('hello@hell', 'email')->email()->hasError('email'));

        //url
        $this->assertTrue(Validator::instance()->lookAt('hello@hellohellohello.com', 'url')->url()->hasError('url'));
        $this->assertFalse(Validator::instance()->lookAt('http://google.com', 'url')->url()->hasError('url'));

        //regex
        $this->assertTrue(Validator::instance()->lookAt('asdfb', 'regex')->regex('/\d+/')->hasError('regex'));
        $this->assertFalse(Validator::instance()->lookAt('12', 'regex')->regex('/\d+/')->hasError('regex'));

        //date
        $this->assertTrue(Validator::instance()->lookAt('asdfb', 'date')->date()->hasError('date'));
        $this->assertTrue(Validator::instance()->lookAt('2033 Jan 23', 'date')->date()->hasError('date'));
        $this->assertFalse(Validator::instance()->lookAt('2005-09-30', 'date')->date()->hasError('date'));

        //datetime
        $this->assertTrue(Validator::instance()->lookAt('asdfb', 'datetime')->datetime()->hasError('datetime'));
        $this->assertTrue(Validator::instance()->lookAt('2033 Jan 23', 'datetime')->datetime()->hasError('datetime'));
        $this->assertTrue(Validator::instance()->lookAt('2005-09-30', 'datetime')->datetime()->hasError('datetime'));
        $this->assertFalse(Validator::instance()->lookAt('2009-03-06T02:30:00', 'datetime')->datetime()->hasError('datetime'));

        //minMax
        $this->assertTrue(Validator::instance()->lookAt('1', 'minMax')->minMax(12, 19)->hasError('minMax'));
        $this->assertTrue(Validator::instance()->lookAt('111', 'minMax')->minMax(12, 19)->hasError('minMax'));
        $this->assertFalse(Validator::instance()->lookAt('13', 'minMax')->minMax(12, 19)->hasError('minMax'));
        $this->assertTrue(Validator::instance()->lookAt('a', 'minMax')->minMax('b', 'f')->hasError('minMax'));
        $this->assertTrue(Validator::instance()->lookAt('g', 'minMax')->minMax('b', 'f')->hasError('minMax'));
        $this->assertFalse(Validator::instance()->lookAt('d', 'minMax')->minMax('b', 'f')->hasError('minMax'));

        //gt
        $this->assertFalse(Validator::instance()->lookAt('d', 'gt')->gt('b')->hasError('gt'));
        $this->assertTrue(Validator::instance()->lookAt('a', 'gt')->gt('b')->hasError('gt'));
        $this->assertFalse(Validator::instance()->lookAt('13', 'gt')->gt(12)->hasError('gt'));
        $this->assertTrue(Validator::instance()->lookAt('11', 'gt')->gt(12)->hasError('gt'));

        //ngt
        $this->assertTrue(Validator::instance()->lookAt('d', 'ngt')->ngt('b')->hasError('ngt'));
        $this->assertFalse(Validator::instance()->lookAt('d', 'ngt')->ngt('d')->hasError('ngt'));
        $this->assertFalse(Validator::instance()->lookAt('a', 'ngt')->ngt('b')->hasError('ngt'));
        $this->assertTrue(Validator::instance()->lookAt('13', 'ngt')->ngt(12)->hasError('ngt'));
        $this->assertFalse(Validator::instance()->lookAt('13', 'ngt')->ngt(13)->hasError('ngt'));
        $this->assertFalse(Validator::instance()->lookAt('11', 'ngt')->ngt('12')->hasError('ngt'));


        //neq
        $this->assertFalse(Validator::instance()->lookAt('d', 'neq')->neq('b')->hasError('neq'));
        $this->assertTrue(Validator::instance()->lookAt('d', 'neq')->neq('d')->hasError('neq'));
        $this->assertFalse(Validator::instance()->lookAt('a', 'neq')->neq('b')->hasError('neq'));
        $this->assertFalse(Validator::instance()->lookAt('13', 'neq')->neq(12)->hasError('neq'));
        $this->assertTrue(Validator::instance()->lookAt('13', 'neq')->neq(13)->hasError('neq'));
        $this->assertFalse(Validator::instance()->lookAt('11', 'neq')->neq('12')->hasError('neq'));

        //lt
        $this->assertTrue(Validator::instance()->lookAt('d', 'lt')->lt('b')->hasError('lt'));
        $this->assertFalse(Validator::instance()->lookAt('a', 'lt')->lt('b')->hasError('lt'));
        $this->assertTrue(Validator::instance()->lookAt('13', 'lt')->lt(12)->hasError('lt'));
        $this->assertFalse(Validator::instance()->lookAt('11', 'lt')->lt(12)->hasError('lt'));

        //nlt
        $this->assertFalse(Validator::instance()->lookAt('d', 'nlt')->nlt('b')->hasError('nlt'));
        $this->assertFalse(Validator::instance()->lookAt('d', 'nlt')->nlt('d')->hasError('nlt'));
        $this->assertTrue(Validator::instance()->lookAt('a', 'nlt')->nlt('b')->hasError('nlt'));
        $this->assertFalse(Validator::instance()->lookAt('13', 'nlt')->nlt(12)->hasError('nlt'));
        $this->assertFalse(Validator::instance()->lookAt('13', 'nlt')->nlt(13)->hasError('nlt'));
        $this->assertTrue(Validator::instance()->lookAt('11', 'nlt')->nlt('12')->hasError('nlt'));

        //exor
        $this->assertTrue(Validator::instance()->lookAt('value', 'exor')->exor('12')->hasError('exor'));
        $this->assertFalse(Validator::instance()->lookAt(null, 'exor')->exor(null)->hasError('exor'));
        $this->assertFalse(Validator::instance()->lookAt(null, 'exor')->exor('ok')->hasError('exor'));
        $this->assertFalse(Validator::instance()->lookAt('ok', 'exor')->exor(null)->hasError('exor'));


        //exnor
        $this->assertTrue(Validator::instance()->lookAt('value', 'exnor')->exnor(null)->hasError('exnor'));
        $this->assertFalse(Validator::instance()->lookAt(null, 'exnor')->exnor(null)->hasError('exnor'));
        $this->assertFalse(Validator::instance()->lookAt('ok', 'exnor')->exnor('oks')->hasError('exnor'));
        $this->assertTrue(Validator::instance()->lookAt(null, 'exnor')->exnor('ok')->hasError('exnor'));


    }

    
}
