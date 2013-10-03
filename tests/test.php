<?php
/**
 * 
 * User: davidlin
 * Date: 8/06/13
 * Time: 1:24 PM
 * 
 */

include 'bootstrap.php';

use Dlin\Saasu\SaasuAPI;

$api = new SaasuAPI('', '');

$c = new \Dlin\Saasu\Criteria\FullInventoryItemCriteria();
$api->searchEntities($c);