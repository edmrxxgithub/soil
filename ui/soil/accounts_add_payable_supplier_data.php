<?php 
include_once 'connectdb.php';
session_start();

$id = $_POST['payableid_hidden'];
$date = $_POST['supplier_date'];
$invoice_num = $_POST['supplier_invoice_num'];
$qty = $_POST['supplier_qty'];
$price = $_POST['supplier_price'];
$total = $_POST['supplier_total_hidden'];
$user_id = $_SESSION['userid'];
$timestamp = date("Y-m-d H:i:s");


$net_of_vat = $total / 1.12;
$vat = $total - $net_of_vat;


$insert = 

$pdo->prepare("INSERT INTO tb_account_supplier_data SET

account_supplier_id  = '$id' , 
date = '$date' , 
invoice_num = '$invoice_num' , 
qty = '$qty' , 
price = '$price' , 
total = '$total' , 
vat = '$vat' , 
net_of_vat = '$net_of_vat' , 
created_at = '$timestamp' , 
user_id = '$user_id' , 
status  = '0' ");



	if ($insert->execute()) 
	{
		echo 'success';
	}
	else
	{
		echo 'fail';
	}


?>