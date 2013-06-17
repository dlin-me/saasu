<?php
namespace Dlin\Saasu\Entity;

class DeletedEntity extends EntityBase
{
    public function __construct($uid=null){
        parent::__construct($uid);
    }

    public $entityTypeUid;
    public $entityUid;
    public $user;
    public $timestamp;
}
