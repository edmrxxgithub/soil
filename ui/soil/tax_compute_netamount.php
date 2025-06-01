<?php
include_once 'connectdb.php';
include_once 'function.php';


$gross_amount = $_POST['gross_amount'];

$netamount = $gross_amount / 1.12;


$vat = $gross_amount - $netamount;


$output['netamount'] = number_format($netamount,2);
$output['vat'] = number_format($vat,2);
$output['netamount2'] = number_format($netamount,2,'.','');
$output['vat2'] = number_format($vat,2,'.','');

// number_format($qty, 2, '.', '');

echo json_encode($output);

?>
