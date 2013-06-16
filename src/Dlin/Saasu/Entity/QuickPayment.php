<?php
namespace Dlin\Saasu\Entity;

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
}
