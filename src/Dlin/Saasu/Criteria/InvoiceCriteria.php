<?php
/**
 * 
 * User: davidlin
 * Date: 14/06/13
 * Time: 11:53 PM
 * 
 */

namespace Dlin\Saasu\Criteria;


class InvoiceCriteria {


    /*
     * * TransactionType	String	Either s or p.
s = Sale.
p = Purchase.
PaidStatus	String	If not specified, will only return unpaid invoices. Valid values are: “paid”, “unpaid”, “all”.
InvoiceStatus		Use:
Q = Quote
O = Order
I = Invoice. Filter won’t be applied if not specified.
InvoiceDateFrom	Date	Must be used together with InvoiceDateTo.
Returns invoices between the specified dates. If no date range specified returns transactions in last one month.
InvoiceDateTo	Date
InvoiceDueDateFrom	Date	Must be used together with InvoiceDueDateTo.
Returns invoices that are due between the specified dates.
InvoiceDueDateTo	Date
ContactUid	Int
IncludeAllTags	String	Either use IncludeAllTags or IncludeAnyTags, but not both.
Separate tags by comma. Example:
1
2
http://.../invoicelist?wsaccesskey=xxx&fileuid=999&transactiontype=s&includealltags=
division1,division2.
This will return all sales that have BOTH “division1″ AND “division2″
tags applied.
IncludeAnyTags	String	Either use IncludeAllTags or IncludeAnyTags, but not both.
Separate tags by comma. e.g. http://…/invoicelist?wsaccesskey=xxx&fileuid=999&transactiontype=s&
includeanytags=division1,division2.
This will return all sales that have EITHER “division1″ OR
“division2″ tags applied.
ExcludeAllTags	String	Can be used in conjunction with “IncludeAllTags” or “IncludeAnyTags”
but not “ExcludeAnyTags”.
ExcludeAnyTags	String	Can be used in conjunction with “IncludeAllTags” or “IncludeAnyTags”
but not “ExcludeAllTags”
IsSent	Boolean
InvoiceNumberBeginsWith	String
PurchaseOrderNumberBeginsWith	String
UtcLastModifiedFrom	DateTime	Must be used together with UtcLastModifiedTo. Usually, the DateTime would be in UTC, and ISO 8601 format.
Returns a list of invoices that were modified between UtcLastModifiedFrom and UtcLastModifiedTo.
e.g. http://…/invoicelist?wsaccesskey=xxx&fileuid=
999&transactiontype=s&utclastmodifiedfrom=
2009-03-06T02:20:00&utclastmodifiedto=
2009-03-06T02:30:00
UtcLastModifiedTo	DateTime	Must be used together with UtcLastModfiedFrom. Usually, the DateTime would be in UTC, and ISO 8601 format.
     */

}