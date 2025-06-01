<?php 
include_once 'connectdb.php';
include_once 'function.php';

	$businessid = $_GET['businessid'];

	function fetch_num($pdo,$branchid)
	{
		$select1 = $pdo->prepare("SELECT * FROM tb_tax_sales where branch_id = '$branchid' ");
		$select1->execute();
		$sales_num = $select1->rowCount();

		$select1 = $pdo->prepare("SELECT * FROM tb_tax_purchase where branch_id = '$branchid' ");
		$select1->execute();
		$purchase_num = $select1->rowCount();


		$array['sales_num'] = $sales_num;
		$array['purchase_num'] = $purchase_num;


		return $array;
	}


	

	$data = array();

	$yearnow = date('Y');

	$select = $pdo->prepare("SELECT * FROM tb_tax_branch WHERE business_id = '$businessid' ");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{
		
		$num_data = fetch_num($pdo,$row->id);

		$subdata=array();

		$subdata[]= '<center>'.$row->id.'</center>';

		$subdata[]= '<center>
						<a href="tax_view_branch_data.php?id='.$row->id.'&yearnow='.$yearnow.'">
							'.$row->address.'
						</a>
					</center>';
		$subdata[]= '<center>'.$row->tin.'</center>';

		$subdata[]= '<center>'.$num_data['sales_num'].'</center>';
		$subdata[]= '<center>'.$num_data['purchase_num'].'</center>';

		// $subdata[]= '<center>'.$row->id.'</center>';
		// $subdata[]= '<center>'.$row->id.'</center>';

		$subdata[]= '
		<center>
			<div class="btn-group">

				<a href="tax_view_branch_data.php?id='.$row->id.'&yearnow='.$yearnow.'" class="btn btn-primary btn-sm"><span class="fa fa-eye"  title="View" ></span></a>

				<a href="tax_edit_branch.php?id='.$row->id.'" class="btn btn-success btn-sm"><span class="fa fa-edit"  title="Edit" ></span></a>

				

			</div>
		</center>';

		
	    $data[]=$subdata;


	}


	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);

// <button data-id='.$row->id.'  class="btn btn-danger btn-sm" id="btndeletebranch"><span class="fa fa-trash" style="color:#ffffff"  title="Delete" ></span></button>

?>










