<?php
include_once 'connectdb.php';
include_once 'tax_compute/function2.php';

$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];


$quarter1_data = fetch_per_quarter_data($pdo,$yearnow,$branchid,1,3,1);
$quarter2_data = fetch_per_quarter_data($pdo,$yearnow,$branchid,4,6,2);
$quarter3_data = fetch_per_quarter_data($pdo,$yearnow,$branchid,7,9,3);
$quarter4_data = fetch_per_quarter_data($pdo,$yearnow,$branchid,10,12,4);



// $quarter1_it_data = fetch_per_quarter_it_data($pdo,$yearnow,$branchid,1,3,1);
$quarter1_it_data = fetch_data($pdo,1,3,1,$yearnow,$branchid);
$quarter2_it_data = fetch_data($pdo,4,6,2,$yearnow,$branchid);
$quarter3_it_data = fetch_data($pdo,7,9,3,$yearnow,$branchid);
$quarter4_it_data = fetch_data($pdo,10,12,4,$yearnow,$branchid);

// echo $quarter1_it_data['grossincome'];
// echo '<br>';
// echo $quarter1_it_data['total_sales_revenue'].' '.$quarter1_it_data['cost_of_sales'];
// echo '<br>';
// echo $quarter1_it_data['total_non_vat_purchase'] + $quarter1_it_data['total_vat_purchase'] + $quarter1_it_data['other_expenses_2'];
// echo '<br><br>';
// echo $quarter1_it_data['taxable_income_to_date'];

// $quarter2_it_data = fetch_per_quarter_it_data($pdo,$yearnow,$branchid,1,3,1);
// $quarter3_it_data = fetch_per_quarter_it_data($pdo,$yearnow,$branchid,1,3,1);
// $quarter4_it_data = fetch_per_quarter_it_data($pdo,$yearnow,$branchid,1,3,1);

// echo number_format($quarter1_data['calculated_risk_percent'],2).' - '.number_format($quarter1_data['calculated_risk_percent'],2);
// echo '<br>';
// echo $quarter1_data['payment_risk'];


include_once 'tax_computation_vt_q1.php';
include_once 'tax_computation_vt_q2.php';
include_once 'tax_computation_vt_q3.php';
include_once 'tax_computation_vt_q4.php';



include_once 'tax_computation_it_q1.php';
include_once 'tax_computation_it_q2.php';
include_once 'tax_computation_it_q3.php';
include_once 'tax_computation_it_q4.php';




?>






 <script type="text/javascript">
 	$(document).ready(function()
 	{


        var year_now = '<?= $yearnow ?>';
        var branch_id = '<?= $branchid ?>';
 		
        
        // alert('God is good, life is good!47474');        

        $(document).on('click','#btn_edit_quarter1',function()
        {

            window.location.href = "tax_view_quarter_semi_data.php?quarter=1&yearnow="+year_now+'&branchid='+branch_id+'&monthfrom=1&monthto=3';

        })

        $(document).on('click','#btn_edit_quarter2',function()
        {

            window.location.href = "tax_view_quarter_semi_data.php?quarter=2&yearnow="+year_now+'&branchid='+branch_id+'&monthfrom=4&monthto=6';

        })


        $(document).on('click','#btn_edit_quarter3',function()
        {

            window.location.href = "tax_view_quarter_semi_data.php?quarter=3&yearnow="+year_now+'&branchid='+branch_id+'&monthfrom=7&monthto=9';

        })


        $(document).on('click','#btn_edit_quarter4',function()
        {

            window.location.href = "tax_view_quarter_semi_data.php?quarter=4&yearnow="+year_now+'&branchid='+branch_id+'&monthfrom=10&monthto=12';

        })




 		

 	})
 </script>




















