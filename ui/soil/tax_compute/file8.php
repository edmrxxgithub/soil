<?php 
include_once '../connectdb.php';
include_once 'function2.php';

$year_now = $_POST['year_now'];
$branch_id = $_POST['branch_id'];
$quarter_num = $_POST['quarter_num'];

// echo $year_now.' '.$branch_id.' '.$quarter_num;

// quarter_num	branch_id	year_num

$delete = $pdo->prepare("DELETE FROM tb_tax_return_by_quarter WHERE  quarter_num = '$quarter_num' AND branch_id = '$branch_id' AND year_num = '$year_now' ");
$delete->execute();

?>