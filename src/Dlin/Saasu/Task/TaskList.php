<?php
/**
 * 
 * User: davidlin
 * Date: 28/05/13
 * Time: 5:58 AM
 * 
 */
namespace Dlin\Saasu\Task;


class TaskList {

    public $tasks;


    public function __construct(){
        $this->tasks = array();
    }

    public function add(Task $task){
        $this->tasks[] = $task;
        $task->list = $this;
    }

    public function getTaskAt($i){
        return $this->tasks[$i];
    }


    /**
     * Return the xml of the task list
     *
     * @return string
     */
    public function toXML(){

            $oXMLout = new \XMLWriter();
            $oXMLout->openMemory();
            $oXMLout->setIndent(true);
            $oXMLout->setIndentString('    ');


        $oXMLout->startDocument("1.0", 'utf-8');
        $oXMLout->startElement('tasks');

        /**
         * @var \Dlin\Saasu\Task\Task $task
         */
        foreach($this->tasks as $task){
           $oXMLout->writeRaw("\n".$task->toXML());
        }
        $oXMLout->endElement();
        $oXMLout->endDocument();

        $xml = $oXMLout->outputMemory();

        return $xml;
    }





}