<?php 
include_once 'connectdb.php';


$q1_vatable_sales = $_POST['q1_vatable_sales'];
$q1_purchase_decleration = $_POST['q1_purchase_decleration'];
$q1_vat_total_expense = $_POST['q1_vat_total_expense'];
$q1_total_non_vat_expense = $_POST['q1_total_non_vat_expense'];

$q1_vatable_sales_accessory = $q1_vatable_sales * 0.12;
$q1_purchase_decleration = $q1_purchase_decleration * 0.12;
$q1_vat_expense_accessory = $q1_vat_total_expense * 0.12;



$output['q1_vatable_sales_accessory'] = number_format($q1_vatable_sales_accessory,2);
$output['q1_purchase_decleration_accessory'] = number_format($q1_purchase_decleration,2);
$output['q1_vat_expense_accessory'] = number_format($q1_vat_expense_accessory,2);
$output['total_vat_purchase_principal'] = number_format($_POST['q1_purchase_decleration']+$_POST['q1_vat_total_expense'],2);
$output['total_vat_purchase_accessory'] = number_format($q1_purchase_decleration + $q1_vat_expense_accessory,2);
$output['q1_total_non_vat_expense'] = number_format($q1_total_non_vat_expense,2);

echo json_encode($output);

?>