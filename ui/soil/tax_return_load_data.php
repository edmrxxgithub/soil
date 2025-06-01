<?php 
include_once 'connectdb.php';


$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];



$q1_data = fetch_quarter1_vatable_sales($pdo,$yearnow,$branchid);


function fetch_month_data($pdo,$yearnow,$monthnum,$branchid)
{
  $days_in_a_month = date("t", strtotime("$yearnow-$monthnum-01"));
  $date_from = $yearnow.'-'.$monthnum.'-01';
  $date_to = $yearnow.'-'.$monthnum.'-'.$days_in_a_month;

  $select = $pdo->prepare("

    SELECT 

    SUM(gross_amount) as total_gross_amount ,
    SUM(net_amount) as total_net_amount ,
    SUM(vat) as total_vat_amount 

    FROM tb_tax_sales 

    WHERE 

    date between '$date_from' and '$date_to' and branch_id = '$branchid' ");

  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  



  $select1 = $pdo->prepare("

    SELECT 

    SUM(gross_amount) as total_gross_amount ,
    SUM(net_amount) as total_net_amount ,
    SUM(vat) as total_vat_amount 

    FROM tb_tax_purchase 

    WHERE 

    date between '$date_from' and '$date_to' and branch_id = '$branchid' ");

  $select1->execute();
  $row1 = $select1->fetch(PDO::FETCH_OBJ);


  $select3 = $pdo->prepare("

    SELECT 

    
    SUM(net_amount) as total_net_amount 
    

    FROM tb_tax_vat_purchase 

    WHERE 

    date between '$date_from' and '$date_to' and branch_id = '$branchid' ");

  $select3->execute();
  $row3 = $select3->fetch(PDO::FETCH_OBJ);




  $select4 = $pdo->prepare("

    SELECT 

    
    SUM(gross_amount) as total_gross_amount 
    

    FROM tb_tax_non_vat_purchase 

    WHERE 

    date between '$date_from' and '$date_to' and branch_id = '$branchid' ");

  $select4->execute();
  $row4 = $select4->fetch(PDO::FETCH_OBJ);


  $array['total_net_amount'] =   $row->total_net_amount;
  $array['purchase_net_amount'] =   $row1->total_net_amount;
  $array['vat_purchase_net_amount'] =   $row3->total_net_amount;
  $array['total_non_vat_expense'] = $row4->total_gross_amount;
  

  return $array;
  
}




function fetch_quarter1_vatable_sales($pdo,$yearnow,$branchid)
{

  $total_vatable_sales = 0;
  $total_vatable_purchase_declaration = 0;
  $total_vatable_expense = 0;
  $total_non_vat_expense = 0;
  
  for ($monthnum = 1; $monthnum <= 3 ; $monthnum++) 
        { 

            $data_rr = fetch_month_data($pdo,$yearnow,$monthnum,$branchid);
            $total_vatable_sales += $data_rr['total_net_amount'];
            $total_vatable_purchase_declaration += $data_rr['purchase_net_amount'];
            $total_vatable_expense += $data_rr['vat_purchase_net_amount'];
            $total_non_vat_expense += $data_rr['total_non_vat_expense'];
        }


  $array['total_vatable_sales'] = $total_vatable_sales;
  $array['total_vatable_purchase_declaration'] = $total_vatable_purchase_declaration;
  $array['total_vat_purchase_expense'] = $total_vatable_expense;
  $array['total_non_vat_expense'] = $total_non_vat_expense;

  return $array;

}


?>




<!-- ///////////// QUARTER 1 TAX RETURN  /////////// -->
<div class="card card-default ">
<!-- <div class="card card-default collapsed-card"> -->
  <div class="card-header" style="background-color:rgba(12,25,60,255);">
    <h3 class="card-title text-white" >QUARTER 1</h3>

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
    
<div class="col-sm-12 col-md-6 col-lg-6">

  <input type="text" value="<?= number_format($q1_data['total_vatable_sales'],2,'.','') ?>" id="q1_vatable_sales">
  <input type="text" value="<?= number_format($q1_data['total_vatable_purchase_declaration'],2,'.','') ?>" id="q1_purchase_decleration">
  <input type="text" value="<?= number_format($q1_data['total_vat_purchase_expense'],2,'.','') ?>" id="q1_vat_total_expense">
  <input type="text" value="<?= number_format($q1_data['total_non_vat_expense'],2,'.','') ?>" id="q1_total_non_vat_expense">


  <table border="1" width="100%">
      <tr align="center">
        <th>
          <font class="text-black" size="2">Schedule #</font>
        </th>
        <th>
          <font class="text-black" size="2">VALUE-ADDED TAX INFORMATION</font>
        </th>
        <th>
          <font class="text-black" size="2">PRINCIPAL</font>
        </th>
        <th>
          <font class="text-black" size="2">ACCESSORY (12%)</font>
        </th>
      </tr>

      <tr>
        <td align="center"><font size="2">1</font></td>
        <td><font size="2">Vatable sales - Private</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($q1_data['total_vatable_sales'], 2,) ?>" id="q1_vatable_sales_principal">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_vatable_sales_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">2</font></td>
        <td><font size="2">Government sales</font></td>
        <td>
            <font size="2">
                <input style="width:100%" type="text" value="10000" id="q1_government_sales_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_government_sales_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">3</font></td>
        <td><font size="2">Zero rated sales</font></td>
        <td>
            <font size="2">
                <input style="width:100%" type="text" value="5000" id="q1_zero_rated_sales_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="0" id="q1_zero_rated_sales_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">4</font></td>
        <td><font size="2">Exempt sales</font></td>
        <td>
            <font size="2">
                <input style="width:100%" type="text" value="300000" id="q1_exempt_sales_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="0" id="q1_exempt_sales_accessory">
          </font>
        </td>
      </tr>





      <tr>
        <td align="center"><font size="2">5</font></td>
        <td><font size="2" style="font-weight: bold;">Total sales</font></td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_total_sales_principal">
          </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_total_sales_accessory">
          </font>
        </td>
      </tr>




      <tr>
        <td colspan="4"><br></td>
      </tr>

      <tr>
        <td align="center"><font size="2">6</font></td>
        <td><font size="2">Purchases Declaration</font></td>
        <td>
          <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($q1_data['total_vatable_purchase_declaration'], 2,) ?>" id="q1_purchase_decleration_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_purchase_decleration_accessory">
          </font>
        </td>
      </tr>



      <tr>
        <td align="center"><font size="2">7</font></td>
        <td><font size="2">VAT expenses</font></td>
        <td>
          <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($q1_data['total_vat_purchase_expense'], 2,) ?>" id="q1_vat_expense_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_vat_expense_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">8</font></td>
        <td><font size="2" style="font-weight: bold;">Total vat purchases</font></td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="total_vat_purchase_principal">
          </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="total_vat_purchase_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td colspan="4"><br></td>
      </tr>



      <tr>
        <td align="center"><font size="2">9</font></td>
        <td><font size="2">NonVAT Expenses</font></td>
        <td>
          <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($q1_data['total_vat_purchase_expense'], 2,) ?>" id="q1_non_vat_expense_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_vat_expense_accessory">
          </font>
        </td>
      </tr>



      <tr>
        <td align="center"><font size="2">10</font></td>
        <td><font size="2">Other Expenses</font></td>
        <td>
            <font size="2">
                <input style="width:100%" type="text" value="0" id="q1_other_expense_accessory">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_vat_expense_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td colspan="4"><br></td>
      </tr>

       <tr>
        <td align="center"><font size="2">11</font></td>
        <td><font size="2">Value-added Tax Due</font></td>
        <td>
            <font size="2">
                <input style="width:100%" type="text" value="0" id="q1_other_expense_accessory">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_vat_expense_accessory">
          </font>
        </td>
      </tr>


       <tr>
        <td align="center"><font size="2">12</font></td>
        <td><font size="2">Less: Tax Credits</font></td>
        <td>
            <font size="2">
                <input style="width:100%" type="text" value="0" id="q1_other_expense_accessory">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_vat_expense_accessory">
          </font>
        </td>
      </tr>

       <tr>
        <td align="center"><font size="2">13</font></td>
        <td><font size="2">VAT Payment - Previous</font></td>
        <td>
            <font size="2">
                <input style="width:100%" type="text" value="0" id="q1_other_expense_accessory">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_vat_expense_accessory">
          </font>
        </td>
      </tr>

       <tr>
        <td align="center"><font size="2">14</font></td>
        <td><font size="2">VAT Withheld Government - VWT</font></td>
        <td>
            <font size="2">
                <input style="width:100%" type="text" value="0" id="q1_other_expense_accessory">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_vat_expense_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td colspan="4"><br></td>
      </tr>

       <tr>
        <td align="center"><font size="2">15</font></td>
        <td><font size="2">Value-added Tax stil Payable</font></td>
        <td>
            <font size="2">
                <input style="width:100%" type="text" value="0" id="q1_other_expense_accessory">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_vat_expense_accessory">
          </font>
        </td>
      </tr>

       <tr>
        <td align="center"><font size="2">16</font></td>
        <td><font size="2">Value-added Tax Actually Paid (Successful)</font></td>
        <td>
            <font size="2">
                <input style="width:100%" type="text" value="0" id="q1_other_expense_accessory">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_vat_expense_accessory">
          </font>
        </td>
      </tr>


  </table>

  <center>
    <button class="btn btn-sm btn-primary mt-3" id="q1_compute_value_add_tax_info">Compute</button>
    <button class="btn btn-sm btn-success mt-3">Save data</button>
  </center>

  </div>

  </div>
  
</div>
<!-- ///////////// QUARTER 1 TAX RETURN  /////////// -->






<script type="text/javascript">
  $(document).ready(function()
  {


    var q1_vatable_sales = $('#q1_vatable_sales').val();
    var q1_purchase_decleration = $('#q1_purchase_decleration').val();
    var q1_vat_total_expense = $('#q1_vat_total_expense').val();
    var q1_total_non_vat_expense = $('#q1_total_non_vat_expense').val();

    $.ajax({
      url:'tax_compute_data1.php',
      method:"POST",
      data:'q1_vatable_sales='+q1_vatable_sales+
      '&q1_purchase_decleration='+q1_purchase_decleration+
      '&q1_vat_total_expense='+q1_vat_total_expense+'&q1_total_non_vat_expense='+q1_total_non_vat_expense,
      dataType:'json',
      success:function(data)
      {
          $('#q1_vatable_sales_accessory').val(data.q1_vatable_sales_accessory);
          $('#q1_purchase_decleration_accessory').val(data.q1_purchase_decleration_accessory);
          $('#q1_vat_expense_accessory').val(data.q1_vat_expense_accessory);
          $('#total_vat_purchase_principal').val(data.total_vat_purchase_principal);
          $('#total_vat_purchase_accessory').val(data.total_vat_purchase_accessory);
          $('#q1_non_vat_expense_principal').val(data.q1_total_non_vat_expense);
      }
    });


    
    // $(document).on('keyup','#q1_government_sales',function()
    // {

    //       var q1_government_sales = $('#q1_government_sales').val();
    //       var q1_vatable_sales = $('#q1_vatable_sales').val();

    //       $.ajax({
    //         url:'tax_compute_data2.php',
    //         method:"POST",
    //         data:'q1_government_sales='+q1_government_sales+
    //         '&q1_vatable_sales='+q1_vatable_sales,
    //         dataType:'json',
    //         success:function(data)
    //         {
    //             $('#q1_vatable_sales_accessory').val(data.q1_vatable_sales_accessory);
    //             $('#q1_government_accessory').val(data.q1_government_accessory);
    //             $('#q1_vatable_sales_principal').val(data.q1_vatable_sales_principal);
    //         }
    //       });

    // })

    $(document).on('click','#q1_compute_value_add_tax_info',function()
    {

      var q1_vatable_sales = $('#q1_vatable_sales').val();
      var q1_government_sales_principal = $('#q1_government_sales_principal').val();
      var q1_zero_rated_sales_principal = $('#q1_zero_rated_sales_principal').val();
      var q1_exempt_sales_principal = $('#q1_exempt_sales_principal').val();

      // alert(q1_vatable_sales+' '+q1_government_sales_principal+' '+q1_zero_rated_sales_principal+' '+q1_exempt_sales_principal);

            $.ajax({
            url:'tax_compute_data3.php',
            method:"POST",
            data:'q1_vatable_sales='+q1_vatable_sales+
            '&q1_government_sales_principal='+q1_government_sales_principal+
            '&q1_zero_rated_sales_principal='+q1_zero_rated_sales_principal+
            '&q1_exempt_sales_principal='+q1_exempt_sales_principal,
            dataType:'json',
            success:function(data)
            {
                $('#q1_vatable_sales_principal').val(data.q1_vatable_sales_principal);
                $('#q1_total_sales_principal').val(data.q1_total_sales_principal);
                $('#q1_vatable_sales_accessory').val(data.q1_vatable_sales_accessory);
                $('#q1_government_sales_accessory').val(data.q1_government_sales_accessory);
                $('#q1_total_sales_accessory').val(data.q1_total_sales_accessory);
            }
          });

    })


  })
</script>






























































