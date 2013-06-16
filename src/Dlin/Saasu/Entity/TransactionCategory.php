<?php
namespace Dlin\Saasu\Entity;

class TransactionCategory extends EntityBase
{

    public function __construct($uid=null){
        parent::__construct($uid);
    }


    public $type;
    public $name;
    public $isActive = true;
    public $ledgerCode;
    public $defaultTaxCode;
}
