<?php
namespace Dlin\Saasu\Entity;


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