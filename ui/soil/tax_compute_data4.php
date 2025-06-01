<?php 
include_once 'connectdb.php';



if ($_POST['isset'] == 'data1') 
{
	$q1_vatable_sales = $_POST['q1_vatable_sales'];
	$q1_government_sales_principal = $_POST['q1_government_sales_principal'];
	$q1_zero_rated_sales_principal = $_POST['q1_zero_rated_sales_principal'];
	$q1_exempt_sales_principal = $_POST['q1_exempt_sales_principal'];
	$q1_total_vat_purchase_accessory = $_POST['q1_total_vat_purchase_accessory'];
	$sawt_vt = $_POST['sawt_vt'];
	$sawt_it = $_POST['sawt_it'];
	$non_vat_expenses = $_POST['non_vat_expenses'];
	$q1_net_taxable_income_previous_quarter_accessory = $_POST['q1_net_taxable_income_previous_quarter_accessory'];
	$q1_vat_payment_previous_principal = $_POST['q1_vat_payment_previous_principal'];
	$q1_less_cost_of_sales_accessory = $_POST['q1_less_cost_of_sales_accessory'];
	$q1_it_payment_previous_principal = $_POST['q1_it_payment_previous_principal'];
	$q1_other_expenses_value_principal_2 = $_POST['q1_other_expenses_value_principal_2'];
	$less_deductions = $_POST['less_deductions'];

	$q1_tax_rate_principal = $_POST['q1_tax_rate_principal'];
	$q1_tax_rate_principal = $q1_tax_rate_principal / 100;

	$q1_mcit_percent_principal = $_POST['q1_mcit_percent_principal'];
	$q1_mcit_percent_principal = $q1_mcit_percent_principal / 100;


	$q1_total_vat_purchase_accessory = floatval(str_replace(",", "", $q1_total_vat_purchase_accessory));

	
	// $total = $q1_vatable_sales - $q1_government_sales_principal - $q1_zero_rated_sales_principal;
	// $difference2 = ($q1_vatable_sales + $q1_exempt_sales_principal) - $q1_less_cost_of_sales_accessory;

	$total = $q1_vatable_sales - $q1_government_sales_principal;
	$total2 = $q1_vatable_sales - $q1_government_sales_principal;
	$difference1 = ($q1_government_sales_principal * 0.12 + $total2 * 0.12) - $q1_total_vat_purchase_accessory;
	$difference2 = ($q1_vatable_sales + $q1_exempt_sales_principal + $q1_zero_rated_sales_principal) - $q1_less_cost_of_sales_accessory;
	$difference3 = $difference2 - $non_vat_expenses - $q1_other_expenses_value_principal_2;
	$total12 = $difference3 + $q1_net_taxable_income_previous_quarter_accessory;
	$total16 = $sawt_vt + $q1_vat_payment_previous_principal;



	$total13 = $total12 * $q1_tax_rate_principal;
	$total14 = $total12 * $q1_mcit_percent_principal;
	$total17 = $q1_it_payment_previous_principal + $sawt_it;
	$total19 = $q1_mcit_percent_principal * $difference2;


	if ($total13 > $total19) 
	{
		$output['total15'] = number_format($total13,2);
	}
	else
	{
		$output['total15'] = number_format($total19,2);
	}

	$output['total'] = number_format($total,2);
	$output['total2'] = number_format($total2 * 0.12,2);
	$output['total3'] = $q1_government_sales_principal;
	$output['total4'] = number_format($q1_government_sales_principal * 0.12,2);
	$output['total5'] = number_format($q1_vatable_sales + $q1_exempt_sales_principal + $q1_zero_rated_sales_principal,2);
	$output['total6'] = number_format($q1_government_sales_principal * 0.12 + $total2 * 0.12,2);
	$output['total7'] = number_format(($q1_government_sales_principal * 0.12 + $total2 * 0.12),2);
	$output['total8'] = number_format($difference1,2);
	$output['total9'] = number_format($difference1 - ($sawt_vt + $q1_vat_payment_previous_principal) ,2);
	$output['total10'] = number_format($difference2,2);
	$output['total11'] = number_format($difference3,2);
	$output['total12'] = number_format($total12,2);
	$output['total13'] = number_format($total13,2);
	$output['total14'] = number_format($total14,2);
	$output['total16'] = number_format($total16,2);
	$output['total17'] = number_format($total17,2);
	$output['total18'] = number_format($q1_other_expenses_value_principal_2 + $less_deductions,2);
	$output['total19'] = number_format($q1_mcit_percent_principal * $difference2,2);
}





















































if ($_POST['isset'] == 'data2') 
{
	$q2_vatable_sales = $_POST['q2_vatable_sales'];
	$q2_government_sales_principal = $_POST['q2_government_sales_principal'];
	$q2_zero_rated_sales_principal = $_POST['q2_zero_rated_sales_principal'];
	$q2_exempt_sales_principal = $_POST['q2_exempt_sales_principal'];
	$q2_total_vat_purchase_accessory = $_POST['q2_total_vat_purchase_accessory'];
	$sawt_vt = $_POST['sawt_vt'];
	$sawt_it = $_POST['sawt_it'];
	$non_vat_expenses = $_POST['non_vat_expenses'];
	$q2_net_taxable_income_previous_quarter_accessory = $_POST['q2_net_taxable_income_previous_quarter_accessory'];
	$q2_vat_payment_previous_principal = $_POST['q2_vat_payment_previous_principal'];
	$q2_less_cost_of_sales_accessory = $_POST['q2_less_cost_of_sales_accessory'];
	$q2_it_payment_previous_principal = $_POST['q2_it_payment_previous_principal'];
	$q2_other_expenses_value_principal_2 = $_POST['q2_other_expenses_value_principal_2'];
	$less_deductions = $_POST['less_deductions'];

	$q2_tax_rate_principal = $_POST['q2_tax_rate_principal'];
	$q2_tax_rate_principal = $q2_tax_rate_principal / 100;

	$q2_mcit_percent_principal = $_POST['q2_mcit_percent_principal'];
	$q2_mcit_percent_principal = $q2_mcit_percent_principal / 100;


	$q2_total_vat_purchase_accessory = floatval(str_replace(",", "", $q2_total_vat_purchase_accessory));

	
	// $total = $q2_vatable_sales - $q2_government_sales_principal - $q2_zero_rated_sales_principal;
	// $difference2 = ($q2_vatable_sales + $q2_exempt_sales_principal) - $q2_less_cost_of_sales_accessory;

	$total = $q2_vatable_sales - $q2_government_sales_principal;
	$total2 = $q2_vatable_sales - $q2_government_sales_principal;
	$difference1 = ($q2_government_sales_principal * 0.12 + $total2 * 0.12) - $q2_total_vat_purchase_accessory;
	$difference2 = ($q2_vatable_sales + $q2_exempt_sales_principal + $q2_zero_rated_sales_principal) - $q2_less_cost_of_sales_accessory;
	$difference3 = $difference2 - $non_vat_expenses - $q2_other_expenses_value_principal_2;
	$total12 = $difference3 + $q2_net_taxable_income_previous_quarter_accessory;
	$total16 = $sawt_vt + $q2_vat_payment_previous_principal;



	$total13 = $total12 * $q2_tax_rate_principal;
	$total14 = $total12 * $q2_mcit_percent_principal;
	$total17 = $q2_it_payment_previous_principal + $sawt_it;
	$total19 = $q2_mcit_percent_principal * $difference2;


	if ($total13 > $total19) 
	{
		$output['total15'] = number_format($total13,2);
	}
	else
	{
		$output['total15'] = number_format($total19,2);
	}

	$output['total'] = number_format($total,2);
	$output['total2'] = number_format($total2 * 0.12,2);
	$output['total3'] = $q2_government_sales_principal;
	$output['total4'] = number_format($q2_government_sales_principal * 0.12,2);
	$output['total5'] = number_format($q2_vatable_sales + $q2_exempt_sales_principal + $q2_zero_rated_sales_principal,2);
	$output['total6'] = number_format($q2_government_sales_principal * 0.12 + $total2 * 0.12,2);
	$output['total7'] = number_format(($q2_government_sales_principal * 0.12 + $total2 * 0.12),2);
	$output['total8'] = number_format($difference1,2);
	$output['total9'] = number_format($difference1 - ($sawt_vt + $q2_vat_payment_previous_principal) ,2);
	$output['total10'] = number_format($difference2,2);
	$output['total11'] = number_format($difference3,2);
	$output['total12'] = number_format($total12,2);
	$output['total13'] = number_format($total13,2);
	$output['total14'] = number_format($total14,2);
	$output['total16'] = number_format($total16,2);
	$output['total17'] = number_format($total17,2);
	$output['total18'] = number_format($q2_other_expenses_value_principal_2 + $less_deductions,2);
	$output['total19'] = number_format($q2_mcit_percent_principal * $difference2,2);

	// $output['sample'] = 'God is good!';
}

















































if ($_POST['isset'] == 'data3') 
{
	$q3_vatable_sales = $_POST['q3_vatable_sales'];
	$q3_government_sales_principal = $_POST['q3_government_sales_principal'];
	$q3_zero_rated_sales_principal = $_POST['q3_zero_rated_sales_principal'];
	$q3_exempt_sales_principal = $_POST['q3_exempt_sales_principal'];
	$q3_total_vat_purchase_accessory = $_POST['q3_total_vat_purchase_accessory'];
	$sawt_vt = $_POST['sawt_vt'];
	$sawt_it = $_POST['sawt_it'];
	$non_vat_expenses = $_POST['non_vat_expenses'];
	$q3_net_taxable_income_previous_quarter_accessory = $_POST['q3_net_taxable_income_previous_quarter_accessory'];
	$q3_vat_payment_previous_principal = $_POST['q3_vat_payment_previous_principal'];
	$q3_less_cost_of_sales_accessory = $_POST['q3_less_cost_of_sales_accessory'];
	$q3_it_payment_previous_principal = $_POST['q3_it_payment_previous_principal'];
	$q3_other_expenses_value_principal_2 = $_POST['q3_other_expenses_value_principal_2'];
	$less_deductions = $_POST['less_deductions'];

	$q3_tax_rate_principal = $_POST['q3_tax_rate_principal'];
	$q3_tax_rate_principal = $q3_tax_rate_principal / 100;

	$q3_mcit_percent_principal = $_POST['q3_mcit_percent_principal'];
	$q3_mcit_percent_principal = $q3_mcit_percent_principal / 100;


	$q3_total_vat_purchase_accessory = floatval(str_replace(",", "", $q3_total_vat_purchase_accessory));

	
	// $total = $q3_vatable_sales - $q3_government_sales_principal - $q3_zero_rated_sales_principal;
	// $difference2 = ($q3_vatable_sales + $q3_exempt_sales_principal) - $q3_less_cost_of_sales_accessory;

	$total = $q3_vatable_sales - $q3_government_sales_principal;
	$total2 = $q3_vatable_sales - $q3_government_sales_principal;
	$difference1 = ($q3_government_sales_principal * 0.12 + $total2 * 0.12) - $q3_total_vat_purchase_accessory;
	$difference2 = ($q3_vatable_sales + $q3_exempt_sales_principal + $q3_zero_rated_sales_principal) - $q3_less_cost_of_sales_accessory;
	$difference3 = $difference2 - $non_vat_expenses - $q3_other_expenses_value_principal_2;
	$total12 = $difference3 + $q3_net_taxable_income_previous_quarter_accessory;
	$total16 = $sawt_vt + $q3_vat_payment_previous_principal;



	$total13 = $total12 * $q3_tax_rate_principal;
	$total14 = $total12 * $q3_mcit_percent_principal;
	$total17 = $q3_it_payment_previous_principal + $sawt_it;
	$total19 = $q3_mcit_percent_principal * $difference2;


	if ($total13 > $total19) 
	{
		$output['total15'] = number_format($total13,2);
	}
	else
	{
		$output['total15'] = number_format($total19,2);
	}

	$output['total'] = number_format($total,2);
	$output['total2'] = number_format($total2 * 0.12,2);
	$output['total3'] = $q3_government_sales_principal;
	$output['total4'] = number_format($q3_government_sales_principal * 0.12,2);
	$output['total5'] = number_format($q3_vatable_sales + $q3_exempt_sales_principal + $q3_zero_rated_sales_principal,2);
	$output['total6'] = number_format($q3_government_sales_principal * 0.12 + $total2 * 0.12,2);
	$output['total7'] = number_format(($q3_government_sales_principal * 0.12 + $total2 * 0.12),2);
	$output['total8'] = number_format($difference1,2);
	$output['total9'] = number_format($difference1 - ($sawt_vt + $q3_vat_payment_previous_principal) ,2);
	$output['total10'] = number_format($difference2,2);
	$output['total11'] = number_format($difference3,2);
	$output['total12'] = number_format($total12,2);
	$output['total13'] = number_format($total13,2);
	$output['total14'] = number_format($total14,2);
	$output['total16'] = number_format($total16,2);
	$output['total17'] = number_format($total17,2);
	$output['total18'] = number_format($q3_other_expenses_value_principal_2 + $less_deductions,2);
	$output['total19'] = number_format($q3_mcit_percent_principal * $difference2,2);


}













































if ($_POST['isset'] == 'data4') 
{
	$q4_vatable_sales = $_POST['q4_vatable_sales'];
	$q4_government_sales_principal = $_POST['q4_government_sales_principal'];
	$q4_zero_rated_sales_principal = $_POST['q4_zero_rated_sales_principal'];
	$q4_exempt_sales_principal = $_POST['q4_exempt_sales_principal'];
	$q4_total_vat_purchase_accessory = $_POST['q4_total_vat_purchase_accessory'];
	$sawt_vt = $_POST['sawt_vt'];
	$sawt_it = $_POST['sawt_it'];
	$non_vat_expenses = $_POST['non_vat_expenses'];
	$q4_net_taxable_income_previous_quarter_accessory = $_POST['q4_net_taxable_income_previous_quarter_accessory'];
	$q4_vat_payment_previous_principal = $_POST['q4_vat_payment_previous_principal'];
	$q4_less_cost_of_sales_accessory = $_POST['q4_less_cost_of_sales_accessory'];
	$q4_it_payment_previous_principal = $_POST['q4_it_payment_previous_principal'];
	$q4_other_expenses_value_principal_2 = $_POST['q4_other_expenses_value_principal_2'];
	$less_deductions = $_POST['less_deductions'];

	$q4_tax_rate_principal = $_POST['q4_tax_rate_principal'];
	$q4_tax_rate_principal = $q4_tax_rate_principal / 100;

	$q4_mcit_percent_principal = $_POST['q4_mcit_percent_principal'];
	$q4_mcit_percent_principal = $q4_mcit_percent_principal / 100;


	$q4_total_vat_purchase_accessory = floatval(str_replace(",", "", $q4_total_vat_purchase_accessory));

	
	// $total = $q4_vatable_sales - $q4_government_sales_principal - $q4_zero_rated_sales_principal;
	// $difference2 = ($q4_vatable_sales + $q4_exempt_sales_principal) - $q4_less_cost_of_sales_accessory;

	$total = $q4_vatable_sales - $q4_government_sales_principal;
	$total2 = $q4_vatable_sales - $q4_government_sales_principal;
	$difference1 = ($q4_government_sales_principal * 0.12 + $total2 * 0.12) - $q4_total_vat_purchase_accessory;
	$difference2 = ($q4_vatable_sales + $q4_exempt_sales_principal + $q4_zero_rated_sales_principal) - $q4_less_cost_of_sales_accessory;
	$difference3 = $difference2 - $non_vat_expenses - $q4_other_expenses_value_principal_2;
	$total12 = $difference3 + $q4_net_taxable_income_previous_quarter_accessory;
	$total16 = $sawt_vt + $q4_vat_payment_previous_principal;



	$total13 = $total12 * $q4_tax_rate_principal;
	$total14 = $total12 * $q4_mcit_percent_principal;
	$total17 = $q4_it_payment_previous_principal + $sawt_it;
	$total19 = $q4_mcit_percent_principal * $difference2;


	if ($total13 > $total19) 
	{
		$output['total15'] = number_format($total13,2);
	}
	else
	{
		$output['total15'] = number_format($total19,2);
	}

	$output['total'] = number_format($total,2);
	$output['total2'] = number_format($total2 * 0.12,2);
	$output['total3'] = $q4_government_sales_principal;
	$output['total4'] = number_format($q4_government_sales_principal * 0.12,2);
	$output['total5'] = number_format($q4_vatable_sales + $q4_exempt_sales_principal + $q4_zero_rated_sales_principal,2);
	$output['total6'] = number_format($q4_government_sales_principal * 0.12 + $total2 * 0.12,2);
	$output['total7'] = number_format(($q4_government_sales_principal * 0.12 + $total2 * 0.12),2);
	$output['total8'] = number_format($difference1,2);
	$output['total9'] = number_format($difference1 - ($sawt_vt + $q4_vat_payment_previous_principal) ,2);
	$output['total10'] = number_format($difference2,2);
	$output['total11'] = number_format($difference3,2);
	$output['total12'] = number_format($total12,2);
	$output['total13'] = number_format($total13,2);
	$output['total14'] = number_format($total14,2);
	$output['total16'] = number_format($total16,2);
	$output['total17'] = number_format($total17,2);
	$output['total18'] = number_format($q4_other_expenses_value_principal_2 + $less_deductions,2);
	$output['total19'] = number_format($q4_mcit_percent_principal * $difference2,2);
}




echo json_encode($output);

?>