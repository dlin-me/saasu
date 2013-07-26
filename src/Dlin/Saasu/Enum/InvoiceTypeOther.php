<?php
namespace Dlin\Saasu\Enum;

/**
 * Notes: This is zone sensitive. Too see a list of Invoice Types that you could use for your zone,
 * sign in to your file, then go to Sales > Add or Purchases > Add.
 */
class InvoiceTypeOther
{
    const PreQuoteOpportunity = "Pre-Quote Opportunity";
    const Quote = "Quote";
    const PurchaseOrder = "Purchase Order";
    const SaleOrder = "Sale Order";
    const SaleInvoice = "Sale Invoice";
    const PurchaseInvoice = "Purchase Invoice";
    const CreditNote = "Credit Note";
    const DebitNote = "Debit Note";
    const PaymentInvoice = "Payment Invoice";

    const MoneyIn = "Money In (Income)";
    const MoneyOut = "Money Out (Expense)";

    /** NOT FOR NZ
    const SelfBilling = "Self-Billing";
    const AdjustmentNote = "Adjustment Note";
    const RctInvoice = "RCT Invoice";
    const Consignment = "Consignment"; // Reserved, not used.
     */

}
