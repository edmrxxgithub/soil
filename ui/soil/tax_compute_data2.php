<?php 
include_once 'connectdb.php';

$q1_government_sales = $_POST['q1_government_sales'];
$q1_vatable_sales = $_POST['q1_vatable_sales'];

$total1 = $q1_vatable_sales - $q1_government_sales;
$total1_new = $total1 * 0.12;

$total2 = $q1_government_sales * 0.12;

$output['q1_vatable_sales_accessory'] = number_format($total1_new,2);
$output['q1_government_accessory'] = number_format($total2,2);
$output['q1_vatable_sales_principal'] = number_format($total1,2);

echo json_encode($output);

?>