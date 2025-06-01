<?php 
include_once 'connectdb.php';
include_once 'function.php';

// session_start();
// $userid = $_SESSION['userid'];

	$data = array();

	$select = $pdo->prepare("SELECT * FROM tb_tax_client");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		$select1 = $pdo->prepare("SELECT * FROM tb_tax_business WHERE client_id = '".$row->id."' ");
		$select1->execute();
		$num_of_business = $select1->rowCount();

		$subdata=array();

		$subdata[]= '<center>'.$row->id.'</center>';
		$subdata[]= '<left>
						<a href="tax_view_client.php?id='.$row->id.'">'.$row->name.'</a>
					</left>';
		$subdata[]= '<center>'.$num_of_business.'</center>';
		$subdata[]= '<center>'.$row->tin.'</center>';
		$subdata[]= '<left>'.$row->address.'</left>';
		
		$subdata[]= '
		<center>
			<div class="btn-group">

				<a href="tax_view_client.php?id='.$row->id.'" class="btn btn-primary btn-sm"><span class="fa fa-eye"  data-toggle="tooltip" title="View Client" ></span></a>

				<a href="tax_edit_client.php?id='.$row->id.'" class="btn btn-success btn-sm"><span class="fa fa-edit"  data-toggle="tooltip" title="Edit Client" ></span></a>

			</div>
		</center>';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);



?>