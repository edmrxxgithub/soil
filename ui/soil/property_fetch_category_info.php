<?php 
include_once 'connectdb.php';
include_once 'function.php';
session_start();

$userid = $_SESSION['userid'];

	$data = array();

	$id = $_GET['id'];


	$select = $pdo->prepare("SELECT * FROM tb_property_data WHERE category_id = '$id' ");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		$user_name = fetch_property_user($pdo,$row->property_user_id);
		$brandname = fetch_property_brand($pdo,$row->brand_id);

		$date1 = $row->acq_date;
		$date2 = date("Y-m-d");

		$departmentname = fetch_department_name($pdo,$row->department_id);

		// Convert to timestamps
		$timestamp1 = strtotime($date1);
		$timestamp2 = strtotime($date2);

		// $difference = abs($timestamp2 - $timestamp1);
		// $years = $difference / (365 * 24 * 60 * 60);
		// $numberofyears = (int)$years;
		// $depreciation_amount = $row->price / $row->eul;
		// $depreciation_amountf = $depreciation_amount * $numberofyears;
		// $carrying_amount = $row->price - $depreciation_amountf;


		$difference = abs($timestamp2 - $timestamp1);
		$years = $difference / (365 * 24 * 60 * 60);
		$numberofyears = (int)$years;

		if ($row->eul != 0) 
		{
		    $depreciation_amount = $row->price / $row->eul;
		    $depreciation_amountf = $depreciation_amount * $numberofyears;
		    $carrying_amount = $row->price - $depreciation_amountf;
		} 
		else 
		{
		    // Handle the case when EUL is zero (e.g., set values to 0 or log an error)
		    $depreciation_amount = 0;
		    $depreciation_amountf = 0;
		    $carrying_amount = $row->price; // Or set to 0 depending on your logic
		}



		$subdata=array();

		$subdata[]= '<center><font size="2">'.$row->id.'</font></center>';
		$subdata[]= '<center><font size="2">'.$row->acq_date.'</font></center>';
		$subdata[]= '<center><font size="2">'.$user_name.'</font></center>';


		$subdata[]= '<center><font size="2">'.$departmentname.'</font></center>';
		$subdata[]= '<center><font size="2">'.$brandname.'</font></center>';
		$subdata[]= '<center><font size="2">'.$row->model_num.'</font></center>';


		$subdata[]= '<center><font size="2" class="text-success">'.number_format($row->price,2).'</font></center>';
		$subdata[]= '<center><font size="2">'.$row->eul.'</font></center>';
		$subdata[]= '<center><font size="2" class="text-warning">'.number_format($depreciation_amount,2).'</font></center>';
		$subdata[]= '<center><font size="2" class="text-danger">'.number_format($depreciation_amountf,2).'</font></center>';
		$subdata[]= '<center><font size="2">'.number_format($carrying_amount,2).'</font></center>';
		$subdata[]= '<center><font size="2">'.$row->status.'</font></center>';

		$subdata[]= '
		<center>
			<div class="btn-group">
				<a href="property_category_info_edit.php?id='.$row->id.'" class="btn btn-primary btn-sm"><span class="fa fa-edit"  data-toggle="tooltip" title="Edit" ></span></a>

				<button class="btn btn-danger btn-sm" data-id="'.$row->id.'" id="btndeletepropertydata"><span class="fa fa-trash" title="Delete"></button>
			</div>
		</center>';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);



?>