<?php
namespace Dlin\Saasu\Entity;

class CCPayment extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }


    public $cardholderName = "";
    public $cCNumber = "";
// <summary>
// CC expiry date in MMYY format, e.g. 0610 for cc expiring on Jun 2010.
// </summary>
    public $cCExpiryDate = "";
// <summary>
// CVV = Card verfication value code. Visa: CVV2, Mastercard: CVC2, Amex: CID.
// </summary>
    public $cvvCode = "";
    public $amount;
    public $requestID = "";
    public $referenceNumber = ""; //	For result.
    public $processingTimestamp;
}
