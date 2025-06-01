<?php
include_once 'connectdb.php';
include_once 'function.php';
session_start();


$gross = 7889;
$net_amount = $gross / 1.12;
$vat = $gross - $net_amount;

echo $gross.' '.$net_amount.' '.$vat;

?>















