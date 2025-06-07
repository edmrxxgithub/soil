
<!-- card collapse card open -->
<!-- <div class="card card-default"> -->
<div class="card card-default collapsed-card">    
    <div class="card-header" style="background-color:rgb(249,249,247); padding: 5px 10px;">
    <h3 class="card-title text-black"  style="font-weight:bold;">VT COMPUTATION QUARTER 4</h3>

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
        <td style="font-weight:bold;">12%</td>
      </tr>

        <tr align="center">
          <td><font size="2">Vatables Sales</font></td>
          <td align="center" id="q1_vatable_sales"><?= number_format($quarter4_data['vatable_sales'],2) ?></td>
          <td align="center" id="q1_vatable_sales_percent"><?= number_format($quarter4_data['vatable_sales'] * 0.12,2) ?></td>
        </tr>

      <tr align="center">
        <td><font size="2">Domestic purchase</font></td>
        <td align="center" id="q1_domestic_purchase"><?= number_format($quarter4_data['domestic_purchase'],2) ?></td>
        <td align="center" id="q1_domestic_purchase_percent"><?= number_format($quarter4_data['domestic_purchase'] * 0.12,2) ?></td>
      </tr>

      <tr align="center">
        <td><font size="2">Calculated risk</font></td>
        <td align="center" id="q1_calculated_risk"><?= number_format($quarter4_data['calculated_risk_no_percent'],2) ?></td>
        <td align="center" id="q1_calculated_risk_percent"><?= number_format($quarter4_data['calculated_risk_percent'],2) ?></td>
      </tr>

      <tr align="center">
        <td style="font-weight:bold;">TOTAL</td>
        <!-- <td class="text-black" colspan="2">
          <input type="text" style="width: 100%; text-align: center;" id="q1_total_payment_computation" 
           value="">
        </td> -->
        <td align="center" id="q1_total_payment_computation"><?= number_format($quarter4_data['totalpaidrisk_no_percent'],2) ?></td>
        <td align="center" id="q1_total_payment_computation"><?= number_format($quarter4_data['totalpaidrisk_percent'],2) ?></td>
      </tr>


      <tr align="center">
        <td style="font-weight:bold;">BENCHMARK</td>
        <td class="text-black" colspan="2" id="q1_benchmark_total_vt_computation" align="center" style="font-weight:bold;">
          <?= number_format($quarter4_data['benchmark'],2) ?>%
        </td>
      </tr>

</table>

<br>

<center>
  <button class="btn btn-md btn-success" id="btn_edit_quarter4">Edit</button>
  <!-- <button class="btn btn-md btn-danger"  id="btn_undo_q1">Undo</button> -->
</center>


</div>
<!-- card body close -->

</div>
<!-- card collapse card close -->














