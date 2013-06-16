<?php
namespace Dlin\Saasu\Entity;

class ServiceInvoiceItem extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
    }

    public $description;
    public $accountUid;
    public $taxCode;

    public $totalAmountInclTax;

    public $totalAmountExclTax;

    public $totalTaxAmount;
    public $tags;
}
