    <tr>
        <td align="center"><font size="2">17</font></td>
        <td><font size="2">Income Tax still Payable</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['net_taxable_income'] - $quarter1_data['total_swt_it'],2) ?>" disabled id="#">
          </font>
        </td>
    </tr>


    <tr>
        <td align="center"><font size="2">18</font></td>
        <td><font size="2">Income Tax  Actually Paid (Successful)</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="0" disabled id="#">
          </font>
        </td>
    </tr>