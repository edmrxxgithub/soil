
<?php


function fetch_calculated_risk_data($pdo,$date_from,$date_to,$branchid,$quarter_num,$yearnow)
{

	$select_calculated_risk = $pdo->prepare("SELECT * FROM tb_tax_return_by_quarter WHERE quarter_num = '$quarter_num' AND branch_id = '$branchid' AND year_num = '$yearnow' ");
	$select_calculated_risk->execute();
	$row_calculated_risk = $select_calculated_risk->fetch(PDO::FETCH_OBJ);
	


	if ($row_calculated_risk) 
	{
		$calculated_risk_percent = $row_calculated_risk->payment_risk;
	}
	else
	{
		$calculated_risk_percent = 0;
	}
	


	$vatable_sales = fetch_vatable_sales($pdo,$date_from,$date_to,$branchid);
	$vatable_purchase = fetch_vatable_purchase($pdo,$date_from,$date_to,$branchid);
	$vatable_expense = fetch_vatable_expense($pdo,$date_from,$date_to,$branchid);
	


	$domestic_purchase = $vatable_purchase + $vatable_expense;
	$total_as_is_payment = $vatable_sales - $domestic_purchase;
	$total_as_is_payment_percent = $total_as_is_payment * 0.12;

	$difference_total_as_is_payment_percent = $calculated_risk_percent - $total_as_is_payment_percent;
	$difference_total_as_is_payment_percent = $total_as_is_payment_percent - $calculated_risk_percent;
	$difference_total_as_is_payment_no_percent = $difference_total_as_is_payment_percent / 0.12;
	


	if ($row_calculated_risk) 
	{
		$array['calculated_risk_no_percent'] = $difference_total_as_is_payment_no_percent;
		$array['calculated_risk_percent'] = $difference_total_as_is_payment_percent;
	}
	else
	{
		$array['calculated_risk_no_percent'] = 0;
		$array['calculated_risk_percent'] = 0;
	}

	
	

	return $array;

}



function fetch_vatable_sales($pdo,$date_from,$date_to,$branchid)
{
	$total = 0;

	$select = $pdo->prepare("SELECT SUM(net_amount) as total_net_amount FROM tb_tax_sales WHERE date BETWEEN '$date_from' AND '$date_to' AND branch_id = '$branchid' AND vat_percent != 0 ");
	$select->execute();
	$row = $select->fetch(PDO::FETCH_OBJ);

	if ($row) 
	{
		$total = $row->total_net_amount;
	}
	else
	{
		$total = 0;
	}

	return $total;

}


function fetch_vatable_purchase($pdo,$date_from,$date_to,$branchid)
{

	$select = $pdo->prepare("SELECT SUM(net_amount) as total_net_amount FROM tb_tax_purchase WHERE date BETWEEN '$date_from' AND '$date_to' AND branch_id = '$branchid'  ");
	$select->execute();
	$row = $select->fetch(PDO::FETCH_OBJ);

	if ($row) 
	{
		$total = $row->total_net_amount;
	}
	else
	{
		$total = 0;
	}

	return $total;
}


function fetch_vatable_expense($pdo,$date_from,$date_to,$branchid)
{
	$select = $pdo->prepare("SELECT SUM(net_amount) as total_net_amount FROM tb_tax_vat_purchase WHERE date BETWEEN '$date_from' AND '$date_to' AND branch_id = '$branchid'  ");
	$select->execute();
	$row = $select->fetch(PDO::FETCH_OBJ);


	if ($row) 
	{
		$total = $row->total_net_amount;
	}
	else
	{
		$total = 0;
	}

	return $total;
}


function fetch_calculated_risk($pdo,$branch_id,$year_now,$quarter_num)
{

	
	// $select = $pdo->prepare("SELECT * FROM tb_tax_return WHERE quarter_num = '$quarter_num' AND branch_id = '$branch_id' AND year_num = '$year_now' ");

	// $select->execute();
	// $row = $select->fetch(PDO::FETCH_OBJ);

	// if ($row) 
	// {
	// 	return $row->calculated_risk;
	// }
	// else
	// {
	// 	return 0;
	// }


	return 0;

}


?>