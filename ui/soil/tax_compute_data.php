<?php 
include_once 'connectdb.php';


$cwt_percent = $_POST['cwt_percent'];
$net_of_vat = $_POST['net_of_vat'];

$cwt_percent = $_POST['cwt_percent'];
$net_of_vat_amount_hidden = $_POST['net_of_vat'];
$cwt_percent = $cwt_percent / 100;

$withholding_amount = $cwt_percent * $net_of_vat_amount_hidden;

echo number_format($withholding_amount,2);

?>