<?php

namespace Dlin\Saasu\Enum;

class TradingTermsType extends BaseEnum
{

    const Unspecified = 0;

    const DueIn = 1;

    const DueInEomPlusXDays = 2;

    const CashOnDelivery = 3;
}
