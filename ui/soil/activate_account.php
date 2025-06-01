<?php 
include_once 'connectdb.php';

$id = $_POST['id'];

$update = $pdo->prepare("UPDATE tb_user SET status = '1' where id = $id");
$update->execute();

?>