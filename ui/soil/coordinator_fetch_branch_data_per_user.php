<?php 
include_once 'connectdb.php';
include_once 'function.php';
session_start();

$useridphp = $_GET['useridphp'];
$businessid = $_GET['businessid'];

	$data = array();



	$select = $pdo->prepare("SELECT * FROM tb_coordinator WHERE business_id = '$businessid' AND user_id = '$useridphp' ");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		$selectbranch = $pdo->prepare("SELECT * FROM tb_tax_branch WHERE id = '".$row->branch_id."' ");
		$selectbranch->execute();
		$rowbranch = $selectbranch->fetch(PDO::FETCH_OBJ);

		$subdata=array();

		$subdata[]= '<center>'.$row->id.'</center>';
		$subdata[]= '<center>'.$rowbranch->address.'</center>';
		$subdata[]= '<center>'.$rowbranch->tin.'</center>';
		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);



?>