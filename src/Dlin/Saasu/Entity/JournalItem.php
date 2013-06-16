<?php
namespace Dlin\Saasu\Entity;
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
}
