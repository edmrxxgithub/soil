<tr>
        <td align="center"><font size="2">6</font></td>
        <td><font size="2">Purchases Declaration</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['total_purchase'],2) ?>" id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['total_purchase'] * 0.12,2) ?>" id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">7</font></td>
        <td><font size="2">VAT Expenses</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="<?= number_format($quarter1_data['total_vat_purchase'],2) ?>" id="#" disabled>
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['total_vat_purchase'] * 0.12,2) ?>"  id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">8</font></td>
        <td><font size="2">Calculated risk</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align:center;" type="text" disabled value="<?= number_format($quarter1_data['calculated_risk_no_percent'],2) ?>" id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['calculated_risk_percent'],2) ?>" id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">9</font></td>
        <td><font size="2">Total VAT Purchases</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align:center;" type="text" disabled value="<?= number_format($quarter1_data['total_vat_purchase'] + $quarter1_data['total_purchase'] + $quarter1_data['calculated_risk_no_percent'],2) ?>" id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format(($quarter1_data['total_vat_purchase'] + $quarter1_data['total_purchase'] + $quarter1_data['calculated_risk_no_percent']) * 0.12 ,2) ?>" id="#">
          </font>
        </td>
      </tr>








