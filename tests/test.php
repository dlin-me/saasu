<?php
/**
 * 
 * User: davidlin
 * Date: 8/06/13
 * Time: 1:24 PM
 * 
 */

$a = array();
$a['a'] = 1;
$a['b'] = 2;

//$arr = array();

$arr[] = (true or false) ? 'yes':'no';

$a['c'] = $arr;

print_r($a);

echo json_encode($a);