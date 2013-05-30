<?php
/**
 * 
 * User: davidlin
 * Date: 28/05/13
 * Time: 11:55 PM
 * 
 */

class SaasuAPI {

    const SERVICE_URL = "https://secure.saasu.com/webservices/rest/r1/Tasks?wsaccesskey={WSAccessKey}&FileUid={FileUid}";

    protected $wsUrl = "https://secure.saasu.com/webservices/rest/r1/";

    protected $wsKey;

    protected $wsFileUid;

    public function __construct($ws_url, $ws_access_key, $file_uid){
        $this->wsUrl = $ws_url;
        $this->wsKey = $ws_access_key;
        $this->wsFileUid = $file_uid;
    }

    /**
     *
     * Save changes of an existing entity or add a new entity to Saasu Service API
     *
     * @param \Dlin\Saasu\Entity\EntityBase $entity
     * @return \Dlin\Saasu\Task\TaskResult a TaskResult
     */
    public function saveEntity(\Dlin\Saasu\Entity\EntityBase $entity){
        return new TaskResult();
    }

    /**
     * Save/create multiple entities at the same time.
     *
     * Entities could be of different type, update and create operation can mix together
     *
     * @param array $entities
     * @return array a list of TasksResults
     */
    public function saveEntities(array $entities){
        return array();
    }





    /**
     *
     * Load data from the API for the given Entity.
     *
     * $entity must be an existing Entity with a UID set
     *
     * @param \Dlin\Saasu\Entity\EntityBase $entity
     */
    public function syncEntity(\Dlin\Saasu\Entity\EntityBase $entity){

    }



    public function getEntityList(\Dlin\Saasu\Entity\EntityBase $entity){
            return array();
    }

}