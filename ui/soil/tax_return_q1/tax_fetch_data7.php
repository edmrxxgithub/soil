    <tr>
        <td align="center"><font size="2">8</font></td>
        <td><font size="2">Net Taxable Income</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['taxable_income_to_date'],2) ?>" id="#">
          </font>
        </td>
      </tr>



<!-- total_non_vat_purchase
total_vat_purchase -->



      <tr>
        <td align="center"><font size="2">9</font></td>
        <td><font size="2">Add: Taxable Income - Previous Quarter</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="0" disabled  id="#">
          </font>
        </td>
      </tr>



      <tr>
        <td align="center"><font size="2">10</font></td>
        <td><font size="2">Total Taxable Income to Date</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" disabled style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['taxable_income_to_date'],2) ?>"  id="#">
          </font>
        </td>
      </tr>



      





