<?php
namespace Dlin\Saasu\Enum;
/**
 * A.K.A Transaction Category Type
 */
class AccountType extends BaseEnum
{
    const Income = "Income";
    const Expense = "Expense";
    const Asset = "Asset";
    const Equity = "Equity";
    const Liability = "Liability";
    const OtherIncome = "Other Income";
    const OtherExpense = "Other Expense";
    const CostOfSales = "Cost of Sales";

}

