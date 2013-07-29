<?php
/**
 *
 * User: davidlin
 * Date: 1/06/13
 * Time: 11:58 PM
 *
 */

namespace Dlin\Saasu\Enum;


/**
 * Class ActivityAttachedToType
 * @package Dlin\Saasu\Enum
 * @see \Dlin\Saasu\Entity\Activity::attachedToType
 */
class ActivityAttachedToType extends BaseEnum
{
    const Contact = 'Contact';
    const Sale = 'Sale';
    const Purchase = 'Purchase';
    const Employee = 'Employee';

}