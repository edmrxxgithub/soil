<tr>
        <td align="center"><font size="2">6</font></td>
        <td><font size="2">Purchases Declaration</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($data_rr['total_purchase'],2) ?>" id="q4_purchase_declaration_accessory">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($data_rr['total_purchase'] * 0.12,2) ?>" id="q4_purchase_declaration_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">7</font></td>
        <td><font size="2">VAT Expenses</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="<?= number_format($data_rr['total_vat_purchase'],2) ?>" id="q4_vat_expense_principal" disabled>
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($data_rr['total_vat_purchase'] * 0.12,2) ?>"  id="q4_vat_expense_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">8</font></td>
        <td><font size="2">Calculated risk</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align:center;" type="text" disabled value="0" id="q4_calculated_risk_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="0" id="q4_calculated_risk_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">9</font></td>
        <td><font size="2">Total VAT Purchases</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align:center;" type="text" disabled value="<?= number_format($data_rr['total_vat_purchase'] + $data_rr['total_purchase'],2) ?>" id="q4_total_vat_purchase_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($data_rr['total_vat_purchase'] * 0.12 + $data_rr['total_purchase'] * 0.12,2) ?>" id="q4_total_vat_purchase_accessory">
          </font>
        </td>
      </tr>








