<?php 
include_once 'connectdb.php';
include_once 'tax_compute/function2.php';

$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];


$quarter1_data = fetch_data($pdo,1,3,1,$yearnow,$branchid);


?>


<input type="hidden" id="sample_fetch_data" name="">
<input type="hidden" id="quarter_num" value="<?= $quarter_num ?>">
<input type="hidden" id="branch_id"   value="<?= $branchid ?>">
<input type="hidden" id="year_now"   value="<?= $yearnow ?>">



<!-- ///////////// QUARTER 1 TAX RETURN  /////////// -->
<div class="card card-default ">
<!-- <div class="card card-default collapsed-card"> -->
  <!-- <div class="card-header" style="background-color:rgba(12,25,60,255);"> -->
    <div class="card-header" style="background-color:rgb(237,233,207,255);">
    <h3 class="card-title text-black" >QUARTER 1</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-plus"></i> <!-- Will show plus icon since it's collapsed -->
      </button>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">

    <center>
      <h4>TAX RETURNS INFORMATION</h4>
    </center>
    
<div class="col-sm-12 col-md-12 col-lg-12">
  <div class="row">
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

            <?php include_once 'tax_return_q1/tax_fetch_data3.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>
            
            <?php include_once 'tax_return_q1/tax_fetch_data4.php'?>

            <tr>
              <td colspan="4"><br></td>
            </tr>

            <?php include_once 'tax_return_q1/tax_fetch_data5.php'?>
      
      </table>

    <!-- <center>
      <button class="btn btn-sm btn-primary mt-3" id="q1_compute_value_add_tax_info">Compute</button>
      <button class="btn btn-sm btn-success mt-3">Save data</button>
    </center> -->

  </div>  




<div class="col-sm-12 col-md-6 col-lg-6">

  <table border="1" width="100%">

    <tr align="center"><th><font class="text-black" size="2">SCHEDULE #</font></th>
      <th><font class="text-black" size="2">INCOME TAX INFORMATION</font></th>
      <th><font class="text-black" size="2"></font></th>
      <th><font class="text-black" size="2"></font></th>
    </tr>

    <?php include_once 'tax_return_q1/tax_fetch_data6.php'?>

    <tr>
      <td colspan="4"><br></td>
    </tr>

    <?php include_once 'tax_return_q1/tax_fetch_data7.php'?>

    <tr>
      <td colspan="4"><br></td>
    </tr>

    <?php include_once 'tax_return_q1/tax_fetch_data8.php'?>

    <tr>
      <td colspan="4"><br></td>
    </tr>

    <?php include_once 'tax_return_q1/tax_fetch_data9.php'?>

    <tr>
      <td colspan="4"><br></td>
    </tr>

    <?php include_once 'tax_return_q1/tax_fetch_data10.php'?>
      
  </table>

</div>



      <div class="col-sm-12 col-md-12 col-lg-12">
        <center>
            <!-- <button class="btn btn-sm btn-primary mt-3" style="display: none;" id="q1_compute_value_add_tax_info">Compute</button> -->
            <button class="btn btn-md btn-success mt-3" id="btn_edit_all_data_quarter1">Edit data</button>
        </center>
      </div>



  </div>
</div>
















  </div>
  
</div>
<!-- ///////////// QUARTER 1 TAX RETURN  /////////// -->







 <script type="text/javascript">
  $(document).ready(function()
  {


        var year_now = '<?= $yearnow ?>';
        var branch_id = '<?= $branchid ?>';
    

        $(document).on('click','#btn_edit_all_data_quarter1',function()
        {

            window.location.href = "tax_view_quarter_all_data.php?quarter=1&yearnow="+year_now+'&branchid='+branch_id+'&monthfrom=1&monthto=3';

        })



  })
 </script>


































































