<?php
require_once("functions.php");

$requests = $_GET;
$hmac = $_GET['hmac'];
$serializeArray = serialize($requests);
$requests = array_diff_key($requests, array('hmac' => ''));
ksort($requests);

$token = PASTE YOUR GENERATED TOKEN HERE
$shop = PASTE YOUR SHOP URL HERE
