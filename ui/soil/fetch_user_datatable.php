<?php 
include_once 'connectdb.php';
include_once 'function.php';
session_start();

$userid = $_SESSION['userid'];

	$data = array();



	$select = $pdo->prepare("SELECT * FROM tb_user WHERE id != '$userid' ");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		$userlevelname = user_level($pdo,$row->user_level_id);

		if ($row->status == 1) 
		{
			$status = '<center><span class="badge badge-success">Active</span></center>';
			$button = '<button data-id='.$row->id.'  class="btn btn-danger btn-sm" id="btn_deactivate_user"><span class="fa fa-times" style="color:#ffffff" data-toggle="tooltip" title="Delete Account" ></span></button>';
		}
		else
		{
			$status = '<center><span class="badge badge-danger">Deactivated</span></center>';
			$button = '<button data-id='.$row->id.'  class="btn btn-success btn-sm" id="btn_activate_user"><span class="fa fa-check" style="color:#ffffff" data-toggle="tooltip" title="Delete Account" ></span></button>';
		}

		
		
		$subdata=array();

		$subdata[]= '<center>'.$row->id.'</center>';
		$subdata[]= '<center>'.$row->username.'</center>';
		$subdata[]= '<center>'.$row->name.'</center>';
		$subdata[]= '<center>'.$userlevelname.'</center>';
		$subdata[]= $status;
		$subdata[]= '
		<center>
			<div class="btn-group">

				<a href="edit_account.php?id='.$row->id.'" class="btn btn-primary btn-sm"><span class="fa fa-edit"  data-toggle="tooltip" title="Edit Account" ></span></a>

				'.$button.'

			</div>
		</center>';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);



?>