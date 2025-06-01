<?php
include_once 'connectdb.php';
include_once 'function.php';


$gross_amount = $_POST['gross_amount'];
$vat_percent = $_POST['vat_percent'];

if ($vat_percent != 0) 
{
	$net_of_vat = $gross_amount / $vat_percent;
	$total_vat = $gross_amount - $net_of_vat;

	$output['vat_percent'] = $vat_percent;
	$output['total_vat'] = number_format($total_vat,2);
	$output['net_of_vat'] = number_format($net_of_vat,2);
	$output['net_of_vat_hidden'] = $net_of_vat;
}
else
{
	$output['vat_percent'] = $vat_percent;
	$output['total_vat'] = number_format(0,2);
	$output['net_of_vat'] = number_format($gross_amount,2);
	$output['net_of_vat_hidden'] = $gross_amount;
}


echo json_encode($output);

?>
