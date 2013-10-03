<?php
/**
 *
 * User: davidlin
 * Date: 28/05/13
 * Time: 11:55 PM
 *
 */

namespace Dlin\Saasu;


use Dlin\Saasu\Criteria\CriteriaBase;
use Dlin\Saasu\Entity\EntityBase;
use Dlin\Saasu\Task\Task;
use Dlin\Saasu\Task\TaskList;
use Dlin\Saasu\Task\TaskResult;
use Dlin\Saasu\Util\Throttler;
use Guzzle\Http\Message\Response;

class SaasuAPI
{

    // const SERVICE_URL = "https://secure.saasu.com/webservices/rest/r1/Tasks?wsaccesskey={WSAccessKey}&FileUid={FileUid}";

    protected $wsUrl;

    protected $wsKey;

    protected $wsFileUid;

    protected $throttler;

    public function __construct($ws_access_key, $file_uid, $ws_url = 'https://secure.saasu.com/webservices/rest/r1/')
    {
        $this->wsUrl = $ws_url;
        $this->wsKey = $ws_access_key;
        $this->wsFileUid = $file_uid;
        $this->client = new \Guzzle\Service\Client($this->wsUrl);
        $this->throttler = new Throttler(5, 1);
    }

    public function checkException(Response $response)
    {
        $xml = $response->xml();
        $exceptionXmls = $xml->xpath('//error');
        foreach($exceptionXmls as $exceptionXml)
        {
            $message = $exceptionXml->message;
            throw new \Exception(strval($exceptionXml->type) . ' - ' . $message);
        }

        return $this;
    }





    /**
     *
     * Save changes of an existing entity or add a new entity to Saasu Service API
     *
     * @param EntityBase $entity
     * @return $this
     */
    public function saveEntity(\Dlin\Saasu\Entity\EntityBase $entity, $option=null)
    {
        $this->throttler->throttle();

        $taskList = new TaskList();
        $task = new Task($entity, $option);
        $taskList->add($task);
        $xml = $taskList->toXML();

        $url = $this->_buildURL('Tasks', array());

        $response = $this->client->post($url, null, $xml)->send();


        $this->checkException($response);

        foreach ($response->xml()->children() as $result) {
            $taskResult = new TaskResult();
            $taskResult->fromXML($result->asXML());
            $task->setResult($taskResult);
            break;
        }


        return $this;
    }


    /**
     * Save/create multiple entities at the same time.
     *
     * Entities could be of different type, update and create operation can mix together
     *
     * @param array $entities
     * @return array a list of TasksResults
     */
    public function saveEntities(array $entities)
    {
        $this->throttler->throttle();
        $taskList = new TaskList();
        /**
         * @var \Dlin\Saasu\Entity\EntityBase $entity
         */
        foreach ($entities as $entity) {
            $task = new Task($entity);
            $taskList->add($task);
        }

        $xml = $taskList->toXML();
        $url = $this->_buildURL('Tasks', array());

        $response = $this->client->post($url, null, $xml)->send();

        $counter = 0;
        $res = array();
        foreach ($response->xml()->children() as $result) {

            $taskResult = new TaskResult();
            $taskResult->fromXML($result->asXML());
            $res[] = $taskResult;

            $taskList->getTaskAt($counter)->setResult($taskResult);

            $counter++;

        }

        return $res;
    }


    private function _buildURL($base, array $queries)
    {
        $p = array();

        $p['fileuid'] = $this->wsFileUid;
        $p['wsaccesskey'] = $this->wsKey;

        foreach ($queries as $key => $value) {
            $p[$key] = $value;
        }

        return $base . '?' . http_build_query($p);
    }

    /**
     *
     * Load data from the API for the given Entity.
     *
     * $entity must be an existing Entity with a UID set
     *
     * @param \Dlin\Saasu\Entity\EntityBase $entity
     * @param array $query
     */
    public function loadEntity(\Dlin\Saasu\Entity\EntityBase $entity, array $query=null)
    {
        $this->throttler->throttle();
        $uid = $entity->uid;
        $query = is_array($query)?$query:array();
        if (intval($uid) > 0) { //load data from remote service
            $query['uid'] = $uid;
            $url = $this->_buildURL($entity->getName(), $query);

            $response = $this->client->get($url)->send();

            //check exception in response
            $this->checkException($response);
            //otherwise populate the $entity
            $entityXML = $response->xml()->{$entity->getName()}->asXML();
            $entity->fromXML($entityXML);
        }

        return $this;
    }


    /**
     * Delete an entity
     *
     * @param Entity\EntityBase $entity
     * @return $this
     */
    public function deleteEntity(\Dlin\Saasu\Entity\EntityBase $entity)
    {
        $this->throttler->throttle();
        $uid = $entity->uid;
        if (intval($uid) > 0) { //load data from remote service
            $url = $this->_buildURL($entity->getName(), array('uid' => $uid));

            $response = $this->client->delete($url)->send();

            //check exception in response
            $this->checkException($response);
        }
        return $this;

    }


    /**
     * Return a list of Entities that matches the given criteria
     *
     * @param $criteria
     * @return array
     */
    public function searchEntities(CriteriaBase $criteria)
    {
        $this->throttler->throttle();
        $query = $criteria ? get_object_vars($criteria) : array();
        $fullClass = $criteria->getEntityClass();
        $class = explode('\\', $fullClass);
        $entityName = lcfirst(array_pop($class));

        $url = $this->_buildURL($entityName . 'List', $query);echo $url; exit;
        $response = $this->client->get($url)->send();
        //check exception in response
        $this->checkException($response);



        $entityXMLItems = $response->xml()->{$entityName . 'List'}->{$entityName};
        if(!$entityXMLItems){
            $entityXMLItems = $response->xml()->{$entityName . 'List'}->{$entityName. 'ListItem'};
        }

        $res = array();

        /**
         * @var \Dlin\Saasu\Entity\EntityBase $entity
         */
        foreach ($entityXMLItems as $item) {
            $entity = new $fullClass();
            $entity->fromXML($item->asXML());
            $res[] = $entity;
        }
        return $res;

    }


}