<?php
include_once 'connectdb.php';
include_once 'tax_compute/function2.php';

$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];


$quarter1_data = fetch_per_quarter_data($pdo,$yearnow,$branchid,1,3,1);
$quarter2_data = fetch_per_quarter_data($pdo,$yearnow,$branchid,4,6,2);
$quarter3_data = fetch_per_quarter_data($pdo,$yearnow,$branchid,7,9,3);
$quarter4_data = fetch_per_quarter_data($pdo,$yearnow,$branchid,10,12,4);

// echo number_format($quarter1_data['calculated_risk_percent'],2).' - '.number_format($quarter1_data['calculated_risk_percent'],2);
// echo '<br>';
// echo $quarter1_data['payment_risk'];


include_once 'tax_computation_vt_q1.php';
include_once 'tax_computation_vt_q2.php';
// include_once 'tax_computation_vt_q3.php';
// include_once 'tax_computation_vt_q4.php';
// include_once 'tax_computation_it_q1.php';
// include_once 'tax_computation_it_q2.php';
// include_once 'tax_computation_it_q3.php';
// include_once 'tax_computation_it_q4.php';




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


        // $(document).on('click','#btn_edit_all_data_quarter1',function()
        // {

        //     window.location.href = "tax_view_quarter_all_data.php?quarter=1&yearnow="+year_now+'&branchid='+branch_id+'&monthfrom=1&monthto=3';

        // })




 		

 	})
 </script>




















