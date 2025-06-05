<?php



function fetch_data($pdo,$monthfrom,$monthto,$quarter_num,$yearnow,$branchid)
{

  // $select1 = $pdo->prepare("SELECT SUM(net_amount) as total_sales_net_amount FROM tb_tax_sales WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  // $select1->execute();
  // $row1 = $select1->fetch(PDO::FETCH_OBJ);

$date_from = $yearnow.'-'.$monthfrom.'-1';
$number_of_days = date("t", strtotime("$yearnow-$monthto-1"));
$date_to = $yearnow.'-'.$monthto.'-'.$number_of_days;


$calculated_risk_data = fetch_calculated_risk_data($pdo,$date_from,$date_to,$branchid,$quarter_num,$yearnow);


  $select1 = $pdo->prepare("SELECT 

        SUM(net_amount) as total_sales_net_amount
        
        FROM 

        tb_tax_sales 

        WHERE 

        date BETWEEN '$date_from' AND 

        '$date_to' AND branch_id = '$branchid' AND vat_percent != 0 AND vwt_percent = 0 ");

  $select1->execute();
  $row1 = $select1->fetch(PDO::FETCH_OBJ);



  $select_government_sales = $pdo->prepare("SELECT 

        SUM(net_amount) as net_amount_total
        
        FROM 

        tb_tax_sales 

        WHERE 

        date BETWEEN '$date_from' AND 

        '$date_to' AND branch_id = '$branchid' AND vat_percent != 0  AND vwt_percent != 0 ");

  $select_government_sales->execute();
  $row_government_sales = $select_government_sales->fetch(PDO::FETCH_OBJ);



  $select_zero_rated_sales = $pdo->prepare("SELECT 

        SUM(net_amount) as net_amount_total
        
        FROM 

        tb_tax_sales 

        WHERE 

        date BETWEEN '$date_from' AND 

        '$date_to' AND branch_id = '$branchid' AND vat_percent = 0 AND vwt_percent != 0 ");

  $select_zero_rated_sales->execute();
  $row_zero_rated_sales = $select_zero_rated_sales->fetch(PDO::FETCH_OBJ);


  $select_exempt_sales = $pdo->prepare("SELECT 

        SUM(net_amount) as net_amount_total
        
        FROM 

        tb_tax_sales 

        WHERE 

        date BETWEEN '$date_from' AND 

        '$date_to' AND branch_id = '$branchid' AND vat_percent = 0  AND vwt_percent = 0 ");

  $select_exempt_sales->execute();
  $row_exempt_sales = $select_exempt_sales->fetch(PDO::FETCH_OBJ);


  $select2 = $pdo->prepare("SELECT SUM(net_amount) as total_purchase_net_amount FROM tb_tax_purchase WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select2->execute();
  $row2 = $select2->fetch(PDO::FETCH_OBJ);

  $select3 = $pdo->prepare("SELECT SUM(net_amount) as total_vat_purchase_net_amount FROM tb_tax_vat_purchase WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select3->execute();
  $row3 = $select3->fetch(PDO::FETCH_OBJ);

  $select4 = $pdo->prepare("SELECT SUM(gross_amount) as total_non_vat_purchase_net_amount FROM tb_tax_non_vat_purchase WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select4->execute();
  $row4 = $select4->fetch(PDO::FETCH_OBJ);

   $select5 = $pdo->prepare("SELECT SUM(withholding_total_vwt) as withholding_total_vwt FROM tb_tax_sales WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select5->execute();
  $row5 = $select5->fetch(PDO::FETCH_OBJ);

  $select6 = $pdo->prepare("SELECT SUM(withholding_total_cwt) as withholding_total_cwt FROM tb_tax_sales WHERE date between '$date_from' and '$date_to' and branch_id = '$branchid' ");
  $select6->execute();
  $row6 = $select6->fetch(PDO::FETCH_OBJ);


  $total_sales_revenue = $row1->total_sales_net_amount + 
                         $row_government_sales->net_amount_total + 
                         $row_zero_rated_sales->net_amount_total + 
                         $row_exempt_sales->net_amount_total;


  $array['total_sales_revenue'] = $total_sales_revenue;


  
   // number_format($quarter1_data['total_sales_revenue'] - 
   //                      ($quarter1_data['total_non_vat_purchase']+ $quarter1_data['total_vat_purchase']),2)


   $array['net_taxable_income'] = $total_sales_revenue - ($row3->total_vat_purchase_net_amount + $row4->total_non_vat_purchase_net_amount);

  $array['total_sales'] = $row1->total_sales_net_amount;
  $array['total_government_sales'] = $row_government_sales->net_amount_total;
  $array['total_zero_rated_sales'] = $row_zero_rated_sales->net_amount_total;
  $array['total_exempt_sales'] = $row_exempt_sales->net_amount_total;

  $array['total_purchase'] = $row2->total_purchase_net_amount;
  $array['total_vat_purchase'] = $row3->total_vat_purchase_net_amount;
  $array['total_non_vat_purchase'] = $row4->total_non_vat_purchase_net_amount;
  $array['total_swt_vt'] = $row5->withholding_total_vwt;
  $array['total_swt_it'] = $row6->withholding_total_cwt;

  $array['calculated_risk_no_percent'] = $calculated_risk_data['calculated_risk_no_percent'];
  $array['calculated_risk_percent'] = $calculated_risk_data['calculated_risk_percent'];




  return $array;

}













function fetch_per_quarter_data($pdo,$yearnow,$branchid,$monthfrom,$monthto,$quarter_num)
{


// Define date range
$date_from = "$yearnow-$monthfrom-1";
$last_day = date("t", strtotime("$yearnow-$monthto-1"));
$date_to = "$yearnow-$monthto-$last_day";

// Check if data for the quarter exists
$stmt = $pdo->prepare("SELECT * FROM tb_tax_return_by_quarter WHERE quarter_num = ? AND branch_id = ? AND year_num = ?");
$stmt->execute([$quarter_num, $branchid, $yearnow]);
$quarter_data = $stmt->fetch(PDO::FETCH_OBJ);

$payment_risk = $quarter_data ? $quarter_data->payment_risk : 0;

// Get financial data
$vatable_sales = fetch_vatable_sales($pdo, $date_from, $date_to, $branchid);
$vatable_purchase = fetch_vatable_purchase($pdo, $date_from, $date_to, $branchid);
$vatable_expense = fetch_vatable_expense($pdo, $date_from, $date_to, $branchid);

$domestic_purchase = $vatable_purchase + $vatable_expense;

$totalpaidrisk_no_percent = $vatable_sales - $domestic_purchase;
$totalpaidrisk_percent = $totalpaidrisk_no_percent * 0.12;

// Initialize result variables
$calculated_risk_no_percent = 0;
$calculated_risk_percent = 0;
$benchmark = 0;

// Perform risk and benchmark calculations
	if ($quarter_data && $vatable_sales != 0) 
	{
	    $calculated_risk_percent = $totalpaidrisk_percent - $payment_risk;
	    $calculated_risk_no_percent = $calculated_risk_percent / 0.12;
	    $benchmark = ($payment_risk / $vatable_sales) * 100;
	} 
	elseif ($vatable_sales != 0) 
	{
	    $benchmark = ($totalpaidrisk_percent / $vatable_sales) * 100;
	}

	// Build result array
	return 
	[
	    'vatable_sales' => $vatable_sales,
	    'domestic_purchase' => $domestic_purchase,
	    'datefrom' => $date_from,
	    'dateto' => $date_to,
	    'calculated_risk_no_percent' => $calculated_risk_no_percent,
	    'calculated_risk_percent' => $calculated_risk_percent,
	    'totalpaidrisk_no_percent' => $totalpaidrisk_no_percent - $calculated_risk_no_percent,
	    'totalpaidrisk_percent' => $totalpaidrisk_percent - $calculated_risk_percent,
	    'benchmark' => $benchmark,
	    'payment_risk' => $payment_risk
	];




}






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