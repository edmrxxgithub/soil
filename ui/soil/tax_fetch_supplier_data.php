<?php 
include_once 'connectdb.php';

$supplierid = $_POST['id'];

$select = $pdo->prepare("SELECT * FROM tb_tax_supplier WHERE id = '$supplierid' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);


$output['supplierid'] = $supplierid;
$output['tin'] = $row->tin;
$output['address'] = $row->address;

echo json_encode($output);

?>