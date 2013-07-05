<?php

namespace Dlin\Saasu\Tests\Entity;

use Dlin\Saasu\Criteria\ActivityCriteria;
use Dlin\Saasu\Criteria\TagCriteria;
use Dlin\Saasu\Entity\Activity;


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
        $this->api = new SaasuAPI('CAD81524A8BB4F1B9AEE163FC0D42E7B', '39594');
    }


}
