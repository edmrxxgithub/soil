<?php 
include_once 'connectdb.php';

// $quarter_num = $_POST['quarter_num'];
$quarter_num = 4;
$branch_id = $_POST['branch_id'];
$year_now = $_POST['year_now'];

$government_sales = $_POST['q4_government_sales_principal'];
$zero_rated_sales = $_POST['q4_zero_rated_sales_principal'];
$exempt_sales = $_POST['q4_exempt_sales_principal'];

$other_expenses = $_POST['q4_other_expense_principal'];
$vat_payment_previous = $_POST['q4_vat_payment_previous_principal'];
$tax_actually_paid_success = $_POST['q4_tax_actual_paid_accessory'];

$cost_of_sales = $_POST['q4_less_cost_of_sales_accessory'];
$tax_income_previous = $_POST['q4_net_taxable_income_previous_quarter_accessory'];
$other_expenses_2 = $_POST['q4_other_expenses_value_principal_2'];

$tax_rate = $_POST['q4_tax_rate_principal'];
$mcit = $_POST['q4_mcit_percent_principal'];
$it_payment_previous = $_POST['q4_it_payment_previous_principal'];
$income_tax_actually_paid_success = $_POST['q4_income_tax_actually_paid_accessory'];


// echo $government_sales.' '.$zero_rated_sales.' '.$exempt_sales.' '.$other_expenses.' '.$vat_payment_previous.' '.$tax_actually_paid_success.' '.$cost_of_sales.' '.$other_expenses_2.' '.$tax_income_previous.' '.$tax_rate.' '.$mcit.' '.$it_payment_previous.' '.$income_tax_actually_paid_success;

// echo $quarter_num.' '.$branch_id.' '.$year_now;
// $aw = 777;

$select = $pdo->prepare("SELECT COUNT(*) AS total FROM tb_tax_return WHERE branch_id = '$branch_id' AND year_num = '$year_now' AND quarter_num = '$quarter_num' ");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

$delete = $pdo->prepare("DELETE FROM tb_tax_return WHERE branch_id = '$branch_id' AND year_num = '$year_now' AND quarter_num = '$quarter_num' ");



$insert = $pdo->prepare("

INSERT INTO tb_tax_return SET

quarter_num = '$quarter_num',
branch_id = '$branch_id',
year_num = '$year_now',

government_sales = '$government_sales' ,
zero_rated_sales = '$zero_rated_sales' ,
exempt_sales = '$exempt_sales',

other_expenses = '$other_expenses' ,
vat_payment_previous = '$vat_payment_previous' ,
tax_actually_paid_success = '$tax_actually_paid_success' ,

cost_of_sales = '$cost_of_sales' ,
tax_income_previous = '$tax_income_previous'	,
other_expenses_2 = '$other_expenses_2',

tax_rate = '$tax_rate' ,
mcit = '$mcit' ,
it_payment_previous = '$it_payment_previous'	,
income_tax_actually_paid_success = '$income_tax_actually_paid_success' ");



if ($row->total > 0) 
{
	$delete->execute();
	$insert->execute();
}
else
{
	$insert->execute();
}


?>







