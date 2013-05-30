<?php
namespace Dlin\Saasu\Journals;
class JournalItem
{
    public $accountUid;
    public $taxCode;
    /**
     * Total amount for this JournalItem
     * @var
     */
    public $amount;

    public $type;
}
