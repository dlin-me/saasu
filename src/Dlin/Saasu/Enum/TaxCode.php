<?php
namespace DavidForest\SaasuBundle\Lib\Enum;

/**
 * NOTE: Tax codes must exist in your file.
 * @see https://secure.saasu.com/a/net/taxcodelist.aspx
 */
class TaxCode
{
    const ExpInclGst = "G11";
    const ExpGstFree = "G11,G14";
//const ExpInclGstForInputTaxedSales = "G11,G13(1)";
//const ExpInclGstPrivateNonDeductable	= "G11,G15(1)";
//const ExpGstFreeForInputTaxedSales = "G11,G13(2)";
//const ExpGstFreePrivateNonDeductable	= "G11,G15(2)";
    const CapExInclGst = "G10";
    const CapExGstFree = "G10,G14";
//const CapExInclGstForInputTaxedSales	= "G10,G13(1)";
//const CapExInclGstPrivateNonDeductable	= "G10,G15(1)";
//const CapExGstFreeForInputTaxedSales	= "G10,G13(2)";
//const CapExGstFreePrivateNonDeductable	= "G10,G15(2)";
    const ExpAdjustments = "G18";
    const SaleInclGst = "G1";
    const SaleGstFree = "G1,G3";
    const SaleInputTaxed = "G1,G4";
    const SaleExports = "G1,G2";
    const SaleAdjustments = "G7";
    const SalaryWageOtherPaid = "W1";
    const WithheldTaxOnSalaryWage = "W1,W2";
    const WithheldInvestDistribNoTfn = "W3";
    const WithheldPaymentNoAbn = "W4";
    const WineEqualisationTaxPayable = "1C";
    const WineEqualisationTaxRefundable = "1D";
    const LuxuryCarTaxPayable = "1E";
    const LuxuryCarTaxRefundable = "1F";

}
