<?php 
include_once 'connectdb.php';

$checkid = $_POST['checkid'];
$statusid = $_POST['statusid'];

$update = $pdo->prepare("UPDATE tb_check SET status_id = '$statusid' WHERE id = '$checkid' ");
$update->execute();

echo 'success!'

?>