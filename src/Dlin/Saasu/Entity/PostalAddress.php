<?php
namespace Dlin\Saasu\Entity;


use Dlin\Saasu\Validator\Validator;

class PostalAddress extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }


    public $street;
    public $city;
    public $state;
    public $postCode;
    public $country;

    public function validate()
    {
        return array();
    }
}