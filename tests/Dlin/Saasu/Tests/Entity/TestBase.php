<?php

namespace Dlin\Saasu\Tests\Entity;
use Dlin\Saasu\SaasuAPI;
use Dlin\Saasu\Util\DateTime;


/**
 *
 * User: davidlin
 * Date: 21/05/13
 * Time: 12:04 AM
 *
 */


class TestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Dlin\Saasu\SaasuAPI $api
     */
    protected $api;

    public function setUp()
    {
        $this->api = new SaasuAPI('AA016FF771414F9D99E5708AFC65C5C2', '41509');
    }


}
