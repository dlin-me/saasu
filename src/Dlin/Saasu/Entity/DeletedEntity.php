<?php
namespace Dlin\Saasu\Entity;

/**
 * This is returned from the service. It does not need validation
 *
 * Class DeletedEntity
 * @package Dlin\Saasu\Entity
 */
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
