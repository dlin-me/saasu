<?php
namespace Dlin\Saasu\Enum;

/**
 * Notes: This is zone sensitive. Too see a list of Invoice Types that you could use for your zone,
 * sign in to your file, then go to Sales > Add or Purchases > Add.
 */
class InvoiceType
{
    const TaxInvoice = "Tax Invoice";
    const SaleInvoice = "Sale Invoice";
    const PurchaseInvoice = "Purchase Invoice";
    const AdjustmentNote = "Adjustment Note";
    const CreditNote = "Credit Note";
    const DebitNote = "Debit Note";
    const PaymentInvoice = "Payment Invoice";
    const RctInvoice = "RCT Invoice";
    const MoneyIn = "Money In (Income)";
    const MoneyOut = "Money Out (Expense)";
    const PurchaseOrder = "Purchase Order";
    const SaleOrder = "Sale Order";
    const Quote = "Quote";
    const PreQuoteOpportunity = "Pre-Quote Opportunity";
    const SelfBilling = "Self-Billing";
    const Consignment = "Consignment"; // Reserved, not used.

}
