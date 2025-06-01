<?php 
include_once 'connectdb.php';
include_once 'function.php';

function fetch_gross_purchase($pdo,$id)
{
	$select = $pdo->prepare("SELECT SUM(total) as total_gross_purchase FROM tb_account_customer_data where account_customer_id = '$id' ");
	$select->execute();
	$row = $select->fetch(PDO::FETCH_OBJ);

	return $row->total_gross_purchase;
}

function fetch_total_payment($pdo,$id)
{
	$select = $pdo->prepare("SELECT SUM(amount) as total_paid FROM tb_account_customer_payment where account_customer_id = '$id' ");
	$select->execute();
	$row = $select->fetch(PDO::FETCH_OBJ);

	return $row->total_paid;
}
	

	$data = array();

	$select = $pdo->prepare("SELECT * FROM tb_account_customer");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		$subdata=array();


		$gross_purchase = fetch_gross_purchase($pdo,$row->id);
		$total_payment = fetch_total_payment($pdo,$row->id);
		$outstanding_balance  = $gross_purchase - $total_payment;

		$subdata[]= '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
		$subdata[]= '<center>
						<font class="text-black" size="2">
							<a href="accounts_receivables_view_customer.php?id='.$row->id.'">'.$row->name.'</a>
						</font>
					</center>';
		$subdata[]= '<center><font class="text-black"   size="2">'.strtoupper($row->code).'</font></center>';
		$subdata[]= '<center><font class="text-black"   size="2">'.number_format($gross_purchase,2).'</font></center>';
		$subdata[]= '<center><font class="text-success" size="2">'.number_format($total_payment,2).'</font></center>';
		$subdata[]= '<center><font class="text-black"   size="2">2</font></center>';
		$subdata[]= '<center><font class="text-danger"  size="2">'.number_format($outstanding_balance,2).'</font></center>';
		$subdata[]= '
		<center>
			<div class="btn-group">

				<a href="accounts_receivables_view_customer.php?id='.$row->id.'" title="View supplier data" class="btn btn-primary btn-sm">
					<span class="fa fa-eye"></span>
				</a>

				<a href="accounts_receivables_edit_customer.php?id='.$row->id.'" title="Edit supplier data" class="btn btn-success btn-sm">
					<span class="fa fa-edit"></span>
				</a>


				<button class="btn btn-danger btn-sm text-white" title="Delete data" data-id='.$row->id.' id="accounts_receivable_delete_customer">
					<span class="fa fa-trash"></span>
				</button>

			</div>
		</center> ';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);


				// <button class="btn btn-warning btn-sm text-white" title="Add data" data-id='.$row->id.' id="accounts_payables_add_data">
				// 	<span class="fa fa-plus"></span>
				// </button>


?>