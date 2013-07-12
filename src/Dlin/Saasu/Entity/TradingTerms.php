<?php
/**
 *
 * User: davidlin
 * Date: 11/06/13
 * Time: 12:00 AM
 *
 */

namespace Dlin\Saasu\Entity;


use Dlin\Saasu\Validator\Validator;

class TradingTerms extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
    }

    public $type;
    public $interval;
    public $intervalType;

    public function validate()
    {

        return Validator::instance()->
            lookAt($this->type, 'type')->int()->required(true)->enum(1,2,3)->
            lookAt($this->interval, 'interval')->int()->
            lookAt($this->intervalType, 'intervalType')->int()->enum(0,1,2,3);

    }
}