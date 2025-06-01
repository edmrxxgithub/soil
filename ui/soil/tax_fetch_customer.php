<?php 
include_once 'connectdb.php';
include_once 'function.php';

// session_start();
// $userid = $_SESSION['userid'];

	$data = array();

	$select = $pdo->prepare("SELECT * FROM tb_tax_customer");
	// $select = $pdo->prepare("SELECT * FROM tb_tax_supplier");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		$subdata=array();

		$subdata[]= '<center>'.$row->id.'</center>';
		$subdata[]= '<left><font size="3">'.$row->name.'</font></left>';
		$subdata[]= '<center><font size="3">'.$row->tin.'</font></center>';
		$subdata[]= '<left><font size="3">'.$row->address.'</font></left>';
		
		$subdata[]= '
		<center>
			<div class="btn-group">

				<a href="tax_edit_customer.php?id='.$row->id.'" class="btn btn-success btn-sm"><span class="fa fa-edit"  data-toggle="tooltip" title="Edit customer" ></span></a>

			</div>
		</center>';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);



?>