<?php
/**
 *
 * User: davidlin
 * Date: 28/05/13
 * Time: 6:02 AM
 *
 */
namespace Dlin\Saasu\Task;

class TaskResult
{

    public $uid; //for delete result,create buildCombo
    public $updatedEntityUid;
    public $insertedEntityUid;
    public $LastUpdatedUid;
    public $utcLastModified;

    //for insert invoice only
    public $sentToContact;
    public $generatedInvoiceNumber;
}