<?php
namespace Dlin\Saasu\Entity;

class EntityBase
{
    public $uid;
    public $lastUpdatedUid;
    public $utcLastModified;


    /**
     * Out put xml
     *
     * @param \XMLWriter $oXMLout
     * @param bool $withRoot
     * @return string
     */
    public function toXML()
    {

        $oXMLout = new \XMLWriter();
        $oXMLout->openMemory();
        $oXMLout->setIndent(true);
        $oXMLout->setIndentString('    ');


        $func = function ($obj, $basename = null) use (&$func, &$oXMLout) {
            $className = explode('\\', get_class($obj));

            $className = $basename ? $basename : lcfirst(end($className));

            $oXMLout->startElement($className);

            $vars = get_object_vars($obj);
            foreach ($vars as $key => $value) {
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
                } else {
                    $oXMLout->writeElement($key, $value);
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

            foreach ($vars as $fieldName) {

                if (is_array($entity->$fieldName)) {

                    foreach ($xmlElement->$fieldName as $child) {
                        foreach ($child as $cname => $c) {
                            $subClass = __NAMESPACE__ . '\\' . ucfirst($cname);
                            $obj = new $subClass();
                            $func($c, $obj);
                            $entity->{$fieldName}[] = $obj;
                        }
                    }


                } else if (is_object($entity->$fieldName)) {

                    $func($xmlElement->$fieldName, $entity->$fieldName);

                } else if (trim((string)$xmlElement->$fieldName) != '') {
                    $entity->$fieldName = (string)$xmlElement->$fieldName;
                }


            }


        };

        $xmlElement = simplexml_load_string($xml);
        $func($xmlElement, $this);


    }


}
