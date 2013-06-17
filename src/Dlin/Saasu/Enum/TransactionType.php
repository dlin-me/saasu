<?php
namespace DavidForest\SaasuBundle\Lib\Enum;

use Dlin\Saasu\Enum\BaseEnum;

class TransactionType extends BaseEnum
{
    const Sale = "S";
    const Purchase = "P";
    const SalePayment = "SP";
    const PurchasePayment = "PP";
    const GeneralJournal = "GJ";
    const BankTransfer = "BT";
    const PayrollEntry = "PE";
    const AccountOpeningBalance = "AOB";
    const InventoryAdjustment = "IA";
    const InventoryOpeningBalance = "IOB";
    const InventoryTransfer = "IT";
}
