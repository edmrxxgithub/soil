<?php 
include_once 'connectdb.php';
include_once 'function.php';
session_start();

$userid = $_SESSION['userid'];

	$data = array();



	$select = $pdo->prepare("SELECT * FROM tb_property_category ");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{
		
		$total_carrying_amount = fetch_property_total_carrying_amount_all_category($pdo);
		$itemcount = fetch_property_item_count($pdo,$row->id);


		$carryingamount = fetch_property_carrying_amount($pdo,$row->id);
		$percentage = $carryingamount /  $total_carrying_amount ;
		$percentage = $percentage * 100;
		$percentage = number_format($percentage,2).'%';


		// $carryingamount = 0;
		// $percentage = 0;
		// $percentage = 0;
		// $percentage = 0;

		$subdata=array();

		$subdata[]= '<center>'.$row->id.'</center>';
		$subdata[]= '<center>
						<image src="images/'.$row->image.'" class="img-rounded" width="40px" height="40px/">
					</center>';
					
		$subdata[]= '<center>
							<a href="property_category_details.php?id='.$row->id.'">'.$row->name.'</a>
					</center>';


		$subdata[]= '<center>'.$itemcount.'</center>';
		$subdata[]= '<center><span class="text-black">'.number_format($carryingamount,2).'</span></center>';
		$subdata[]= '<center>'.$percentage.'</center>';
		$subdata[]= '
		<center>
			<div class="btn-group">

				<a href="property_category_details.php?id='.$row->id.'" class="btn btn-primary btn-sm"><span class="fa fa-eye"  data-toggle="tooltip" title="View Category" ></span></a>

				<a href="property_edit_category.php?id='.$row->id.'" class="btn btn-success btn-sm"><span class="fa fa-edit"  data-toggle="tooltip" title="Edit Category" ></span></a>

			</div>
		</center>';


		// $subdata[]= '<center>'.$row->id.'</center>';
		// $subdata[]= '<center>'.$row->id.'</center>';
		// $subdata[]= '<center>'.$row->id.'</center>';

		// $subdata[]= '<center>'.$row->id.'</center>';
		// $subdata[]= '<center>'.$row->id.'</center>';
		// $subdata[]= '<center>'.$row->id.'</center>';
		// $subdata[]= '<center>'.$row->id.'</center>';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);



?>