<tr>
        <td align="center"><font size="2">1</font></td>
        <td><font size="2">Vatable sales - Private</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($data_rr['total_sales'],2) ?>" id="q4_vatable_sales_principal">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($data_rr['total_sales'] * 0.12,2) ?>" id="q4_vatable_sales_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">2</font></td>
        <td><font size="2">Government sales</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align:center;" type="text" value="0" id="q4_government_sales_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q4_government_sales_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">3</font></td>
        <td><font size="2">Zero rated sales</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align:center;" type="text" value="0" id="q4_zero_rated_sales_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="0" id="q4_zero_rated_sales_accessory">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">4</font></td>
        <td><font size="2">Exempt sales</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align:center;" type="text" value="0" id="q4_exempt_sales_principal">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="0" id="q4_exempt_sales_accessory">
          </font>
        </td>
      </tr>





      <tr>
        <td align="center"><font size="2">5</font></td>
        <td><font size="2" >Total sales</font></td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q4_total_sales_principal">
          </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="q4_total_sales_accessory">
          </font>
        </td>
      </tr>