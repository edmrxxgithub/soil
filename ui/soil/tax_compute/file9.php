<?php 
include_once '../connectdb.php';
include_once 'function2.php';

$quarter = $_POST['quarter'];
$yearnow = $_POST['yearnow'];
$branchid = $_POST['branchid'];


echo $quarter.' '.$yearnow.' '.$branchid;

$delete = $pdo->prepare("DELETE FROM tb_tax_return_by_quarter WHERE quarter_num = '$quarter' AND branch_id = '$branchid' AND year_num = '$yearnow' ");
$delete->execute();

?>