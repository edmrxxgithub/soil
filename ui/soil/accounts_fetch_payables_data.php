<?php 
include_once 'connectdb.php';
include_once 'function.php';

	$supplier_id = $_GET['supplier_id'];	

	function fetch_total_paid($pdo,$id)
	{

		$select = $pdo->prepare("SELECT SUM(amount) as total_paid FROM tb_account_supplier_payment where account_supplier_data_id = '$id' ");
		$select->execute();
		$row = $select->fetch(PDO::FETCH_OBJ);

		return $row->total_paid;
	}
	



	$data = array();

	$select = $pdo->prepare("SELECT * FROM tb_account_supplier_data where account_supplier_id = '$supplier_id' ");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		$subdata=array();

		$total = $row->qty * $row->price;
		

		$total_paid = fetch_total_paid($pdo,$row->id);
		$outstanding_balance = $total - $total_paid;
		

		$subdata[]= '<center>
						<font class="text-black" size="2">'.$row->id.'</font>
					</center>';
		
		$subdata[]= '<center>
						<font class="text-black" size="2" id="view_payables" data-id='.$row->id.'><a href="#">'.$row->date.'</a></font>
					</center>';

		$subdata[]= '<center>
						<font class="text-black" size="2">'.$row->invoice_num.'</font>
					</center>';


		$subdata[]= '<center>
						<font class="text-black" size="2">'.$row->qty.'</font>
					</center>';

		$subdata[]= '<center>
						<font class="text-black" size="2">'.number_format($row->price,2).'</font>
					</center>';
					
		$subdata[]= '<center>
						<font class="text-black" size="2">'.number_format($total,2).'</font>
					</center>';
					

		// $subdata[]= '<center>
		// 				<font class="text-black" size="2">'.number_format($vat,2).'</font>
		// 			</center>';


		// $subdata[]= '<center>
		// 				<font class="text-black" size="2">'.number_format($net_of_vat,2).'</font>
		// 			</center>';


		$subdata[]= '<center>
						<font class="text-success" size="2">'.number_format($total_paid,2).'</font>
					</center>';

		$subdata[]= '<center>
						<font class="text-danger" size="2">'.number_format($outstanding_balance,2).'</font>
					</center>';


		$subdata[]= '
		<center>
			<div class="btn-group">

				<button class="btn btn-primary btn-sm text-white" title="View" data-id='.$row->id.' id="view_payables">
					<span class="fa fa-eye"></span>
				</button>

				<button class="btn btn-success btn-sm text-white" title="Edit" data-id='.$row->id.' id="edit_payables">
					<span class="fa fa-edit"></span>
				</button>

				<button class="btn btn-danger btn-sm text-white" title="Delete data" data-id='.$row->id.' id="accounts_payables_delete_data">
					<span class="fa fa-trash"></span>
				</button>

			</div>
		</center> ';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);

// <button class="btn btn-warning btn-sm text-white" title="Pay" data-id='.$row->id.' id="pay_payables">
// 	<span class="fa fa-plus"></span>
// </button>

?>