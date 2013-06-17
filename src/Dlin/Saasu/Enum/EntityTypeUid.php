<?php
/**
 * 
 * User: davidlin
 * Date: 17/06/13
 * Time: 2:08 PM
 * 
 */

namespace Dlin\Saasu\Enum;


class EntityTypeUid extends BaseEnum {

    const Sale = 4;
    const SalePayment = 5;
    const Purchase = 7;
    const PurchasePayment = 8;
    const Contact = 10;
    const Item = 20;
}