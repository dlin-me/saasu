<?php
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class InvoiceInstruction extends EntityBase
{


    public $emailToContact;
    public $templateUid;
    public $emailMessage;


    public function validate()
    {

        return Validator::instance()->
            lookAt($this->emailToContact, 'emailToContact')->bool()->
            lookAt($this->templateUid, 'templateUid');

    }
}
