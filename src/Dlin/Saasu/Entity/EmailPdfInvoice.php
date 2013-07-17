<?php
/**
 *
 * User: davidlin
 * Date: 22/06/13
 * Time: 11:59 PM
 *
 */

namespace Dlin\Saasu\Entity;
use Dlin\Saasu\Entity\EntityBase;
use Dlin\Saasu\Validator\Validator;

/**
 *
 * Class EmailPdfInvoice
 *
 * @package Dlin\Saasu\Action
 */
class EmailPdfInvoice extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
    }

    /**
     * Override the default so that operations have empty save operation name
     *
     * @return string
     */
    public function getSaveOperationName()
    {
        return "";
    }

    public $invoiceUid;
    public $templateUid;
    public $emailMessage;


    /**
     *
     * @return $this|Validator
     */
    public function validate()
    {
        return Validator::instance()->
            lookAt($this->invoiceUid, 'invoiceUid')->required(true)->
            lookAt($this->emailMessage, 'emailMessage')->required(true);
    }
}