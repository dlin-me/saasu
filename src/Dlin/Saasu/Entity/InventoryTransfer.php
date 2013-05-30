<?php 
namespace Dlin\Saasu\Entity;
    
    class InventoryTransfer extends EntityBase
    {
        
        public $date;
        
        public $tags;
        
        public $summary;
        
        public $notes;
        
        public $requiresFollowUp = false;
        
        
        public $items = array();
    }
