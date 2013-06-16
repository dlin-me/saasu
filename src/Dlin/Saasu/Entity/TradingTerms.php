<?php
/**
 * 
 * User: davidlin
 * Date: 11/06/13
 * Time: 12:00 AM
 * 
 */

namespace Dlin\Saasu\Entity;


class TradingTerms extends EntityBase {
    public function __construct($uid=null){
        parent::__construct($uid);
    }

    public $type;
    public $interval;
    public $intervalType;

}