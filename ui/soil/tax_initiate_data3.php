<?php 
include_once 'connectdb.php';

// $quarter_num = $_POST['quarter_num'];
$quarter_num = 3;
$quarter_num_before = $quarter_num - 1;
$branch_id = $_POST['branch_id'];
$year_now = $_POST['year_now'];


// echo $quarter_num.' '.$branch_id.' '.$year_now;

$select = $pdo->prepare("SELECT COUNT(*) AS total 
	FROM tb_tax_return 
	WHERE 

	branch_id = '$branch_id' AND 
	year_num = '$year_now' AND 
	quarter_num = '$quarter_num' 

	");

$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

if ($row) 
{

	$select1 = $pdo->prepare("SELECT * FROM tb_tax_return WHERE 

		branch_id = '$branch_id' AND 
		year_num = '$year_now' AND 
		quarter_num = '$quarter_num' ");

	$select1->execute();
	$row1 = $select1->fetch(PDO::FETCH_OBJ);


	$select2 = $pdo->prepare("SELECT * FROM tb_tax_return WHERE 

		branch_id = '$branch_id' AND 
		year_num = '$year_now' AND 
		quarter_num = '$quarter_num_before' ");

	$select2->execute();
	$row2 = $select2->fetch(PDO::FETCH_OBJ);

	$output['government_sales'] = $row1->government_sales;
	$output['zero_rated_sales'] = $row1->zero_rated_sales;
	$output['exempt_sales'] = $row1->exempt_sales;

	$output['other_expenses'] = $row1->other_expenses;
	// $output['vat_payment_previous'] = $row1->vat_payment_previous;
	$output['vat_payment_previous'] = $row2->tax_actually_paid_success;
	$output['tax_actually_paid_success'] = $row1->tax_actually_paid_success;
	
	$output['cost_of_sales'] = $row1->cost_of_sales;

	// $output['tax_income_previous'] = $row1->tax_income_previous;
	$output['tax_income_previous'] = $row2->tax_income_previous;
	$output['tax_rate'] = $row1->tax_rate;
	$output['other_expenses_2'] = $row1->other_expenses_2;
	$output['mcit'] = $row1->mcit;

	// $output['it_payment_previous'] = $row1->it_payment_previous;
	$output['it_payment_previous'] = $row2->income_tax_actually_paid_success;
	$output['income_tax_actually_paid_success'] = $row1->income_tax_actually_paid_success;

	
}

// $output[''];

echo json_encode($output);




// quarter_num
// branch_id
// year_num

// government_sales
// zero_rated_sales
// exempt_sales

// other_expenses
// vat_payment_previous
// tax_actually_paid_success
// cost_of_sales

// tax_income_previous
// tax_rate
// other_expenses_2
// mcit

// it_payment_previous
// income_tax_actually_paid_success



?>









