<?php 
include_once 'connectdb.php';

// $yearnow = $_GET['yearnow'];
// $branchid = $_GET['branchid'];

$yearnow = 2025;
$branchid = 10;

$q1_data = fetch_quarter1_vatable_sales($pdo,$yearnow,$branchid);


function fetch_month_data($pdo,$yearnow,$monthnum,$branchid)
{
  $days_in_a_month = date("t", strtotime("$yearnow-$monthnum-01"));
  $date_from = $yearnow.'-'.$monthnum.'-01';
  $date_to = $yearnow.'-'.$monthnum.'-'.$days_in_a_month;

  $select = $pdo->prepare("

    SELECT 

    SUM(gross_amount) as total_gross_amount ,
    SUM(net_amount) as total_net_amount ,
    SUM(vat) as total_vat_amount 

    FROM tb_tax_sales 

    WHERE 

    date between '$date_from' and '$date_to' and branch_id = '$branchid' ");

  $select->execute();
  $row = $select->fetch(PDO::FETCH_OBJ);

  



  $select1 = $pdo->prepare("

    SELECT 

    SUM(gross_amount) as total_gross_amount ,
    SUM(net_amount) as total_net_amount ,
    SUM(vat) as total_vat_amount 

    FROM tb_tax_purchase 

    WHERE 

    date between '$date_from' and '$date_to' and branch_id = '$branchid' ");

  $select1->execute();
  $row1 = $select1->fetch(PDO::FETCH_OBJ);


  $array['total_net_amount'] =   $row->total_net_amount;
  $array['purchase_net_amount'] =   $row1->total_net_amount;
  

  return $array;
  
}




function fetch_quarter1_vatable_sales($pdo,$yearnow,$branchid)
{

  $total_vatable_sales = 0;
  $total_vatable_purchase_declaration = 0;
  
  for ($monthnum = 1; $monthnum <= 3 ; $monthnum++) 
        { 

            $data_rr = fetch_month_data($pdo,$yearnow,$monthnum,$branchid);
            $total_vatable_sales += $data_rr['total_net_amount'];
            $total_vatable_purchase_declaration += $data_rr['purchase_net_amount'];
        }


  $array['total_vatable_sales'] = $total_vatable_sales;
  $array['total_vatable_purchase_declaration'] = $total_vatable_purchase_declaration;

  return $array;

}



for ($monthnum = 1; $monthnum <= 3 ; $monthnum++) 
        { 

            $data_rr = fetch_month_data($pdo,$yearnow,$monthnum,$branchid);
            echo $data_rr['purchase_net_amount'].'<br>';
        }


// echo number_format($q1_data['total_vatable_sales'],2).' '.number_format($q1_data['total_vatable_purchase_declaration'],2);






?>






























































