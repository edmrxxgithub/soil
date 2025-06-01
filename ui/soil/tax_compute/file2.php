<?php 
include_once '../connectdb.php';
include_once 'function2.php';

$total_payment = $_POST['total_payment'];
$year_now = $_POST['year_now'];
$branch_id = $_POST['branch_id'];
$quarter_num = 1;




$delete = $pdo->prepare("DELETE  FROM tb_tax_return_by_quarter WHERE quarter_num = '$quarter_num' AND branch_id = '$branch_id' AND year_num = '$year_now' ");
$delete->execute();



$insert = $pdo->prepare("INSERT INTO tb_tax_return_by_quarter SET quarter_num = '$quarter_num', branch_id = '$branch_id', year_num = '$year_now', payment_risk = '$total_payment' ");
$insert->execute();


echo 'success!';

?>