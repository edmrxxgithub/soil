<?php
include_once 'connectdb.php';

$id = $_POST['id'];


$select = $pdo->prepare("SELECT * FROM tb_account_supplier_payment where id = '$id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);


echo $row->account_supplier_data_id;

$delete = $pdo->prepare("DELETE FROM tb_account_supplier_payment where id = '$id' ");
$delete->execute();




?>