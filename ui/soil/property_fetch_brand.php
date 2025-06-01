<?php 
include_once 'connectdb.php';
include_once 'function.php';
// session_start();

// $userid = $_SESSION['userid'];

	$data = array();



	$select = $pdo->prepare("SELECT * FROM tb_property_brand");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		
		$subdata=array();

		$subdata[]= '<center>'.$row->id.'</center>';
		$subdata[]= '<center>'.$row->name.'</center>';
		$subdata[]= '
		<center>
			<div class="btn-group">

				<a href="property_brand_edit.php?id='.$row->id.'" class="btn btn-primary btn-sm"><span class="fa fa-edit"  data-toggle="tooltip" title="Edit Payee" ></span></a>

			</div>
		</center>';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);



?>