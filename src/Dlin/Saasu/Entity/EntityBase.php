<?php
namespace Dlin\Saasu\Entity;

class EntityBase

{
    //common entity fields
    public $uid;
    public $lastUpdatedUid;
    public $utcLastModified;


    //name of the entity
    private $_entityName;


    /**
     * Constructor
     *
     * @param null $uid
     */
    public function __construct($uid = null)
    {
        $this->uid = $uid;
        $class = explode('\\', get_class($this));
        $this->_entityName = lcfirst(end($class));

    }

    /**
     * This magic setter is used in fromXML method to hydrate entity with the xxxUid field
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value){

        if($name == $this->getName().'Uid' && $value !== null){

            $this->uid = $value;
        }
    }

    public function __get($name){
        if($name == $this->getName().'Uid'){
            return $this->uid;
        }
    }


    /**
     * Return the name of the entity.
     *
     * This is used in the webservice URI for some services e.g. get a invoice
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->_entityName;
    }


    /**
     * Out put xml
     *
     * @param \XMLWriter $oXMLout
     * @param bool $withRoot
     * @return string
     */
    public function toXML(&$oXMLout = null)
    {
        if ($oXMLout === null) {
            $oXMLout = new \XMLWriter();
            $oXMLout->openMemory();
            $oXMLout->setIndent(true);
            $oXMLout->setIndentString('    ');
        }

        $func = function ($obj, $basename = null) use (&$func, &$oXMLout) {
            $className = explode('\\', get_class($obj));

            $className = $basename ? $basename : lcfirst(end($className));

            $oXMLout->startElement($className);

            $vars = get_object_vars($obj);


            //move uid and updateid to the begining
            $vars = array('uid' => $vars['uid'], 'lastUpdatedUid' => $vars['lastUpdatedUid']) + $vars;


            foreach ($vars as $key => $value) {

                if ($value === null || strpos($key, '_') === 0) {
                    continue;
                }

                if (is_array($value)) {
                    $oXMLout->startElement($key);
                    foreach ($value as $subValue) {
                        if ($subValue instanceof EntityBase) {
                            $func($subValue);
                        }
                    }
                    $oXMLout->endElement();

                } elseif ($value instanceof EntityBase) {
                    $func($value, $key);

                } elseif ($key == 'uid' || $key == 'lastUpdatedUid') {
                    if ($value != '') {
                        $oXMLout->writeAttribute($key, $value);
                    }
                } else {
                    $oXMLout->writeElement($key, (string)$value);
                }
            }
            $oXMLout->endElement();

        };

        $func($this);

        $string = $oXMLout->outputMemory();

        return $string;

    }

    /**
     *
     * Load data from given xml
     *
     * @param $xml
     */
    public function fromXML($xml)
    {


        $func = function ($xmlElement, &$entity) use (&$func) {


            $vars = array_keys(get_object_vars($entity));

            //add a dummy field, that is used in XXXXListResponse
            $vars[] = $this->getName().'Uid';

            foreach ($vars as $fieldName) {
                if ( strpos($fieldName, '_') === 0) {
                    continue;
                }

                if (is_array($entity->$fieldName)) {

                    foreach ($xmlElement->$fieldName as $child) {
                        foreach ($child as $cname => $c) {
                            $subClass = __NAMESPACE__ . '\\' . ucfirst($cname);
                            $obj = new $subClass();
                            $func($c, $obj);
                            $entity->{$fieldName}[] = $obj;
                        }
                    }


                } else if (is_object($entity->$fieldName) && $xmlElement->$fieldName) {

                    $func($xmlElement->$fieldName, $entity->$fieldName);

                } else if (trim((string)$xmlElement->$fieldName) != '') {
                    $entity->$fieldName = (string)$xmlElement->$fieldName;
                } else if (trim((string)$xmlElement[$fieldName]) != '') {
                    $entity->$fieldName = (string)$xmlElement[$fieldName];
                } else {
                    $entity->$fieldName = null;
                }


            }


        };

        $xmlElement = simplexml_load_string($xml);
        $func($xmlElement, $this);


    }


}
