<?php 
include_once 'connectdb.php';

$id = $_POST['id'];


// id
// name
// address
// contact_num
// tin
// code

$select = $pdo->prepare("SELECT * FROM tb_account_supplier where id = '$id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$output['id'] = $id;
$output['name'] = $row->name;
$output['address'] = $row->address;
$output['contact_num'] = $row->contact_num;
$output['tin'] = $row->tin;
$output['code'] = $row->code;



echo json_encode($output);

?>