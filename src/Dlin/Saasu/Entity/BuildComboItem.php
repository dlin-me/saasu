<?php
/**
 *
 * User: davidlin
 * Date: 22/06/13
 * Time: 11:59 PM
 *
 */

namespace Dlin\Saasu\Entity;
use Dlin\Saasu\Validator\Validator;

/**
 *
 * Class BuildComboItem
 * This class is only for buiding combo item.
 *
 * This is  NOT an entity but an operation though it extends the EntityBase class
 * When saving by the api, the operation is done and the given quantity of combo item is built;
 * Other operation other than 'save' is not supported and Sassu API will return error
 *
 * @package Dlin\Saasu\Action
 */
class BuildComboItem extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
        $this->_entityName = 'BuildComboItem';
        $this->_uidPosition = 'element';
    }

    /**
     * Override the default so that operations have empty save operation name
     *
     * @return string
     */
    public function getSaveOperationName()
    {
        return "";
    }

    public $quantity;

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