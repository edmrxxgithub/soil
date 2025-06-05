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
                value="<?= number_format($quarter1_data['tax_actually_paid_success'],2) ?>"  disabled id="#" autocomplete="off">
          </font>
        </td>
      </tr>












