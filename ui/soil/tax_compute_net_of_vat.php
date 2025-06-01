<?php 
include_once 'connectdb.php';

$gross_amount = $_POST['gross_amount'];


$output['gross_amount'] = $gross_amount;
$output['gross_amount_decimal'] = number_format($gross_amount,2);

echo json_encode($output);

?>