<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class QuickPayment extends EntityBase
{

    public function __construct($uid=null){
        parent::__construct($uid);
    }

    public $datePaid;
    public $dateCleared;
    public $bankedToAccountUid;
    public $amount;
    public $reference;
    public $summary;


    public function validate()
    {

        return Validator::instance()->
            lookAt($this->datePaid, 'datePaid')->date()->required(true)->
            lookAt($this->dateCleared, 'dateCleared')->date()->
            lookAt($this->amount, 'amount')->numeric()->required(true)->
            lookAt($this->bankedToAccountUid, 'bankedToAccountUid')->int()->required(true)->
            lookAt($this->reference, 'reference')->length(0,50)->
            lookAt($this->summary, 'summary')->length(0,75);

    }
}
