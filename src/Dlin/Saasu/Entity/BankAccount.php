<?php
namespace Dlin\Saasu\Entity;

class BankAccount extends TransactionCategory
{
    public $displayName;
    public $bsb;
    public $accountNumber;
    public $merchantFeeAccountUid;
}
