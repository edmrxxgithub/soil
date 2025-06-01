    <tr>
        <td align="center"><font size="2">14</font></td>
        <td><font size="2">Less: Tax Credits</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="#">
          </font>
        </td>
    </tr>


    <tr>
        <td align="center"><font size="2">15</font></td>
        <td><font size="2">IT Payment - Previous</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="0"  id="q4_it_payment_previous_principal">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="#">
          </font>
        </td>
    </tr>


    <tr>
        <td align="center"><font size="2">16</font></td>
        <td><font size="2">IT Withheld - CWT</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($data_rr['total_swt_it'],2) ?>" disabled id="q4_it_withheld_cwt_principal">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="" disabled id="q4_it_withheld_cwt_accessory">
          </font>
        </td>
    </tr>


