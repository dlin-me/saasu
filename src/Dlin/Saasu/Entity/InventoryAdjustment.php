<?php 
namespace Dlin\Saasu\Entity;
    
    class InventoryAdjustment extends EntityBase
    {

        public $date;
        
        public $tags;
        
        public $summary;
        
        public $notes;
        
        public $requiresFollowUp = false;
        
        
        public $items = array();
    }
