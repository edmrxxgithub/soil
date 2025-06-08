<?php 
include_once 'connectdb.php';
include_once 'function.php';
session_start();

	$useridphp = $_GET['userid'];


	$data = array();

	$select = $pdo->prepare("SELECT * FROM tb_coordinator WHERE user_id = '$useridphp' ");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{
		$branchdata = fetch_branch_data($pdo,$row->branch_id);
		
		$subdata=array();

		$subdata[]= '<center>'.$row->id.'</center>';
		$subdata[]= '<center>'.$branchdata['clientname'].'</center>';
		$subdata[]= '<center>'.$branchdata['businessname'].'</center>';
		$subdata[]= '<center>'.$branchdata['branchname'].'</center>';
		$subdata[]= '
		<center>
			<div class="btn-group">


				<button data-id='.$row->id.'  class="btn btn-danger btn-sm" id="coordinator_delete_branch"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete check" ></span></button>

			</div>
		</center>';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);



?>