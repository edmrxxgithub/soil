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
            <input style="width:100%;text-align: center;" disabled type="text" value="<?= number_format($quarter1_data['other_expenses'],2) ?>" id="q1_other_expense_principal">
        </font>
    </td>
    <td>
      <font size="2">
        <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
            value=""  id="q1_vat_expense_accessory">
      </font>
    </td>
</tr>











