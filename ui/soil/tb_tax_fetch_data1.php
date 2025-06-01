<?php
include_once 'connectdb.php';
include_once 'function.php';


$customerid = $_POST['id'];

$select = $pdo->prepare("SELECT * FROM tb_tax_customer where id = '$customerid' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$output['tin'] = $row->tin;
$output['address'] = $row->address;
$output['description'] = $row->name;


echo json_encode($output);

?>