<?php

$simulation_total = $_POST['simulation_total'];
$simulation_total_hidden = $_POST['simulation_total_hidden'];
$vatable_sales_total_hidden = $_POST['vatable_sales_total_hidden'];


$total = $simulation_total_hidden - $simulation_total;
$calculated_risk = $total / 0.12;


$benchmark = $simulation_total / $vatable_sales_total_hidden;

$benchmark_percent = $benchmark * 100;
$benchmark_percent = number_format($benchmark_percent,2).'%';


$output['total'] = number_format($total,2);
$output['calculated_risk'] = number_format($calculated_risk,2);
$output['benchmark_percent'] = $benchmark_percent;

echo json_encode($output);

?>