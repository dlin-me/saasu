<?php 
namespace Dlin\Saasu\Entity;

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

}
