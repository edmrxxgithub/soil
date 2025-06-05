    <tr>
        <td align="center"><font size="2">11</font></td>
        <td><font size="2">Tax Rate %</font></td>

        <td align="center">
            <font size="2">
                <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= $quarter1_data['tax_rate'] ?>" disabled id="#">
            </font>
        </td>

        <td align="center">
          <font size="2" id="">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['tax_rate_percent'],2) ?>" disabled id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">12</font></td>
        <td><font size="2">MCIT %</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="<?= $quarter1_data['mcit'] ?>" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['mcit_percent'],2) ?>" disabled id="q1_mcit_percent_accessory">
          </font>
        </td>
      </tr>



      <tr>
        <td align="center"><font size="2">12</font></td>
        <td><font size="2">Preferred Income Tax Due</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['preferred_income_tax_due'],2) ?>" disabled id="#">
          </font>
        </td>
      </tr>


      <tr>
        <td align="center"><font size="2">13</font></td>
        <td><font size="2">Income Tax Due</font></td>
        <td>
            <font size="2">
                <input style="width:100%;text-align: center;" type="text" value="" disabled id="#">
            </font>
        </td>
        <td>
          <font size="2">
            <input type="text" disabled style="width: 100%; text-align: center; box-sizing: border-box;"  
                value="<?= number_format($quarter1_data['incometaxdue'],2) ?>"  id="#">
          </font>
        </td>
      </tr>







