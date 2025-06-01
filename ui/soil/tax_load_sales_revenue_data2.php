<?php
include_once 'connectdb.php';
include_once 'function.php';

$yearnow = $_GET['yearnow'];
$branchid = $_GET['branchid'];

function fetch_month_data($pdo, $yearnow, $monthnum, $branchid)
{
  $days_in_a_month = date("t", strtotime("$yearnow-$monthnum-01"));
  $date_from = "$yearnow-$monthnum-01";
  $date_to = "$yearnow-$monthnum-$days_in_a_month";

  $select = $pdo->prepare("
    SELECT 
      SUM(gross_amount) AS total_gross_amount,
      SUM(net_amount) AS total_net_amount,
      SUM(vat) AS total_vat_amount 
    FROM tb_tax_sales 
    WHERE date BETWEEN :date_from AND :date_to AND branch_id = :branchid
  ");
  $select->execute([':date_from' => $date_from, ':date_to' => $date_to, ':branchid' => $branchid]);

  $row = $select->fetch(PDO::FETCH_OBJ);
  return [
    'total_gross_amount' => $row->total_gross_amount ?: 0,
    'total_net_amount'   => $row->total_net_amount ?: 0,
    'total_vat_amount'   => $row->total_vat_amount ?: 0
  ];
}
?>

<table border="1" width="100%">
  <tr align="center">
    <th colspan="6" style="background-color:rgba(12,25,60,255);">
      <font class="text-white">SALES REVENUE <?= htmlspecialchars($yearnow) ?></font>
    </th>
  </tr>
  <tr align="center">
    <td style="font-weight:bold;">PERIOD</td>
    <td style="font-weight:bold;">NET AMOUNT</td>
    <td style="font-weight:bold;">VAT</td>
    <td style="font-weight:bold;">GROSS AMOUNT</td>
    <td style="font-weight:bold;">DECLARED</td>
  </tr>

  <?php
  $gross_amountf = $net_amountf = $vatf = 0;

  for ($monthnum = 1; $monthnum <= 12; $monthnum++) {
    $monthnow_word = date("F", strtotime("$yearnow-$monthnum-01"));
    $data_rr = fetch_month_data($pdo, $yearnow, $monthnum, $branchid);

    $gross_amount = $data_rr['total_gross_amount'];
    $vat_amount = $data_rr['total_vat_amount'];
    $net_of_vat_amount = $data_rr['total_net_amount'];

    $gross_amountf += $gross_amount;
    $net_amountf += $net_of_vat_amount;
    $vatf += $vat_amount;
    ?>

    <tr>
      <td><?= $monthnow_word ?></td>
      <td align="center"><?= number_format($net_of_vat_amount, 2) ?></td>
      <td align="center"><?= number_format($vat_amount, 2) ?></td>
      <td align="center"><?= number_format($gross_amount, 2) ?></td>
      <td align="center"><?= number_format($net_of_vat_amount, 2) ?></td>
    </tr>
  <?php } ?>

  <tr align="center">
    <td style="font-weight:bold;">TOTAL</td>
    <td style="color:rgb(55,142,55,1); font-weight:bold;"><?= number_format($net_amountf, 2) ?></td>
    <td style="color:rgb(142,8,11,1); font-weight:bold;"><?= number_format($vatf, 2) ?></td>
    <td style="color:rgb(6,61,119,1); font-weight:bold;"><?= number_format($gross_amountf, 2) ?></td>
    <td style="color:rgb(55,142,55,1); font-weight:bold;"><?= number_format($net_amountf, 2) ?></td>
  </tr>
</table>
