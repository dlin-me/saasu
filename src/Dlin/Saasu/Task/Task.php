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
use Dlin\Saasu\Entity\Invoice;
use Dlin\Saasu\Entity\InvoiceInstruction;

class Task
{

    const TASK_TYPE_INSERT = 'insert';
    const TASK_TYPE_UPDATE = 'update';

    public $taskType; //either 'insert' or 'update'


    public $attributes; //task related attributes

    /**
     * @var \Dlin\Saasu\Entity\EntityBase
     */
    public $entity;

    /**
     * @var \Dlin\Saasu\Entity\InvoiceInstruction Only applicable for invoice entity
     */
    protected $option;


    public $list; //the list this task is in, every task must be in a list before execution


    /**
     * @var \Dlin\Saasu\Task\TaskResult
     */
    private $_result;



    /**
     * @param \Dlin\Saasu\Task\TaskResult $result
     */
    public function setResult($result)
    {
        $this->_result = $result;
        $result->updateEntity($this->entity);
    }



    /**
     * @return \Dlin\Saasu\Task\TaskResult
     */
    public function getResult()
    {
        return $this->_result;
    }



    /**
     *
     * Constructor
     * @param $entity EntityBase
     * @param $option \Dlin\Saasu\Entity\InvoiceInstruction Only applicable when Entity is an invoice
     */
    public function __construct(EntityBase &$entity, $option=null)
    {

        $this->entity = $entity;
        $this->taskType = $entity->getSaveOperationName();
        $this->option = $option;

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

        $nodeName = lcfirst(($this->taskType) . ucfirst($className));

        $oXMLout->startElement($nodeName);

        if($this->entity instanceof Invoice && $this->option && $this->option instanceof InvoiceInstruction){
            $oXMLout->writeAttribute("emailToContact", $this->option->emailToContact);
            if($this->option->templateUid > 0){
                $oXMLout->writeElement('templateUid', $this->option->templateUid);
            }
            if($this->option->emailMessage){
                $oXMLout->writeRaw( "\n".$this->option->emailMessage->toXML());
            }
        }


        $oXMLout->writeRaw("\n".$this->entity->toXML());

        $oXMLout->endElement();

        $string = $oXMLout->outputMemory();

        return $string;

    }


}