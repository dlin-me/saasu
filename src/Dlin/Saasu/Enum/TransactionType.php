<?php
namespace Dlin\Saasu\Enum;



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
