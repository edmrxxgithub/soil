<?php
include_once 'connectdb.php';

$yearnow = $_POST['year_now_data3'];
$branchid = $_POST['branch_id_data3'];
$fnlcomputation = $_POST['q1_computation_data1'];

$select = $pdo->prepare("SELECT * FROM tb_tax_return WHERE branch_id = '$branchid' AND year_num = '$yearnow' AND quarter_num = 1 ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

if ($row) 
{
	$calculated_risk = $row->calculated_risk;
	$calculated_risk_percent = $calculated_risk * 0.12;
	$final_computation = $fnlcomputation - $calculated_risk_percent;
}
else
{
	$calculated_risk = 0;
	$calculated_risk_percent = 0;
	$final_computation = 0;
}

$output['calculated_risk'] = number_format($calculated_risk,2);
$output['calculated_risk_percent'] = number_format($calculated_risk_percent,2);
$output['final_computation'] = number_format($final_computation,2,'.','');

echo json_encode($output);

?>