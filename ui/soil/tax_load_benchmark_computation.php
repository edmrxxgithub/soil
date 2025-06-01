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
// include_once 'tax_computation_vt_q2.php';
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

 		// var year_now = $('#yearnow_php').val();
 		// var branch_id = $('#branchid_php').val();
        var year_now = '<?= $yearnow ?>';
        var branch_id = '<?= $branchid ?>';
 		var date_from = '<?= $date_from ?>';
 		var date_to = '<?= $date_to ?>';
        var check_quarter_1 = '<?= $row_check_quarter1 ?>';
        
        // alert(check_quarter_1);



        //If ever has existing file
        if (check_quarter_1 != 0) 
        {

             $.ajax({
                url:'tax_compute/file7.php',
                method:"POST",
                data:'year_now='+year_now+'&branch_id='+branch_id+'&date_from='+date_from+'&date_to='+date_to,
                dataType:'json',
                success:function(data)
                {
                 $('#q1_vatable_sales').html(data.sales);
                 $('#q1_vatable_sales_percent').html(data.sales_percent);

                 $('#q1_domestic_purchase').html(data.domestic_purchase);
                 $('#q1_domestic_purchase_percent').html(data.domestic_purchase_percent);

                 $('#q1_calculated_risk').html(data.calculated_risk);
                 $('#q1_calculated_risk_percent').html(data.calculated_risk_percent);

                 $('#q1_total_payment_computation').val(data.total_as_is_payment_percent);
                 $('#q1_benchmark_total_vt_computation').html(data.benchmark);
                }
              });

        }
        else
        {

            $.ajax({
                url:'tax_compute/file1.php',
                method:"POST",
                data:'year_now='+year_now+'&branch_id='+branch_id+'&date_from='+date_from+'&date_to='+date_to,
                dataType:'json',
                success:function(data)
                {
                 $('#q1_vatable_sales').html(data.sales);
                 $('#q1_vatable_sales_percent').html(data.sales_percent);

                 $('#q1_domestic_purchase').html(data.domestic_purchase);
                 $('#q1_domestic_purchase_percent').html(data.domestic_purchase_percent);

                 $('#q1_calculated_risk').html(data.calculated_risk);
                 $('#q1_calculated_risk_percent').html(data.calculated_risk_percent);

                 $('#q1_total_payment_computation').val(data.total_as_is_payment_percent);
                 $('#q1_benchmark_total_vt_computation').html(data.benchmark);
                }
              });

        }


        


 	
        
        $(document).on('keyup','#q1_total_payment_computation',function()
        {

            var totalnumber_q1 = $('#q1_total_payment_computation').val();

            $.ajax({
                url:'tax_compute/file6.php',
                method:"POST",
                data:'year_now='+year_now+
                     '&branch_id='+branch_id+
                     '&date_from='+date_from+
                     '&date_to='+date_to+
                     '&totalnumber_q1='+totalnumber_q1,
                dataType:'json',
                success:function(data)
                {
                    $('#q1_calculated_risk_percent').html(data.calculated_risk_percent);
                    $('#q1_calculated_risk').html(data.calculated_risk_no_percent);
                    $('#q1_benchmark_total_vt_computation').html(data.benchmark);
                }
              });

        })



      $(document).on('click','#btn_save_q1',function()
      {
		
        var total_payment = $('#q1_total_payment_computation').val();

        // alert(total_payment);
        
        $.ajax({
            url:'tax_compute/file2.php',
            method:"POST",
            data:'total_payment='+total_payment+
            '&year_now='+year_now+
            '&branch_id='+branch_id,
            success:function(data)
            {

              Swal.fire({
              icon: 'success',
              title: 'Quarter 1 data saved!'
              });

            }
          });

      })


      


      $(document).on('click','#btn_undo_q1',function()
      {

        // alert('undo data quarter 1');
        
        // var total_payment = $('#q1_total_payment_computation').val();
        
        $.ajax({
        url:'tax_compute/file8.php',
        method:"POST",
        data:'year_now='+year_now+'&branch_id='+branch_id+'&quarter_num=1',
        // dataType:'json',
            success:function(data)
            {

                  Swal.fire({
                  icon: 'success',
                  title: 'Quarter data revert!'
                  });


            $.ajax({
                url:'tax_compute/file1.php',
                method:"POST",
                data:'year_now='+year_now+'&branch_id='+branch_id+'&date_from='+date_from+'&date_to='+date_to,
                dataType:'json',
                success:function(data)
                {
                 $('#q1_vatable_sales').html(data.sales);
                 $('#q1_vatable_sales_percent').html(data.sales_percent);

                 $('#q1_domestic_purchase').html(data.domestic_purchase);
                 $('#q1_domestic_purchase_percent').html(data.domestic_purchase_percent);

                 $('#q1_calculated_risk').html(data.calculated_risk);
                 $('#q1_calculated_risk_percent').html(data.calculated_risk_percent);

                 $('#q1_total_payment_computation').val(data.total_as_is_payment_percent);
                 $('#q1_benchmark_total_vt_computation').html(data.benchmark);
                }
              });
                  
                  
            }
        });

      })


 		

 	})
 </script>




















