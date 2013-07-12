<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class JournalItem extends EntityBase
{

    public function __construct($uid=null){
        parent::__construct($uid);
    }


    public $accountUid;
    public $taxCode;
    /**
     * Total amount for this JournalItem
     * @var
     */
    public $amount;

    public $type;


    public function validate()
    {


        return Validator::instance()->
            lookAt($this->accountUid, 'accountUid')->int()->required(true)->
            lookAt($this->amount, 'amount')->numeric()->required(true)->
            lookAt($this->type, 'type')->required(true);

    }

}
