<?php
include_once 'connectdb.php';

// Get POST values
$simulation_total = $_POST['simulation_total_q1'];
$total1 = $_POST['q1_computation_data1'];
$yearnow = $_POST['year_now_data3'];
$branchid = $_POST['branch_id_data3'];
$quarter_num = 1;

// Calculate risk
$calculated_risk = $total1 - $simulation_total;

if ($calculated_risk != 0) 
{
    $calculated_risk = number_format($calculated_risk / 0.12, 2, '.', '');
} else 
{ 
    $calculated_risk = 0;
}

// Check if record exists
$select = $pdo->prepare("SELECT COUNT(*) AS total_count FROM tb_tax_return WHERE branch_id = :branch_id AND year_num = :yearnow AND quarter_num = :quarter_num");
$select->execute([
    ':branch_id' => $branchid,
    ':yearnow' => $yearnow,
    ':quarter_num' => $quarter_num
]);

$row = $select->fetch(PDO::FETCH_OBJ);
$totalcount = $row ? $row->total_count : 0;

// Perform insert or update
if ($totalcount > 0) {
    $update = $pdo->prepare("UPDATE tb_tax_return SET calculated_risk = :calculated_risk WHERE branch_id = :branch_id AND year_num = :yearnow AND quarter_num = :quarter_num");
    $update->execute([
        ':calculated_risk' => $calculated_risk,
        ':branch_id' => $branchid,
        ':yearnow' => $yearnow,
        ':quarter_num' => $quarter_num
    ]);
    
} else {
    $insert = $pdo->prepare("INSERT INTO tb_tax_return (calculated_risk, branch_id, year_num, quarter_num) VALUES (:calculated_risk, :branch_id, :yearnow, :quarter_num)");
    $insert->execute([
        ':calculated_risk' => $calculated_risk,
        ':branch_id' => $branchid,
        ':yearnow' => $yearnow,
        ':quarter_num' => $quarter_num
    ]);
    
}

echo $calculated_risk;




?>