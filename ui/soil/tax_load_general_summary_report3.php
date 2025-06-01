<?php 
include_once 'connectdb.php';

$monthnow = $_GET['monthnow'] ?? date('n');
$yearnow = $_GET['yearnow'] ?? date('Y');
$branchid = $_GET['branchid'] ?? 0;

$totals = [
  'vatable_sales' => 0,
  'government_sales' => 0,
  'zero_rated_sales' => 0,
  'exempt_sales' => 0,
  'vatable_purchase' => 0,
  'vatable_expense' => 0,
  'non_vatable_expense' => 0,
  'net_income' => 0,
  'sawt_it' => 0,
  'sawt_vt' => 0,
  'qap_it' => 0,
  'qap_vt' => 0
];

function fetch_month_data($pdo, $year, $month, $branchId) 
{
  $startDate = "$year-$month-01";
  $endDate = date("Y-m-t", strtotime($startDate));

  $params = [
    ':branchid' => $branchId,
    ':from' => $startDate,
    ':to' => $endDate
  ];

  $queries = [
    'sales' => "SELECT 
                  SUM(net_amount) AS net, 
                  SUM(withholding_total_cwt) AS cwt, 
                  SUM(withholding_total_vwt) AS vwt 
                FROM tb_tax_sales 
                WHERE date BETWEEN :from AND :to AND branch_id = :branchid",

    'vat_sales' => "SELECT SUM(net_amount) AS net FROM tb_tax_sales 
                    WHERE date BETWEEN :from AND :to AND branch_id = :branchid 
                    AND vat_percent != 0 AND vwt_percent = 0",

    'gov_sales' => "SELECT SUM(net_amount) AS net FROM tb_tax_sales 
                    WHERE date BETWEEN :from AND :to AND branch_id = :branchid 
                    AND vat_percent != 0 AND vwt_percent != 0",

    'zero_sales' => "SELECT SUM(net_amount) AS net FROM tb_tax_sales 
                     WHERE date BETWEEN :from AND :to AND branch_id = :branchid 
                     AND vat_percent = 0 AND vwt_percent != 0",

    'exempt_sales' => "SELECT SUM(net_amount) AS net FROM tb_tax_sales 
                       WHERE date BETWEEN :from AND :to AND branch_id = :branchid 
                       AND vat_percent = 0 AND vwt_percent = 0",

    'purchase' => "SELECT SUM(net_amount) AS net, SUM(withholding_total_cwt) AS cwt, SUM(withholding_total_vwt) AS vwt 
                   FROM tb_tax_purchase 
                   WHERE date BETWEEN :from AND :to AND branch_id = :branchid",

    'vat_expense' => "SELECT SUM(net_amount) AS net, SUM(withholding_total_cwt) AS cwt, SUM(withholding_total_vwt) AS vwt 
                      FROM tb_tax_vat_purchase 
                      WHERE date BETWEEN :from AND :to AND branch_id = :branchid",

    'non_vat_expense' => "SELECT SUM(gross_amount) AS gross, SUM(withholding_total_cwt) AS cwt, SUM(withholding_total_vwt) AS vwt 
                          FROM tb_tax_non_vat_purchase 
                          WHERE date BETWEEN :from AND :to AND branch_id = :branchid"
  ];

  $results = [];

  foreach ($queries as $key => $sql) 
  {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results[$key] = $stmt->fetch(PDO::FETCH_OBJ);
  }

  return 
  [
    'vatable_sales' => $results['vat_sales']->net ?? 0,
    'government_sales' => $results['gov_sales']->net ?? 0,
    'zero_rated_sales' => $results['zero_sales']->net ?? 0,
    'exempt_sales' => $results['exempt_sales']->net ?? 0,
    'vatable_purchase' => $results['purchase']->net ?? 0,
    'vatable_expense' => $results['vat_expense']->net ?? 0,
    'non_vatable_expense' => $results['non_vat_expense']->gross ?? 0,
    'qap_it' => ($results['purchase']->cwt ?? 0) + ($results['vat_expense']->cwt ?? 0) + ($results['non_vat_expense']->cwt ?? 0),
    'qap_vt' => ($results['purchase']->vwt ?? 0) + ($results['vat_expense']->vwt ?? 0) + ($results['non_vat_expense']->vwt ?? 0),
    'sawt_it' => $results['sales']->cwt ?? 0,
    'sawt_vt' => $results['sales']->vwt ?? 0
  ];
}






?>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="small-box" style="background-color:rgba(12,25,60,255);">
        <div class="inner text-white">
          <h4 class="text-center">SUMMARY REPORT FROM GENERAL PURPOSE STATEMENT YEAR <?= $yearnow ?></h4>
        </div>
      </div>
    </div>
  </div>
</div>

<table border="1" width="100%">
  <thead>
    <tr align="center" style="background-color:rgba(12,25,60,255); color:white;">
      <th>PERIOD</th>
      <th>VS</th>
      <th>GS</th>
      <th>ZS</th>
      <th>ES</th>
      <th>NET INCOME</th>
      <th>QAP-IT</th>
      <th>QAP-VT</th>
      <th>SAWT-IT</th>
      <th>SAWT-VT</th>
      <th>VAT EXPENSES</th>
      <th>NON-VAT EXPENSES</th>
    </tr>
  </thead>
  <tbody>
    <?php for ($month = 1; $month <= 12; $month++): 
      $monthName = date("F", strtotime("$yearnow-$month-01"));
      $data = fetch_month_data($pdo, $yearnow, $month, $branchid);
      $netIncome = $data['vatable_sales'] - $data['vatable_expense'] - $data['non_vatable_expense'];

      foreach ($totals as $key => $val) {
        if (isset($data[$key])) $totals[$key] += $data[$key];
      }
      $totals['net_income'] += $netIncome;
    ?>
    <tr align="center">
      <td><font size="2"><?= $monthName ?></font></td>
      <td><font size="2"><?= number_format($data['vatable_sales'], 2) ?></font></td>
      <td><font size="2"><?= number_format($data['government_sales'], 2) ?></font></td>
      <td><font size="2"><?= number_format($data['zero_rated_sales'], 2) ?></font></td>
      <td><font size="2"><?= number_format($data['exempt_sales'], 2) ?></font></td>
      <!-- <td><font size="2"><?= number_format($netIncome, 2) ?></font></td> -->
      <td><font size="2"><?= number_format(0.00, 2) ?></font></td>
      <td><font size="2"><?= number_format($data['qap_it'], 2) ?></font></td>
      <td><font size="2"><?= number_format($data['qap_vt'], 2) ?></font></td>
      <td><font size="2"><?= number_format($data['sawt_it'], 2) ?></font></td>
      <td><font size="2"><?= number_format($data['sawt_vt'], 2) ?></font></td>
      <td><font size="2"><?= number_format($data['vatable_expense'], 2) ?></font></td>
      <td><font size="2"><?= number_format($data['non_vatable_expense'], 2) ?></font></td>
    </tr>
    <?php endfor; ?>

    <!-- TOTAL ROW -->
    <tr align="center" style="font-weight:bold; background-color:#f0f0f0;">
      <td>TOTAL</td>
      <td><?= number_format($totals['vatable_sales'], 2) ?></td>
      <td><?= number_format($totals['government_sales'], 2) ?></td>
      <td><?= number_format($totals['zero_rated_sales'], 2) ?></td>
      <td><?= number_format($totals['exempt_sales'], 2) ?></td>
      <td><?= number_format($totals['net_income'], 2) ?></td>
      <td><?= number_format($totals['qap_it'], 2) ?></td>
      <td><?= number_format($totals['qap_vt'], 2) ?></td>
      <td><?= number_format($totals['sawt_it'], 2) ?></td>
      <td><?= number_format($totals['sawt_vt'], 2) ?></td>
      <td><?= number_format($totals['vatable_expense'], 2) ?></td>
      <td><?= number_format($totals['non_vatable_expense'], 2) ?></td>
    </tr>
  </tbody>
</table>
