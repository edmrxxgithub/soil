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
	$yearnow = $_GET['yearnow'];
	$branchid = $_GET['branchid'];
	$monthfrom = $_GET['monthfrom'];
	$monthto = $_GET['monthto'];
}




$branchdata = fetch_branch_data($pdo,$branchid);
$quarter1_data = fetch_per_quarter_data($pdo,$yearnow,$branchid,1,3,1);



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




  <!-- Main content -->
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



<?php



if (isset($_POST['update_quarter_data'])) 
{


$total_risk_payment = $_POST['total_risk_payment'];
$quarter = $_POST['quarter'];
$yearnow = $_POST['yearnow'];
$branchid = $_POST['branchid'];

// Check if the record already exists
$select = $pdo->prepare("SELECT id FROM tb_tax_return_by_quarter 
                         WHERE quarter_num = :quarter 
                           AND year_num = :year 
                           AND branch_id = :branchid");
$select->execute([
    ':quarter' => $quarter,
    ':year' => $yearnow,
    ':branchid' => $branchid
]);

if ($select->rowCount() > 0) 
{
    // Record exists, update it
    $row = $select->fetch(PDO::FETCH_OBJ);

    $update = $pdo->prepare("UPDATE tb_tax_return_by_quarter 
                             SET payment_risk = :payment 
                             WHERE id = :id");
    $update->execute([
        ':payment' => $total_risk_payment,
        ':id' => $row->id
    ]);

    $_SESSION['status'] = "Data successfully updated!";
    $_SESSION['status_code'] = "success";
} 

else

{
    // Insert new record
    $insert = $pdo->prepare("INSERT INTO tb_tax_return_by_quarter 
                             (quarter_num, year_num, branch_id, payment_risk) 
                             VALUES (:quarter, :year, :branchid, :payment)");
    $insert->execute([
        ':quarter' => $quarter,
        ':year' => $yearnow,
        ':branchid' => $branchid,
        ':payment' => $total_risk_payment
    ]);

    $_SESSION['status'] = "Data successfully updated!";
    $_SESSION['status_code'] = "success";
}
  

}


$quarter1_data = fetch_per_quarter_data($pdo,$yearnow,$branchid,1,3,1);


?>



                <!-- card body open --> 
                <form action="" method="post">

                <div class="card-body">
                  <!-- row open --> 
                  <div class="col-md-12">
	                  <div class="row">
	                    	<div class="col-md-6">

							<table  border="1" width="100%">

							  <input type="hidden" name="quarter" value="<?= $quarter; ?>">
							  <input type="hidden" name="yearnow" value="<?= $yearnow; ?>">
							  <input type="hidden" name="branchid" value="<?= $branchid; ?>">

							      
							      <tr align="center">
							        <td style="font-weight:bold;">DESCRIPTION</td>
							        <td style="font-weight:bold;">AMOUNT</td>
							        <td style="font-weight:bold;">12%</td>
							      </tr>

							        <tr align="center">
							          <td><font size="2">Vatables Sales</font></td>
							          <td align="center" id="q1_vatable_sales"><?= number_format($quarter1_data['vatable_sales'],2) ?></td>
							          <td align="center" id="q1_vatable_sales_percent"><?= number_format($quarter1_data['vatable_sales'] * 0.12,2) ?></td>
							        </tr>

							      <tr align="center">
							        <td><font size="2">Domestic purchase</font></td>
							        <td align="center" id="q1_domestic_purchase"><?= number_format($quarter1_data['domestic_purchase'],2) ?></td>
							        <td align="center" id="q1_domestic_purchase_percent"><?= number_format($quarter1_data['domestic_purchase'] * 0.12,2) ?></td>
							      </tr>

							      <tr align="center">
							        <td><font size="2">Calculated risk</font></td>
							        <td align="center" id="q1_calculated_risk"><?= number_format($quarter1_data['calculated_risk_no_percent'],2) ?></td>
							        <td align="center" id="q1_calculated_risk_percent"><?= number_format($quarter1_data['calculated_risk_percent'],2) ?></td>
							      </tr>

							      <tr align="center">
							        <td style="font-weight:bold;">TOTAL</td>
							        <!-- <td class="text-black" colspan="2">
							          <input type="text" style="width: 100%; text-align: center;" id="q1_total_payment_computation" 
							           value="">
							        </td> -->
							        <td align="center" id="#"><?= number_format($quarter1_data['totalpaidrisk_no_percent'],2) ?></td>
							        <td align="center" id="#">
							        	<input type="text" style="width:100%;text-align:center;" value="<?= number_format($quarter1_data['totalpaidrisk_percent'],2,'.','') ?>" name="total_risk_payment" autocomplete="off">
							        </td>
							      </tr>


							      <tr align="center">
							        <td style="font-weight:bold;">BENCHMARK</td>
							        <td class="text-black" colspan="2" id="q1_benchmark_total_vt_computation" align="center" style="font-weight:bold;">
							          <?= number_format($quarter1_data['benchmark'],2) ?>%
							        </td>
							      </tr>

							</table>

							<center>
							<button type="submit" class="btn btn-primary btn-md mt-4" name="update_quarter_data">Update data</button>
							<!-- <button type="buttton" class="btn btn-danger btn-md mt-4" id="undo_quarter_data">Undo</button> -->
              <input type="button" class="btn btn-danger btn-md mt-4" id="undo_quarter_data" value="Undo data">
							</center>

	                    	</div>



	                  </div>
                  </div>
                  <!-- row close --> 
                </div>  
                <!-- card body close --> 

                <!-- card footer open --> 
                <div class="card-footer">
                  <div class="text-center">
                      <!-- <button type="submit" class="btn btn-primary btn-md" name="update_bank_account">Update data</button> -->
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



  <script type="text/javascript">
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
  </script>


















