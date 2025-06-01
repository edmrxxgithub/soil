<?php 
include_once 'connectdb.php';

$id = $_POST['id'];

$delete = $pdo->prepare("DELETE FROM tb_payee where id = $id");
$delete->execute();

?>