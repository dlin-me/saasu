<?php
/**
 * 
 * User: davidlin
 * Date: 22/06/13
 * Time: 11:59 PM
 * 
 */

namespace Dlin\Saasu\Entity;

/**
 *
 * Class Tag
 * This class is only for assisting the TagList query
 *
 * @package Dlin\Saasu\Entity
 */
class Tag extends EntityBase
{
    public function __construct($uid = null)
    {
        parent::__construct($uid);
    }

    public $name;
}