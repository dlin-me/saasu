<?php
/**
 *
 * User: davidlin
 * Date: 28/05/13
 * Time: 6:02 AM
 *
 */
namespace Dlin\Saasu\Task;

use Dlin\Saasu\Entity\EntityBase;

class TaskResult extends EntityBase
{


    //$uid; //for delete result,create buildCombo

    public $updatedEntityUid; //for update
    public $insertedEntityUid; //for create



    //for insert invoice only
    public $sentToContact;
    public $generatedInvoiceNumber;
    public $generatedPurchaseOrderNumber;




    public function updateEntity(EntityBase &$entity){


        if($this->lastUpdatedUid){
            $entity->lastUpdatedUid = $this->lastUpdatedUid;
        }

        if($this->insertedEntityUid){
            $entity->uid = $this->insertedEntityUid;
        }

        if($this->utcLastModified){
            $entity->utcLastModified = $this->utcLastModified;
        }

    }



}