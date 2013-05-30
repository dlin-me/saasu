<?php
/**
 *
 * User: davidlin
 * Date: 28/05/13
 * Time: 5:53 AM
 *
 */

namespace Dlin\Saasu\Task;

use Dlin\Saasu\Entity\EntityBase;

class Task
{

    const TASK_TYPE_INSERT = 'insert';
    const TASK_TYPE_UPDATE = 'update';
    const TASK_TYPE_BUILD = 'build'; //comboitem

    public $taskType; //either 'insert' or 'update'

    public $result; //the result object

    public $attributes; //task related attributes

    /**
     * @var \Dlin\Saasu\Entity\EntityBase
     */
    public $entity;


    public $list; //the list this task is in, every task must be in a list before execution


    /**
     *
     * Constructor
     * @param $type
     */
    public function __construct($type, EntityBase $entity)
    {


        $this->entity = $entity;

        if (self::TASK_TYPE_INSERT == $type || self::TASK_TYPE_UPDATE == $type) {
            $this->taskType = $type;
        }

    }


    /**
     * Get the xml of the task
     *
     * @return string
     */
    public function toXML()
    {


        $oXMLout = new \XMLWriter();
        $oXMLout->openMemory();
        $oXMLout->setIndent(true);
        $oXMLout->setIndentString('    ');

        $className = explode('\\', get_class($this->entity));

        $className = lcfirst(end($className));

        $nodeName = ucfirst($this->taskType) . ucfirst($className);

        $oXMLout->startElement($nodeName);
        $oXMLout->writeRaw($this->entity->toXML());
        $oXMLout->endElement();

        $string = $oXMLout->outputMemory();

        return $string;

    }


}