<?php 
include_once 'connectdb.php';

$id = $_POST['id'];

$delete = $pdo->prepare("DELETE FROM tb_deposit where id = $id");
$delete->execute();

?>