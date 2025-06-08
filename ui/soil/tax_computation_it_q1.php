
<!-- card collapse card open -->
<!-- <div class="card card-default"> -->
<div class="card card-default collapsed-card">    
    <div class="card-header" style="background-color:rgb(249,249,247); padding: 5px 10px;">
    <h3 class="card-title text-black"  style="font-weight:bold;">IT COMPUTATION QUARTER 1</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-card-widget="collapse">
        <i class="fas fa-plus"></i> <!-- Will show plus icon since it's collapsed -->
      </button>
    </div>
  </div>
<!-- card body open -->
<div class="card-body">

<table  border="1" width="100%">

  <!-- <input type="text" id="samplesampletext" name=""> -->

      
      <tr align="center">
        <td style="font-weight:bold;">DESCRIPTION</td>
        <td style="font-weight:bold;">AMOUNT</td>
      </tr>

      <tr align="center">
        <td><font size="2">Gross sales</font></td>
        <td align="center" id="#"><?= number_format($quarter1_it_data['grossincome'],2) ?></td>
      </tr>

      <tr align="center">
        <td><font size="2">Cost of sales</font></td>
        <td align="center" id="#"><?= number_format($quarter1_it_data['cost_of_sales'],2) ?></td>
      </tr>

      <tr align="center">
        <td><font size="2">Deductions</font></td>
        <td align="center" id="#"><?= number_format($quarter1_it_data['total_non_vat_purchase'] + $quarter1_it_data['total_vat_purchase'] + $quarter1_it_data['other_expenses_2'],2) ?></td>
      </tr>

      <!-- <tr align="center">
        <td><font size="2">Calculated risk</font></td>
        <td align="center" id="#">0.00</td>
      </tr> -->

      <tr align="center">
        <td><font size="2">Taxable income</font></td>
        <td align="center" id="#"><?= number_format($quarter1_it_data['taxable_income_to_date'],2) ?></td>
      </tr>


     <!--  <tr align="center">
        <td><font size="2">Preferred income tax</font></td>
        <td align="center" id="#"><?= number_format($quarter1_it_data['incometaxdue'],2) ?></td>
      </tr> -->

</table>

<br>

<center>
  <!-- <button class="btn btn-md btn-success" id="btn_edit_quarter1">Edit</button> -->
  <!-- <button class="btn btn-md btn-danger"  id="btn_undo_q1">Undo</button> -->
</center>


</div>
<!-- card body close -->

</div>
<!-- card collapse card close -->














