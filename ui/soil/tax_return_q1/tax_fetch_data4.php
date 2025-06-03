    <tr>
        <td align="center"><font size="2">12</font></td>
        <td><font size="2">Value-added Tax Due</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format((($quarter1_data['total_sales'] + $quarter1_data['total_government_sales']) - ($quarter1_data['total_purchase'] + $quarter1_data['total_vat_purchase'] +  $quarter1_data['calculated_risk_no_percent'])),2) ?>" id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format((($quarter1_data['total_sales'] + $quarter1_data['total_government_sales']) - ($quarter1_data['total_purchase'] + $quarter1_data['total_vat_purchase'] +  $quarter1_data['calculated_risk_no_percent'])) * 0.12,2) ?>" id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">13</font></td>
        <td><font size="2">Less: Tax Credits</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="q1_tax_credits_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value=""  id="q1_tax_credits_accessory">
          </font>
        </td>
      </tr>


    <tr>
        <td align="center"><font size="2">14</font></td>
        <td><font size="2">VAT Payment - Previous</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="0" disabled id="q1_vat_payment_previous_principal">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">15</font></td>
        <td><font size="2">VAT Withheld Government - VWT</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="<?= number_format($quarter1_data['total_swt_vt'],2) ?>" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['total_swt_vt'],2) ?>"  id="#">
          </font>
        </td>
      </tr>








