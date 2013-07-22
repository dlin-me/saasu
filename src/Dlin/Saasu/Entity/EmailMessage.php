<?php 
namespace Dlin\Saasu\Entity;

use Dlin\Saasu\Validator\Validator;

class EmailMessage extends EntityBase
{

    public function __construct($uid=null){
        parent::__construct($uid);
    }

    public $from;
	public $to;
	public $cc;
	public $bcc;
	public $subject;
	public $body;


    public function validate(){
        return Validator::instance()->
            lookAt($this->from, 'from')->required(true)->
            lookAt($this->to, 'to')->required(true);
    }
}
