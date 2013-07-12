<?php
/**
 *
 * User: davidlin
 * Date: 22/06/13
 * Time: 11:59 PM
 *
 */

namespace Dlin\Saasu\Entity;
use Dlin\Saasu\Task\Task;
use Dlin\Saasu\Validator\Validator;

/**
 *
 * Class Tag
 * This class is only for buiding combo item.
 *
 * This is technically NOT a entity
 * However when saving, the given quantity of combo item is built;
 * Other operation other than 'save' is not supported and Sassu API will return error
 *
 * @package Dlin\Saasu\Entity
 */
class BuildComboItem extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
    }

    public $quantity;

    /**
     * Override the default so that it can only 'build' a combo item
     *
     * @return string
     */
    public function getSaveOperationName()
    {
        return Task::TASK_TYPE_BUILD;
    }

    /**
     *
     * @return $this|Validator
     */
    public function validate()
    {
        return Validator::instance()->
            lookAt($this->uid, 'uid')->required(true)->
            lookAt($this->quantity, 'quantity')->required(true)->int()->gt(0);
    }
}