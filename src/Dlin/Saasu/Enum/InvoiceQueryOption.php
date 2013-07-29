<?php
/**
 *
 * User: davidlin
 * Date: 24/07/13
 * Time: 11:51 PM
 *
 */

namespace Dlin\Saasu\Enum;


class InvoiceQueryOption extends BaseEnum
{
    const INC_PAYMENTS = "incpayments";
    const TEMPLATE_UID = "templateUid"; //the template id, if any for pdf
    const FORMAT = "format"; //only support pdf
}