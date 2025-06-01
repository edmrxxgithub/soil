<?php

function fetch_department_name($pdo,$id)
{
	$select = $pdo->prepare("SELECT * FROM tb_property_department WHERE id = '$id' ");
	$select->execute();
	$row = $select->fetch(PDO::FETCH_OBJ);

	return $row->name;
}

function fetch_bank_data_status($pdo,$datefrom,$dateto,$bankid)
{
	$select1 = $pdo->prepare("SELECT * FROM tb_deposit WHERE date BETWEEN '$datefrom' AND '$dateto' AND bank_id = '$bankid' ");
	$select1->execute();
	$deposit_row_count = $select1->rowCount();

	$select2 = $pdo->prepare("SELECT * FROM tb_check WHERE check_date BETWEEN '$datefrom' AND '$dateto' AND status_id = '2' AND bank_id = '$bankid' ");
	$select2->execute();
	$withdraw_row_count = $select2->rowCount();

	if ($deposit_row_count != '0' || $withdraw_row_count != '0') 
	{
		$status = 1;
	}
	else
	{
		$status = 0;
	}

	return $status;
}

function fetch_bank_deposit_withdraw_overall($pdo,$days_in_a_month,$monthnow,$yearnow)
{
	$datefrom = $yearnow.'-'.$monthnow.'-1';
	$dateto = $yearnow.'-'.$monthnow.'-'.$days_in_a_month;

	$select4 = $pdo->prepare("SELECT SUM(amount) as total_month_withdraw FROM tb_check WHERE status_id = '2' AND check_date BETWEEN '$datefrom' AND '$dateto' ");
	$select4->execute();
	$row4 = $select4->fetch(PDO::FETCH_OBJ);

	$select5 = $pdo->prepare("SELECT SUM(amount) as total_month_deposit FROM tb_deposit WHERE date BETWEEN '$datefrom' AND '$dateto' ");
	$select5->execute();
	$row5 = $select5->fetch(PDO::FETCH_OBJ);

	$array['datefromto'] = $datefrom.' - '.$dateto;
	$array['totalwithdraw'] = $row4->total_month_withdraw;
	$array['totaldeposit'] = $row5->total_month_deposit;

	return $array;

}

function fetch_bank_dashboard_data($pdo,$yearnow)
{	
	// $yearnow = date('Y');
	$monthnow = date("m");
	$monthnow_word = date('F');
	$days_in_a_month = date("t", strtotime("$yearnow-$monthnow-01"));

	$datefrom = $yearnow.'-'.$monthnow.'-1';
	$dateto = $yearnow.'-'.$monthnow.'-'.$days_in_a_month;

	$select = $pdo->prepare("SELECT * FROM tb_bank");
	$select->execute();
	$totalbank = $select->rowCount();

	$select1 = $pdo->prepare("SELECT * FROM tb_check");
	$select1->execute();
	$totalcheck = $select1->rowCount();

	$select2 = $pdo->prepare("SELECT SUM(amount) as total_withdraw FROM tb_check WHERE check_date BETWEEN '$datefrom' AND '$dateto' AND status_id = '2' ");
	$select2->execute();
	$row2 = $select2->fetch(PDO::FETCH_OBJ);

	$select3 = $pdo->prepare("SELECT SUM(amount) as total_deposit FROM tb_deposit WHERE date BETWEEN '$datefrom' AND '$dateto'  ");
	$select3->execute();
	$row3 = $select3->fetch(PDO::FETCH_OBJ);

	$select4 = $pdo->prepare("SELECT SUM(amount) as total_overall_withdraw FROM tb_check WHERE status_id = '2' ");
	$select4->execute();
	$row4 = $select4->fetch(PDO::FETCH_OBJ);

	$select5 = $pdo->prepare("SELECT SUM(amount) as total_overall_deposit FROM tb_deposit  ");
	$select5->execute();
	$row5 = $select5->fetch(PDO::FETCH_OBJ);

	$array['totalbank'] = $totalbank;
	$array['totalcheck'] = $totalcheck;
	$array['datenow'] = $dateto;
	$array['totelwithdraw'] = $row2->total_withdraw;
	$array['totaldeposit'] = $row3->total_deposit;
	$array['monthnow_word'] = strtoupper($monthnow_word);
	$array['overall_balance'] = $row5->total_overall_deposit - $row4->total_overall_withdraw ;

	return $array;
}

function fetch_bank_deposit_withdraw($pdo,$days_in_a_month,$monthnownum,$yearnow,$bankid)
{
	$datefrom = $yearnow.'-'.$monthnownum.'-1';
	$dateto = $yearnow.'-'.$monthnownum.'-'.$days_in_a_month;

	$deposit = $pdo->prepare("SELECT SUM(amount) as deposit_amount FROM tb_deposit WHERE date BETWEEN '$datefrom' AND '$dateto' AND bank_id = '$bankid' ");
	$deposit->execute();
	$row1 = $deposit->fetch(PDO::FETCH_OBJ);


	$withdraw = $pdo->prepare("SELECT SUM(amount) as withdraw_amount FROM tb_check WHERE check_date BETWEEN '$datefrom' AND '$dateto' AND bank_id = '$bankid' AND status_id = '2' ");
	$withdraw->execute();
	$row2 = $withdraw->fetch(PDO::FETCH_OBJ);

	$array['deposit'] = $row1->deposit_amount;
	$array['withdraw'] = $row2->withdraw_amount;

	return $array;
}

function fetch_bank_balance($pdo,$id)
{
	$select1 = $pdo->prepare("SELECT SUM(amount) as deposit_amount FROM tb_deposit WHERE bank_id = '$id' ");
	$select1->execute();
	$row1 = $select1->fetch(PDO::FETCH_OBJ);

	$select2 = $pdo->prepare("SELECT SUM(amount) as deposit_amount FROM tb_check WHERE bank_id = '$id' ");
	$select2->execute();
	$row2 = $select2->fetch(PDO::FETCH_OBJ);

	$total_deposit = $row1->deposit_amount;
	$total_withdraw = $row2->deposit_amount;

	return $total_deposit - $total_withdraw;
}


function fetch_property_category_name($pdo,$id)
{

$select = $pdo->prepare("SELECT * FROM tb_property_category WHERE id = '$id' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

return $row->name;

}

function fetch_property_total_carrying_amount_all_category($pdo)
{

$carrying_amount = 0;
$totalamount = 0;

$select = $pdo->prepare("SELECT * FROM tb_property_data");
$select->execute();

while ($row = $select->fetch(PDO::FETCH_OBJ)) 
{
    $acqDate = $row->acq_date;
    $currentDate = date("Y-m-d");

    // Convert dates to timestamps
    $timestamp1 = strtotime($acqDate);
    $timestamp2 = strtotime($currentDate);

    // Calculate the number of full years between dates
    $yearsDifference = floor(abs($timestamp2 - $timestamp1) / (365 * 24 * 60 * 60));

    // Prevent division by zero
    if ($row->eul > 0) 
    {
        $depreciationPerYear = $row->price / $row->eul;
        $totalDepreciation = $depreciationPerYear * $yearsDifference;

        // Ensure depreciation doesn't exceed price
        if ($totalDepreciation > $row->price) 
        {
            $totalDepreciation = $row->price;
        }

        $carrying_amount = $row->price - $totalDepreciation;
    } else 
    {
        // If EUL is 0, assume full depreciation
        $carrying_amount = $row->price;
    }

    $totalamount += $carrying_amount;
}

return $totalamount;

}

function fetch_property_item_count($pdo,$id)
{
	$select = $pdo->prepare("SELECT * FROM tb_property_data WHERE category_id = '$id' ");
	$select->execute();
	$numcount = $select->rowCount();

	return $numcount;
}

function fetch_property_carrying_amount($pdo,$id)
{
	
$carrying_amount = 0;
$totalamount = 0;

// Use a parameterized query to avoid SQL injection
$select = $pdo->prepare("SELECT * FROM tb_property_data WHERE category_id = :id");
$select->execute(['id' => $id]);

while ($row = $select->fetch(PDO::FETCH_OBJ)) 
{
    $acqDate = $row->acq_date;
    $currentDate = date("Y-m-d");

    // Convert to timestamps
    $timestamp1 = strtotime($acqDate);
    $timestamp2 = strtotime($currentDate);

    // Calculate the number of full years between dates
    $yearsPassed = floor(abs($timestamp2 - $timestamp1) / (365 * 24 * 60 * 60));

    // Avoid division by zero for EUL (Estimated Useful Life)
    if ($row->eul > 0) {
        $annualDepreciation = $row->price / $row->eul;
        $totalDepreciation = $annualDepreciation * $yearsPassed;

        // Cap depreciation to not exceed the price
        if ($totalDepreciation > $row->price) 
        {
            $totalDepreciation = $row->price;
        }

        $carrying_amount = $row->price - $totalDepreciation;
    } else {
        // If EUL is zero, assume asset is fully depreciated
        $carrying_amount = $row->price;
    }

    $totalamount += $carrying_amount;
}

return $totalamount;


	// $carrying_amount = 0;
	// $totalamount = 0;

	// $select = $pdo->prepare("SELECT * FROM tb_property_data WHERE category_id = '$id' ");
	// $select->execute();
	// while ($row = $select->fetch(PDO::FETCH_OBJ)) 
	// {
	// 	$date1 = $row->acq_date;
	// 	$date2 = date("Y-m-d");

	// 	// Convert to timestamps
	// 	$timestamp1 = strtotime($date1);
	// 	$timestamp2 = strtotime($date2);


	// 	$difference = abs($timestamp2 - $timestamp1);
	// 	$years = $difference / (365 * 24 * 60 * 60);
	// 	$numberofyears = (int)$years;
	// 	$depreciation_amount = $row->price / $row->eul;
	// 	$depreciation_amountf = $depreciation_amount * $numberofyears;
	// 	$carrying_amount = $row->price - $depreciation_amountf;

	// 	$totalamount += $carrying_amount;
	// }

	// return $totalamount;
}


function payee_name($pdo,$id)
{

	$select = $pdo->prepare("SELECT * FROM tb_payee WHERE id = '$id' ");
	$select->execute();
	$row=$select->fetch(PDO::FETCH_OBJ);

	return $row->name;
}


function checksdata($pdo,$bankid,$datenow)
{
	// $datenow = date('Y-m-d');

	$select = $pdo->prepare("SELECT * FROM tb_check WHERE bank_id = '$bankid' ");
	$select->execute();
	$totalcheck = $select->rowCount();

	$select1 = $pdo->prepare("SELECT * FROM tb_check WHERE bank_id = '$bankid' AND status_id = '1' ");
	$select1->execute();
	$pendingchecks = $select1->rowCount();

	$select2 = $pdo->prepare("SELECT * FROM tb_check WHERE bank_id = '$bankid' AND status_id = '2' ");
	$select2->execute();
	$clearedchecks = $select2->rowCount();

	$select3 = $pdo->prepare("SELECT * FROM tb_check WHERE bank_id = '$bankid' AND status_id = '3' ");
	$select3->execute();
	$holdchecks = $select3->rowCount();

	$select4 = $pdo->prepare("SELECT * FROM tb_check WHERE bank_id = '$bankid' AND status_id = '4' ");
	$select4->execute();
	$cancelledchecks = $select4->rowCount();

	$select5 = $pdo->prepare("SELECT SUM(amount) as totalamount from tb_check WHERE bank_id = '$bankid' AND status_id = '2' ");
	$select5->execute();
	$row5=$select5->fetch(PDO::FETCH_OBJ);

	$select6 = $pdo->prepare("SELECT SUM(amount) as totalamount from tb_deposit WHERE bank_id = '$bankid' ");
	$select6->execute();
	$row6=$select6->fetch(PDO::FETCH_OBJ);

	$select7 = $pdo->prepare("SELECT * from tb_check WHERE bank_id = '$bankid' AND check_date <= '$datenow' AND status_id != '2' ");
	$select7->execute();
	$total_outstandingcheck = $select7->rowCount(); 

	$select8 = $pdo->prepare("SELECT SUM(amount) as totaloutstanding from tb_check WHERE bank_id = '$bankid' AND check_date <= '$datenow' AND status_id != '2' ");
	$select8->execute();
	$row8 = $select8->fetch(PDO::FETCH_OBJ);


	$array['totalcheck'] = $totalcheck;
	$array['pending'] = $pendingchecks;
	$array['cleared'] = $clearedchecks;
	$array['hold'] = $holdchecks;
	$array['cancel'] = $cancelledchecks;
	$array['totalwithdraw'] = $row5->totalamount;
	$array['totaldeposit'] = $row6->totalamount;
	$array['totaloverall'] = $row6->totalamount - $row5->totalamount;
	$array['total_outstandingcheck'] = $total_outstandingcheck;
	$array['total_outstanding_check_amount'] = $row8->totaloutstanding;

	return $array;
}

function user_level($pdo,$id)
{

	$select = $pdo->prepare("SELECT * from tb_user_level where id = $id");
	$select->execute();
	$row=$select->fetch(PDO::FETCH_OBJ);

	return $row->name;
}




function alertmessage()
{
	if (isset($_SESSION['alertmessage'])) 
	{
		echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<h6>'.$_SESSION['alertmessage'].'</h6>
				 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
				 </button>
			 </div>';
		 unset($_SESSION['alertmessage']);
	}
}




function bank_name($pdo,$id)
{
	$select = $pdo->prepare("SELECT * from tb_bank where id = $id");
	$select->execute();
	$row=$select->fetch(PDO::FETCH_OBJ);

	return $row->name.' - ('.$row->account_num.')';
}





function status_name($pdo,$id)
{
	$select = $pdo->prepare("SELECT * from tb_status where id = $id");
	$select->execute();
	$row=$select->fetch(PDO::FETCH_OBJ);

	if ($id == 1) 
	{
		$statusbtn = '<span class="badge badge-primary">'.$row->name.'</span>';
	}
	else if ($id == 2) 
	{
		$statusbtn = '<span class="badge badge-success">'.$row->name.'</span>';
	}
	else if ($id == 3) 
	{
		$statusbtn = '<span class="badge badge-warning">'.$row->name.'</span>';
	}
	else if ($id == 4) 
	{
		$statusbtn = '<span class="badge badge-danger">'.$row->name.'</span>';
	}

	return $statusbtn;
}



function update_check_status($pdo,$checkstatusid,$timestamp,$checkid)
{

// cleared_at
// cancelled_at
// hold_at

	if ($checkstatusid == 1) 
	{
		$sqlupdate = $pdo->prepare("UPDATE tb_check SET created_at = '$timestamp' WHERE id = '$checkid' ");
		$sqlupdate->execute();
	}

	else if ($checkstatusid == 2) 
	{
		$sqlupdate = $pdo->prepare("UPDATE tb_check SET cleared_at = '$timestamp' WHERE id = '$checkid' ");
		$sqlupdate->execute();
	}

	else if ($checkstatusid == 3) 
	{
		$sqlupdate = $pdo->prepare("UPDATE tb_check SET hold_at = '$timestamp' WHERE id = '$checkid' ");
		$sqlupdate->execute();
	}

	else if ($checkstatusid == 4) 
	{
		$sqlupdate = $pdo->prepare("UPDATE tb_check SET cancelled_at = '$timestamp' WHERE id = '$checkid' ");
		$sqlupdate->execute();
	}


	// return $checkstatusid.' '.$timestamp.' '.$checkid;


}


function fetch_property_user($pdo,$id)
{
	$select = $pdo->prepare("SELECT * from tb_property_user where id = $id");
	$select->execute();
	$row=$select->fetch(PDO::FETCH_OBJ);

	return $row->name;
}


function fetch_property_brand($pdo,$id)
{
	$select = $pdo->prepare("SELECT * from tb_property_brand where id = $id");
	$select->execute();
	$row=$select->fetch(PDO::FETCH_OBJ);

	return $row->name;
}


?>
















