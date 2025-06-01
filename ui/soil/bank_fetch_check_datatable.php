<?php 
include_once 'connectdb.php';
include_once 'function.php';
// session_start();
// $userid = $_SESSION['userid'];

$datenow = date('Y-m-d');

	$data = array();



	$select = $pdo->prepare("SELECT * FROM tb_check");
	$select->execute();
	while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	{

		$bankname_accountnum = bank_name($pdo,$row->bank_id);
		$status = status_name($pdo,$row->status_id);
		$payeename = payee_name($pdo,$row->payee_id);


		$subdata=array();

		$subdata[]= '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
		$subdata[]= '<center>
						<font class=="text-black" size="2">
							<a href="bank_account_details.php?id='.$row->bank_id.'&datenow='.$datenow.'">'.$bankname_accountnum.'</a>
						</font>
					</center>';

		$subdata[]= '<center><font class="text-black" size="2">'.$payeename.'</font></center>';
		$subdata[]= '<center><font class="text-black" size="2">'.$row->check_num.'</font></center>';

		$subdata[]= '<center><font class="text-success" size="2">'.number_format($row->amount,2).'</font></center>';
		$subdata[]= '<center><font class="text-black" size="2">'.$row->check_date.'</font></center>';
		$subdata[]= '<center><font class="text-black" size="2">'.$status.'</font></center>';

		$subdata[]= '
		<center>
			<div class="btn-group dropdown">

				<a class="btn btn-warning btn-sm" data-toggle="dropdown" href="#">
			        <span class="fa fa-list" title="Change check status" ></span>
			    </a>

				<a href="bank_check_edit.php?id='.$row->id.'" class="btn btn-primary btn-sm"><span class="fa fa-edit"  data-toggle="tooltip" title="Edit check" ></span></a>

				<button data-id='.$row->id.'  class="btn btn-danger btn-sm" id="btn_delete_check"><span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete check" ></span></button>

			    <div class="dropdown-menu dropdown-menu-right">

			        <button class="dropdown-item text-primary" title="Pending" data-id="'.$row->id.'" id="pendingstatus">Pending</button>

			        <button class="dropdown-item text-success" title="Clear"   data-id="'.$row->id.'" id="clearstatus">Clear</button>

			        <button class="dropdown-item text-warning" title="Hold" data-id="'.$row->id.'" id="holdstatus">Hold</button>

			        <button class="dropdown-item text-danger" title="Cancel" data-id="'.$row->id.'" id="cancelstatus">Cancel</button>
			    </div>

			</div>
			
		</center>';

		
	    $data[]=$subdata;


	}





	$return_arr=array("data" =>  $data);
	echo json_encode($return_arr);

// <button data-id='.$row->id.'  class="btn btn-success btn-sm" id="btn_change_status"><span class="fas fa-bell" style="color:#ffffff" data-toggle="tooltip" title="Delete check" ></span></button>

?>