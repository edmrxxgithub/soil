<?php
include_once 'connectdb.php';
include_once 'function.php';

$id = $_POST['id'];

// $delete = $pdo->prepare("DELETE FROM tb_tax_sales WHERE id = '$id' ");
$delete = $pdo->prepare("DELETE FROM tb_tax_purchase WHERE id = '$id' ");
$delete->execute();

?>