<?php
include_once 'connectdb.php';
include_once 'function.php';
include_once 'tax_compute/function2.php';

session_start();

if($_SESSION['userid']=="" )
{

header('location:../../index.php');

}
else
{
  	$quarter = $_GET['quarter'];
  	$yearnowphp = $_GET['yearnow'];
  	$branchid = $_GET['branchid'];
  	$monthfrom = $_GET['monthfrom'];
  	$monthto = $_GET['monthto'];
}




$branchdata = fetch_branch_data($pdo,$branchid);
$quarter1_data = fetch_data($pdo,$monthfrom,$monthto,$quarter,$yearnowphp,$branchid);
// fetch_data($pdo,$monthfrom,$monthto,$quarter_num,$yearnow,$branchid)

include_once "header.php";


// echo $quarter.' '.$yearnow.' '.$branchid.' '.$monthfrom.' '.$monthto;

?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Admin Dashboard</h1> -->
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li> -->
          </ol>
        </div>
        <!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

<?php

// echo $quarter.' '.$yearnowphp.' '.$branchid.' '.$monthfrom.' '.$monthto;

// echo $quarter1_data['total_sales_revenue'];
// echo '<br>';
// echo $taxable_income_to_date;
// echo '<br>';
// echo $rowdata->tax_rate;
// echo '<br>';
// echo $tax_rate_percent ;
// echo '<br>';
// echo $grossincome;
// echo '<br>';
// echo $mcit_percent;
// echo '<br>';
// echo $preferred_income_tax_due;

if (isset($_POST['update_data'])) 
{


        $quarter = $_POST['quarter'];
        $yearnow = $_POST['yearnow'];
        $branchid = $_POST['branchid'];

        $other_expenses = $_POST['q1_other_expenses'];
        $tax_actually_paid_success = $_POST['q1_tax_actually_paid'];
        $cost_of_sales = $_POST['q1_less_cost_of_sales'];
        $other_expenses_2 = $_POST['q1_other_expenses_value_principal_2'];
        $tax_rate = $_POST['q1_tax_rate_percent'];
        $mcit = $_POST['q1_mcit_percent'];
        $preferred_income_tax_due = $_POST['q1_preffered_income_tax_due'];
        $income_tax_actually_paid_success = $_POST['q1_income_tax_actually_paid'];

        $check_quarter_if_existing = fetch_data_data1($pdo,$quarter,$yearnow,$branchid);
        $tablename = 'tb_tax_return';


        $data = 
        [
            'quarter_num' => $quarter,
            'branch_id' => $branchid,
            'year_num' => $yearnow,

            'other_expenses' => $other_expenses,
            'tax_actually_paid_success' => $tax_actually_paid_success,
            'cost_of_sales' => $cost_of_sales,
            'preferred_income_tax_due' => $preferred_income_tax_due,
            'tax_rate' => $tax_rate,
            'other_expenses_2' => $other_expenses_2,
            'mcit' => $mcit,
            'income_tax_actually_paid_success' => $income_tax_actually_paid_success
        ];





        if ($check_quarter_if_existing > 0) 
        {
            $fetchid = fetch_quarter_id($pdo,$quarter,$branchid,$yearnow);
            update_data($pdo, $tablename, $data, $fetchid);
            $_SESSION['status']="Data updated successfully!";
            $_SESSION['status_code']="success";
        }
        else
        {   
            insert_data($pdo, $tablename, $data);
            $_SESSION['status']="Data inserted successfully!";
            $_SESSION['status_code']="success";
        }




$quarter1_data = fetch_data($pdo,$monthfrom,$monthto,$quarter,$yearnow,$branchid);



  
}






?>


  <div class="content">
  <!-- container fluid open --> 
    <div class="container-fluid">
      <!-- row open --> 
      <div class="row">
        <!-- col md 12 open --> 
        <div class="col-md-12">

            <div class="card card-grey card-outline">
                <div class="card-header" style="background-color:rgba(50,63,81,255);">
                    <h5 class="m-0 text-white" >
                      <a href="tax_client.php" class="text-white">View Clients</a> 
                       / 
                      <a href="tax_view_client.php?id=<?= $branchdata['clientid']; ?>" class="text-white"><?= $branchdata['clientname']; ?></a> 
                      /
                      <a href="tax_view_client_business.php?id=<?= $branchdata['businessid']; ?>" class="text-white"><?= $branchdata['businessname']; ?></a> 
                      /
                      <a href="tax_view_branch_data.php?id=<?= $branchdata['branchid']; ?>&yearnow=<?= $yearnow ?>" class="text-white"><?= $branchdata['branchname']; ?></a> 
                      /
                      Quarter <?= $quarter ?> data
                    </h5>
                </div>








                
                <form action="" method="post">

                <!-- card body open --> 
                <div class="card-body">
                  <!-- row open --> 
                  <div class="row">

<div class="col-md-12">
     <center>
      <h4>UPDATE TAX RETURNS INFORMATION</h4>
    </center>
</div>
   



<input type="hidden" value="<?= $quarter ?>"  name="quarter">
<input type="hidden" value="<?= $yearnowphp ?>"  name="yearnow">
<input type="hidden" value="<?= $branchid ?>" name="branchid">

<div class="col-sm-12 col-md-6 col-lg-6">

      <table border="1" width="100%">

            <tr align="center"><th><font class="text-black" size="2">SCHEDULE #</font></th>
              <th><font class="text-black" size="2">VALUE-ADDED TAX INFORMATION</font></th>
              <th><font class="text-black" size="2"></font></th>
              <th><font class="text-black" size="2"></font></th>
            </tr>

            <?php include_once 'tax_return_q1/tax_fetch_data1.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

            <?php include_once 'tax_return_q1/tax_fetch_data2.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

            <tr>
              <td align="center"><font size="2">10</font></td>
              <td><font size="2">NonVAT Expenses</font></td>

              <td align="center">
                  <font size="2">
                      <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                      value="<?= number_format($quarter1_data['total_non_vat_purchase'],2) ?>" id="q1_non_vat_purchase_principal">
                  </font>
              </td>

              <td align="center">
                <font size="2" id="">
                  <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                      value="" id="q1_non_vat_purchase_accessory">
                </font>
              </td>
            </tr>


          <tr>
              <td align="center"><font size="2">11</font></td>
              <td><font size="2">Other Expenses</font></td>
              <td>
                  <font size="2">
                      <input style="width:100%;text-align: center;" type="text" autocomplete="off" required value="<?= $quarter1_data['other_expenses'] ?>" name="q1_other_expenses">
                  </font>
              </td>
              <td>
                <font size="2">
                  <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                      value=""  id="#">
                </font>
              </td>
          </tr>

            <tr>
              <td colspan="4"><br></td>
            </tr>
            
            <?php include_once 'tax_return_q1/tax_fetch_data4.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

      <tr>
        <td align="center"><font size="2">16</font></td>
        <td><font size="2">Value-added Tax stil Payable</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_value_added_tax_payable_principal">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format(((($quarter1_data['total_sales'] + $quarter1_data['total_government_sales']) - ($quarter1_data['total_purchase'] + $quarter1_data['total_vat_purchase'] +  $quarter1_data['calculated_risk_no_percent'])) * 0.12) - $quarter1_data['total_swt_vt'],2) ?>" id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">17</font></td>
        <td><font size="2">Value-added Tax Actually Paid (Successful)</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= $quarter1_data['tax_actually_paid_success']; ?>" required name="q1_tax_actually_paid" autocomplete="off">
          </font>
        </td>
      </tr>
      
      </table>

</div>



<div class="col-sm-12 col-md-6 col-lg-6">

  <table border="1" width="100%">

    <tr align="center"><th><font class="text-black" size="2">SCHEDULE #</font></th>
      <th><font class="text-black" size="2">INCOME TAX INFORMATION</font></th>
      <th><font class="text-black" size="2"></font></th>
      <th><font class="text-black" size="2"></font></th>
    </tr>

    <tr>
        <td align="center"><font size="2">1</font></td>
        <td><font size="2">Total Sales Revenue</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_total_sales_revenue_principal">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['total_sales_revenue'],2) ?>" id="q1_total_sales_revenue_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">2</font></td>
        <td><font size="2">Less: Cost of Sales </font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= $quarter1_data['cost_of_sales'] ?>" autocomplete="off" required name="q1_less_cost_of_sales">
          </font>
        </td>
      </tr>







      <tr>
        <td align="center"><font size="2">3</font></td>
        <td><font size="2">Gross income</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" disabled style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['grossincome'] ,2) ?>"  id="q1_gross_sales_accessory">
          </font>
        </td>
      </tr>











            <tr>
              <td colspan="4"><br></td>
            </tr>

















            <tr>
        <td align="center"><font size="2">4</font></td>
        <td><font size="2">Less: Deductions</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="q1_tax_actual_paid_principal">
            </font>
        </td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="q1_cost_of_sales_principal">
            </font>
        </td>
      </tr>




            <tr>
        <td align="center"><font size="2">5</font></td>
        <td><font size="2">VAT Expenses</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="<?= number_format($quarter1_data['total_vat_purchase'],2) ?>" disabled id="#">
            </font>
        </td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
      </tr>




    <tr>
        <td align="center"><font size="2">6</font></td>
        <td><font size="2">NonVAT Expenses</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="<?= number_format($quarter1_data['total_non_vat_purchase'],2) ?>" disabled id="q1_tax_actual_paid_principal">
            </font>
        </td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="q1_cost_of_sales_principal">
            </font>
        </td>
    </tr>



    <tr>
        <td align="center"><font size="2">7</font></td>
        <td><font size="2">Other Expenses</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="<?= $quarter1_data['other_expenses_2'] ?>" autocomplete="off" required name="q1_other_expenses_value_principal_2">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" disabled style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['total_non_vat_purchase'] + $quarter1_data['total_vat_purchase'] + $quarter1_data['other_expenses_2'],2) ?>"  id="#">
          </font>
        </td>
      </tr>

    <tr>
      <td colspan="4"><br></td>
    </tr>

        <tr>
        <td align="center"><font size="2">8</font></td>
        <td><font size="2">Net Taxable Income</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="#">
            </font>
        </td>



        <td align="center">
          <font size="2">
            <input type="text" disabled style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['taxable_income_to_date'],2) ?>"  id="#">
          </font>
        </td>
      </tr>




      <tr>
        <td align="center"><font size="2">9</font></td>
        <td><font size="2">Add: Taxable Income - Previous Quarter</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="0" disabled  id="#">
          </font>
        </td>
      </tr>



      <tr>
        <td align="center"><font size="2">10</font></td>
        <td><font size="2">Total Taxable Income to Date</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" disabled style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['taxable_income_to_date'],2) ?>"  id="#">
          </font>
        </td>
      </tr>

    <tr>
      <td colspan="4"><br></td>
    </tr>

        <tr>
        <td align="center"><font size="2">11</font></td>
        <td><font size="2">Tax Rate %</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= $quarter1_data['tax_rate'] ?>" required autocomplete="off" name="q1_tax_rate_percent">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['tax_rate_percent'],2) ?>" disabled id="#">
          </font>
        </td>
      </tr>





      <tr>
        <td align="center"><font size="2">12</font></td>
        <td><font size="2">MCIT %</font></td>
        <td>
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= $quarter1_data['mcit'] ?>" required autocomplete="off" name="q1_mcit_percent">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['mcit_percent'],2) ?>" disabled id="q1_mcit_percent_accessory">
          </font>
        </td>
      </tr>



      <tr>
        <td align="center"><font size="2">13</font></td>
        <td><font size="2">Preferred Income Tax Due</font></td>
        <td>
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled autocomplete="off" name="q1_preffered_income_tax_due">
            </font>
        </td>
        <td>
          <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= $quarter1_data['preferred_income_tax_due'] ?>" required autocomplete="off" name="q1_preffered_income_tax_due">
            </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">14</font></td>
        <td><font size="2">Income Tax Due</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" disabled style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['incometaxdue'],2) ?>"  id="#">
          </font>
        </td>
      </tr>









    <tr>
      <td colspan="4"><br></td>
    </tr>

        <tr>
        <td align="center"><font size="2">15</font></td>
        <td><font size="2">Less: Tax Credits</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="#">
          </font>
        </td>
    </tr>


    <tr>
        <td align="center"><font size="2">16</font></td>
        <td><font size="2">IT Payment - Previous</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="0" disabled id="q1_it_payment_previous_principal">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="#">
          </font>
        </td>
    </tr>


    <tr>
        <td align="center"><font size="2">17</font></td>
        <td><font size="2">IT Withheld - CWT</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['total_swt_it'],2) ?>" disabled id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['total_swt_it'],2) ?>" disabled id="#">
          </font>
        </td>
    </tr>

    <tr>
      <td colspan="4"><br></td>
    </tr>

        <tr>
        <td align="center"><font size="2">18</font></td>
        <td><font size="2">Income Tax still Payable</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['incometaxdue'] - $quarter1_data['total_swt_it'],2) ?>" disabled id="#">
          </font>
        </td>
    </tr>


    <tr>
        <td align="center"><font size="2">19</font></td>
        <td><font size="2">Income Tax  Actually Paid (Successful)</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="#">
            </font>
        </td>

        <td align="center">
          <font size="2">
            <input type="text"  style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= $quarter1_data['income_tax_actually_paid_success'] ?>" autocomplete="off" required name="q1_income_tax_actually_paid">
          </font>
        </td>
    </tr>
      
  </table>

</div>









                  </div>
                  <!-- row close --> 
                </div>  
                <!-- card body close --> 

                <!-- card footer open --> 
                <div class="card-footer">
                  <div class="text-center">
                      <button type="submit" class="btn btn-primary btn-md" name="update_data">Confirm update data</button>
                  </div>
                </div>
                <!-- card footer close --> 

              </form>





















            </div>

          </div>
          <!-- col md 12 open --> 
        </div>
        <!-- row close --> 
      </div>
      <!-- container fluid close --> 
    </div>
   <!-- Main content close -->


</div>
<!-- /.content-wrapper -->


<?php

include_once "footer.php";

?>





<?php
  if(isset($_SESSION['status']) && $_SESSION['status']!='')
 
  {

?>
<script>

  
     Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      });

</script>
<?php
unset($_SESSION['status']);
  }
  ?>



  <!-- <script type="text/javascript">
  	$(document).ready(function()
  	{

  		var quarter = '<?= $quarter ?>';
  		var yearnow = '<?= $yearnow ?>';
  		var branchid = '<?= $branchid ?>';

  		

  		$(document).on('click','#undo_quarter_data',function()
  		{

  		
        Swal.fire({
            title: 'Confirm undo data?',
            text: "Press yes to continue!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
          }).then((result) => 
          {
            if (result.isConfirmed) 
            {

               $.ajax({
                url:'tax_compute/file9.php',
                method:"POST",
                data:'quarter='+quarter+'&yearnow='+yearnow+'&branchid='+branchid,
                success:function(data)
                {  
                   
                   window.location.href = window.location.href;

                }
               });

            }

          }) 


  		 })


  	})
  </script> -->


















