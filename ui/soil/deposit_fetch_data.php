<?php 
include_once 'connectdb.php';
include_once 'function.php';
// session_start();

// $userid = $_SESSION['userid'];

	$data = array();



	$select = $pdo->prepare("SELECT * FROM tb_deposit");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		$select1 = $pdo->prepare("SELECT * FROM tb_bank WHERE id = '".$row->bank_id."' ");
		$select1->execute();
		$row1 = $select1->fetch(PDO::FETCH_OBJ);

		$subdata=array();

		$subdata[]= '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
		$subdata[]= '<center><font class="text-black" size="2"><a href="bank_account_details.php?id='.$row->bank_id.'">'.$row1->name.' - '.$row1->account_num.'</font></center>';
		$subdata[]= '<center><font class="text-black" size="2">'.$row->description.'</font></center>';
		$subdata[]= '<center><font class="text-black" size="2">'.$row->date.'</font></center>';
		$subdata[]= '<center><font class="text-success" size="2">'.number_format($row->amount,2).'</font></center>';
		$subdata[]= '
		<center>
			<div class="btn-group">

				<a href="deposit_edit.php?id='.$row->id.'" class="btn btn-primary btn-sm"><span class="fa fa-edit"  data-toggle="tooltip" title="Edit check" ></span></a>

				<button data-id='.$row->id.'  class="btn btn-danger btn-sm" id="btn_delete_deposit"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete deposit" ></span></button>

			</div>
		</center>';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);

// <button data-id='.$row->id.'  class="btn btn-success btn-sm" id="btn_change_status"><span class="fas fa-bell" style="color:#ffffff" data-toggle="tooltip" title="Delete check" ></span></button>

?>