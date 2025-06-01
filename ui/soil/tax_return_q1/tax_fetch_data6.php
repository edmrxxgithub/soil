    <tr>
        <td align="center"><font size="2">1</font></td>
        <td><font size="2">Total Sales Revenue</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_total_sales_revenue_principal">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q1_total_sales_revenue_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">2</font></td>
        <td><font size="2">Less: Cost of Sales </font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="0"  id="q1_less_cost_of_sales_accessory">
          </font>
        </td>
      </tr>







      <tr>
        <td align="center"><font size="2">3</font></td>
        <td><font size="2">Gross income</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" disabled style="width: 100%; text-align: center; box-sizing: border-box;"  
                value=""  id="q1_gross_sales_accessory">
          </font>
        </td>
      </tr>











            <tr>
              <td colspan="4"><br></td>
            </tr>

















            <tr>
        <td align="center"><font size="2">4</font></td>
        <td><font size="2">Less: Deductions</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="q1_tax_actual_paid_principal">
            </font>
        </td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="q1_cost_of_sales_principal">
            </font>
        </td>
      </tr>




            <tr>
        <td align="center"><font size="2">5</font></td>
        <td><font size="2">VAT Expenses</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="<?= number_format($data_rr['total_vat_purchase'],2) ?>" disabled id="#">
            </font>
        </td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
      </tr>




    <tr>
        <td align="center"><font size="2">6</font></td>
        <td><font size="2">NonVAT Expenses</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="<?= number_format($data_rr['total_non_vat_purchase'],2) ?>" disabled id="q1_tax_actual_paid_principal">
            </font>
        </td>
        <td>
            <!-- <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="<?= number_format($data_rr['total_non_vat_purchase'] + $data_rr['total_vat_purchase'],2) ?>" disabled id="q1_cost_of_sales_principal">
            </font> -->
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="q1_cost_of_sales_principal">
            </font>
        </td>
    </tr>



    <tr>
        <td align="center"><font size="2">7</font></td>
        <td><font size="2">Other Expenses</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="0"  id="q1_other_expenses_value_principal_2">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" disabled style="width: 100%; text-align: center; box-sizing: border-box;"  
                value=""  id="q1_other_expenses_value_acessory_2">
          </font>
        </td>
      </tr>





