<?php
namespace Dlin\Saasu\Entity;

class BankAccount extends TransactionCategory
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }

    public $displayName;
    public $bsb;
    public $accountNumber;
    public $merchantFeeAccountUid;
}
