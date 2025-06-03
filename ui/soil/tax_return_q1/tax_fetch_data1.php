<tr>
        <td align="center"><font size="2">1</font></td>
        <td><font size="2">Vatable sales - Private</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['total_sales'],2) ?>" id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['total_sales'] * 0.12,2) ?>" id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">2</font></td>
        <td><font size="2">Government sales</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align:center;" type="text" value="<?= number_format($quarter1_data['total_government_sales'],2) ?>" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['total_government_sales'] * 0.12,2) ?>" id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">3</font></td>
        <td><font size="2">Zero rated sales</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align:center;" type="text" value="<?= number_format($quarter1_data['total_zero_rated_sales'],2) ?>" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">4</font></td>
        <td><font size="2">Exempt sales</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align:center;" type="text" disabled value="<?= number_format($quarter1_data['total_exempt_sales'],2) ?>" id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="" id="#">
          </font>
        </td>
      </tr>





      <tr>
        <td align="center"><font size="2">5</font></td>
        <td><font size="2" >Total sales</font></td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format($quarter1_data['total_sales_revenue'],2) ?>" id="q1_total_sales_principal">
          </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;" disabled 
                value="<?= number_format(($quarter1_data['total_sales'] + $quarter1_data['total_government_sales']) * 0.12,2) ?>" id="q1_total_sales_accessory">
          </font>
        </td>
      </tr>