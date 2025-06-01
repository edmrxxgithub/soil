<?php
include_once 'connectdb.php';
include_once 'function.php';

$id = $_POST['id'];

$select = $pdo->prepare("SELECT * FROM tb_tax_supplier where id = '$id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

echo $row->tin;

?>