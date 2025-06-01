<?php 
include_once 'connectdb.php';

$id = $_POST['id'];

$update = $pdo->prepare("DELETE FROM tb_account_supplier  where id = $id");
$update->execute();

?>