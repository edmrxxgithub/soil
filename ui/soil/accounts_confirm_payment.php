<?php 
include_once 'connectdb.php';
session_start();

function fetch_account_supplier_id($pdo,$id)
{
	$select = $pdo->prepare("SELECT * FROM tb_account_supplier_data where id = '$id' ");
	$select->execute();
	$row = $select->fetch(PDO::FETCH_OBJ);

	return $row->account_supplier_id;

}

$id = $_POST['payableid'];
$date = $_POST['payables_date'];
$reference = $_POST['payables_reference'];
$amount = $_POST['payables_amount'];
$user_id = $_SESSION['userid'];
$timestamp = date("Y-m-d H:i:s");

$account_supplier_id = fetch_account_supplier_id($pdo,$id);


$insert = $pdo->prepare("INSERT INTO tb_account_supplier_payment 

SET 

account_supplier_id	= '$account_supplier_id' ,
account_supplier_data_id	= '$id' ,
date	= '$date' ,
reference_num	= '$reference' ,
amount	= '$amount' ,
created_at	= '$timestamp' ,
user_id	= '$user_id' ");

if ($insert->execute()) 
{
	// echo 'success!';
}
else
{
	// echo 'fail!';
}


echo $_POST['payableid'];



?>