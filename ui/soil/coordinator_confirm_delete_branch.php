<?php 
include_once 'connectdb.php';


$id = $_POST['id'];

$delete = $pdo->prepare("DELETE FROM tb_coordinator WHERE id = '$id' ");
$delete->execute();

?>