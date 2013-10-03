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

$api = new SaasuAPI('7A358B66371C47C7AEA26A2517B8D3D3', '44208');

$c = new \Dlin\Saasu\Criteria\FullInventoryItemCriteria();
$return = $api->searchEntities($c);

print_r($return);