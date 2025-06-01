<?php 
include_once 'connectdb.php';
include_once 'function.php';
// session_start();
// $userid = $_SESSION['userid'];

	$data = array();

	$datenow = date('Y-m-d');

	$select = $pdo->prepare("SELECT * FROM tb_bank");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		$bankid = $row->id;

		$numcheck = $pdo->prepare("SELECT * FROM tb_check WHERE bank_id = '$bankid' ");
		$numcheck->execute();
		$totalcheck = $numcheck->rowCount();

		$bankdata = checksdata($pdo,$row->id,$datenow);
		
		$subdata=array();

		$subdata[]= '<center>'.$row->id.'</center>';
		$subdata[]= '<center>'.$row->name.'</center>';
		$subdata[]= '<center>'.$row->account_num.'</center>';
		$subdata[]= '<center><font class="text-success">'.number_format($bankdata['totaloverall'],2).'</font></center>';
		$subdata[]= '<center><font class="text-black">'.$totalcheck.'</font></center>';
		$subdata[]= '
		<center>
			<div class="btn-group">

				<a href="bank_account_details.php?id='.$row->id.'&datenow='.$datenow.'" class="btn btn-primary btn-sm"><span class="fa fa-eye"  data-toggle="tooltip" title="Edit Bank Account" ></span></a>

				<a href="bank_edit_account.php?id='.$row->id.'" class="btn btn-success btn-sm"><span class="fa fa-edit"  data-toggle="tooltip" title="Edit Bank Account" ></span></a>

			</div>
		</center>';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);



?>