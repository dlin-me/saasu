<?php
/**
 *
 * User: davidlin
 * Date: 15/06/13
 * Time: 12:48 AM
 *
 */

namespace Dlin\Saasu\Criteria;


abstract class CriteriaBase
{

    public abstract function getEntityClass();


    /**
     * This is the returned entity name.
     *
     * @return string
     */
    public function getEntityName(){
        $fullClass = $this->getEntityClass();
        $class = explode('\\', $fullClass);
        $entityName = lcfirst(array_pop($class));
        return $entityName;
    }

    /**
     *
     * This resolve the name used as the list api url path, by default it will be like entityName + 'List'
     *
     * In special cases like FullInventoryCriteria, the list is a bit different from the default which is deprecated.
     * this method is overwritten to return the right name.
     *
     * @return string
     */
    public function getEntityListName(){
        return $this->getEntityName()."List";
    }
}