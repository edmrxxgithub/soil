<?php 
include_once 'connectdb.php';
include_once 'function.php';

function fetch_sales_data($pdo,$id)
{

	// $select1 = $pdo->prepare("SELECT * FROM tb_tax_sales WHERE id = '$id' ");
	$select1 = $pdo->prepare("SELECT * FROM tb_tax_purchase WHERE id = '$id' ");
	$select1->execute();
	$row1 = $select1->fetch(PDO::FETCH_OBJ);

	$clientid = $row1->client_id;
	$businessid = $row1->business_id;
	$branchid = $row1->branch_id;

	$select2 = $pdo->prepare("SELECT * FROM tb_tax_client WHERE id = '$clientid' ");
	$select2->execute();
	$row2 = $select2->fetch(PDO::FETCH_OBJ);

	$select3 = $pdo->prepare("SELECT * FROM tb_tax_business WHERE id = '$businessid' ");
	$select3->execute();
	$row3 = $select3->fetch(PDO::FETCH_OBJ);

	$select4 = $pdo->prepare("SELECT * FROM tb_tax_branch WHERE id = '$branchid' ");
	$select4->execute();	
	$row4 = $select4->fetch(PDO::FETCH_OBJ);	
	
	if ($row4) 
	{
		$address = $row4->address;
	}
	else
	{
		$address = '-';
	}
	


	$array['clientname'] = $row2->name;
	$array['businessname'] = $row3->name;
	$array['branchname'] = $address;
	// $array['clientname'] = 'sample client name';

	return $array;

}


	$data = array();

	$select = $pdo->prepare("SELECT * FROM tb_tax_purchase");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{


		$salesdata = fetch_sales_data($pdo,$row->id);

		$yearnow = date('Y');

		$payable = $row->gross_amount - $row->withholding_total_cwt - $row->withholding_total_vwt;

		$subdata=array();

		$subdata[]= '<center><font class="text-black" size="2">'.$row->id.'</font></center>';

		$subdata[]= '<center>
						<font class="text-black" size="2">
							'.$row->date.'
						</font>
					</center>';


		$subdata[]= '<center><font class="text-black" size="2">'.$row->client_id.'</font></center>';
		$subdata[]= '<center><font class="text-black" size="2">'.$row->business_id.'</font></center>';
		$subdata[]= '<center><font class="text-black" size="2">'.$row->branch_id.'</font></center>';

		$subdata[]= '<center>
						<font class="text-black" size="2">
								<a href="tax_view_client.php?id='.$row->client_id.'" target="_blank">'.$salesdata['clientname'].'</a>
						</font>
					</center>';

		$subdata[]= '<center>
							<font class="text-black" size="2">
								<a href="tax_view_client_business.php?id='.$row->business_id.'" target="_blank">'.$salesdata['businessname'].'</a>
							</font>
					</center>';


		$subdata[]= '<center>
							<font class="text-black" size="2">
								<a href="tax_view_branch_data.php?id='.$row->branch_id.'&yearnow='.$yearnow.'" target="_blank">'.$salesdata['branchname'].'</a>
							</font>
					</center>';


		// $subdata[]= '<center>
		// 				<font class="text-black" size="2">
		// 					'.$row->date.'
		// 				</font>
		// 			</center>';

		
		$subdata[] = '<center><font style="color:rgb(6, 61, 119);" size="2">'.number_format($row->gross_amount, 2).'</font></center>';
		$subdata[] = '<center><font style="color:rgb(142, 8, 11);" size="2">'.number_format($row->vat, 2).'</font></center>';
		$subdata[] = '<center><font style="color:rgb(55, 142, 55);" size="2">'.number_format($row->net_amount, 2).'</font></center>';
	    $subdata[] = '<center><font style="color:rgb(177, 149, 59);" size="2">'.number_format($row->withholding_total_cwt, 2).'</font></center>';
	    $subdata[] = '<center><font style="color:rgb(177, 149, 59);" size="2">'.number_format($row->withholding_total_vwt, 2).'</font></center>';
    	$subdata[] = '<center><font class="text-black" size="2">'.number_format($payable, 2).'</font></center>';
		

		$subdata[]= '
		<center>
			<div class="btn-group">

				<a href="tax_view_purchase2.php?id='.$row->id.'"  class="btn btn-primary btn-sm">
						<span class="fa fa-list"  data-toggle="tooltip" title="Edit" ></span>
				</a>

				<a href="tax_edit_purchase3.php?id='.$row->id.'" class="btn btn-success btn-sm"><span class="fa fa-edit"  data-toggle="tooltip" title="Edit" ></span></a>

				<button data-id='.$row->id.'  class="btn btn-danger btn-sm" id="btn_delete_purchase"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete" ></span></button>

			</div>
		</center>';

		
	    $data[]=$subdata;


	}


	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);



?>