<?php
include_once 'connectdb.php';
include_once 'function.php';


$cwt_percent = $_POST['cwt_percent'];
$net_of_vat_amount_hidden = $_POST['net_of_vat_amount_hidden'];
$cwt_percent = $cwt_percent / 100;

$withholding_amount = $cwt_percent * $net_of_vat_amount_hidden;




$output['withholding_amount'] = number_format($withholding_amount,2);
$output['withholding_amount_hidden'] = number_format($withholding_amount,2,'.','');

// $output['net_of_vat'] = number_format($net_of_vat,2);
// $output['net_of_vat_hidden'] = number_format($net_of_vat,2,'.','');

echo json_encode($output);

?>
