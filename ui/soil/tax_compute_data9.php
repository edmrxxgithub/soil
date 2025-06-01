<?php 
include_once 'connectdb.php';

$simulation_total_q1 = $_POST['simulation_total_q1'];
$q1_computation_data1 = $_POST['q1_computation_data1'];
$q1_vatable_sales = $_POST['q1_vatable_sales'];

$ttlf = $q1_computation_data1 - $simulation_total_q1;
$ttlf2 = $ttlf / 0.12;

$benchmark = $simulation_total_q1 / $q1_vatable_sales;

$output['ttlf'] =  number_format($ttlf,2);
$output['ttlf2'] =  number_format($ttlf2,2);
$output['benchmark'] = number_format($benchmark * 100,2,'.','');

echo json_encode($output);

?>