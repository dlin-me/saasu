<?php
namespace Dlin\Saasu\Entity;

class TransactionCategory extends EntityBase
{
    public $type;
    public $name;
    public $isActive = true;
    public $ledgerCode;
    public $defaultTaxCode;
}
