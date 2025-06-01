<?php
include_once 'connectdb.php';
include_once 'function.php';
session_start();


$clientid = '1';
$businessid = '1';
$branchid = '10';

// echo 'God is good, life is good!';
for ($x = 1; $x <= 12 ; $x++) 
{ 
 
            for ($i=1; $i <= 12; $i++) 
            { 

            $min = 10000;
            $max = 11000;


            $date = '2025-'.$x.'-06';
            $tin = '11-22-33-44';
            $order_status = 'completed';
            $payment_method = 'cash';
            $description = 'Various customer sales';
            $invoice_num = '123-456-789';

            $userid = $_SESSION['userid'];
            $timestamp = date("Y-m-d H:i:s");


            
            $gross_amount = random_int($min, $max);
            $vat_percent = 1.12;
            $cwt_percent = 1;
            $vwt_percent = 5;
            
$cwt_percent_new = $cwt_percent / 100;
$vwt_percent_new = $vwt_percent / 100;

if ($vat_percent == 0) 
{
    $net_of_vat_new = $gross_amount;
} 
else 
{
    $net_of_vat_new = $gross_amount / $vat_percent;
}

$total_vat_new = $gross_amount - $net_of_vat_new;
$withholding_total_cwt = $cwt_percent_new * $net_of_vat_new;
$withholding_total_vwt = $vwt_percent_new * $net_of_vat_new;


            $insert = $pdo->prepare("INSERT INTO tb_tax_sales SET 

            client_id  = '$clientid' ,
            business_id  = '$businessid' ,
            branch_id  = '$branchid' ,
            date   = '$date' ,
            tin  = '$tin' ,
            order_status   = '$order_status' ,
            payment_method   = '$payment_method' ,
            description  = '$description' ,
            invoice_no   = '$invoice_num' ,

            gross_amount  = '$gross_amount'  ,
            net_amount   = '$net_of_vat_new' ,
            vat  = '$total_vat_new' ,

            vat_percent = '$vat_percent' ,
            cwt_percent = '$cwt_percent' ,
            vwt_percent = '$vwt_percent' ,

            withholding_total_cwt = '$withholding_total_cwt' ,
            withholding_total_vwt = '$withholding_total_vwt' ,

            input_by_user  = '$userid' ,
            created_at = '$timestamp' ");


            // $insert->execute();


            }


}





for ($x = 1; $x <= 12 ; $x++) 
{ 
 
            for ($i=1; $i <= 4; $i++) 
            { 

            $min = 18000;
            $max = 21000;

           
            $date = '2025-'.$x.'-'.$i;
            $tin = '11-22-33-44';
            $order_status = 'completed';
            $payment_method = 'cash';
            $description = 'Various customer sales';
            $invoice_num = '123-456-789';

            $userid = $_SESSION['userid'];
            $timestamp = date("Y-m-d H:i:s");

            // $gross_amount = random_int($min, $max);
            // $net_amount = $gross_amount / 1.12;
            // $vat = $gross_amount - $net_amount;

            $gross_amount = random_int($min, $max);
            $vat_percent = 1.12;
            $cwt_percent = 1;
            $vwt_percent = 5;


            $cwt_percent_new = $cwt_percent / 100;
            $vwt_percent_new = $vwt_percent / 100;

            if ($vat_percent == 0) 
            {
                $net_of_vat_new = $gross_amount;
            } 
            else 
            {
                $net_of_vat_new = $gross_amount / $vat_percent;
            }


            $total_vat_new = $gross_amount - $net_of_vat_new;
            $withholding_total_cwt = $cwt_percent_new * $net_of_vat_new;
            $withholding_total_vwt = $vwt_percent_new * $net_of_vat_new;


// client_id 
// business_id 
// branch_id 
// supplier_id 

// date  
// tin 

// description 
// invoice_no  

// gross_amount  
// net_amount  
// vat 
// vat_percent 
// cwt_percent 
// vwt_percent 
// withholding_total_cwt 
// withholding_total_vwt 

// input_by_user 
// created_at  



            $insert = $pdo->prepare("INSERT INTO tb_tax_purchase SET 

            client_id  = '$clientid' ,
            business_id  = '$businessid' ,
            branch_id  = '$branchid' ,
            supplier_id = '1' ,
            date   = '$date' ,
            tin  = '$tin' ,

            description  = '$description' ,
            invoice_no   = '$invoice_num' ,

            gross_amount  = '$gross_amount'  ,
            net_amount   = '$net_of_vat_new' ,
            vat  = '$total_vat_new' ,

            vat_percent = '$vat_percent' ,
            cwt_percent = '$cwt_percent' ,
            vwt_percent = '$vwt_percent' ,
            
            withholding_total_cwt = '$withholding_total_cwt' ,
            withholding_total_vwt = '$withholding_total_vwt' ,

            input_by_user  = '$userid' ,
            created_at = '$timestamp' ");

            // $insert->execute();

            }


}










for ($x = 1; $x <= 12 ; $x++) 
{ 
 
            for ($i=1; $i <= 12; $i++) 
            { 

            $min = 500;
            $max = 4000;

            $supplierid = '1';
            $date = '2025-'.$x.'-'.$i;
            $tin = '11-22-33-44';
            $exp_classification = 'ADVERTISING AND PROMOTION';
            $exp_type = 'GOODS';
            $reference_num = '231058';


            $userid = $_SESSION['userid'];
            $timestamp = date("Y-m-d H:i:s");


$gross_amount = random_int($min, $max);
$vat_percent = 1.12;
$cwt_percent = 1;
$vwt_percent = 5;
            
$cwt_percent_new = $cwt_percent / 100;
$vwt_percent_new = $vwt_percent / 100;

if ($vat_percent == 0) 
{
    $net_of_vat_new = $gross_amount;
} 
else 
{
    $net_of_vat_new = $gross_amount / $vat_percent;
}

$total_vat_new = $gross_amount - $net_of_vat_new;
$withholding_total_cwt = $cwt_percent_new * $net_of_vat_new;
$withholding_total_vwt = $vwt_percent_new * $net_of_vat_new;


// client_id   
// business_id 
// branch_id   
// supplier_id 
// date    
// exp_class   
// exp_type    
// reference_num   
// gross_amount    
// net_amount  
// vat 
// vat_percent 
// cwt_percent 
// vwt_percent 
// withholding_total_cwt   
// withholding_total_vwt   
// created_at  
// input_by_user


            $insert = $pdo->prepare("INSERT INTO tb_tax_vat_purchase 
            SET 

            client_id = '$clientid', 
            business_id = '$businessid' , 
            branch_id = '$branchid' ,
            supplier_id =  '$supplierid' ,

            date =  '$date' ,
            exp_class =  '$exp_classification' ,
            exp_type =  '$exp_type' ,
            reference_num =  '$reference_num' ,

            gross_amount  = '$gross_amount'  ,
            net_amount   = '$net_of_vat_new' ,
            vat  = '$total_vat_new' ,

            vat_percent = '$vat_percent' ,
            cwt_percent = '$cwt_percent' ,
            vwt_percent = '$vwt_percent' ,
            
            withholding_total_cwt = '$withholding_total_cwt' ,
            withholding_total_vwt = '$withholding_total_vwt' ,


            created_at = '$timestamp' ,
            input_by_user = '$userid' ");


            // $insert->execute();


            }


}






for ($x = 1; $x <= 12 ; $x++) 
{ 
 
            for ($i=1; $i <= 7; $i++) 
            { 

            $min = 5000;
            $max = 7000;

            $date = '2025-'.$x.'-'.$i;
            $exp_classification = 'ADVERTISING AND PROMOTION';
            $exp_type = 'GOODS';
            $reference_num = '231058';
            $supplierid = '1';

            $userid = $_SESSION['userid'];
            $timestamp = date("Y-m-d H:i:s");

            $gross_amount = random_int($min, $max);
            $vat_percent = 1.12;
            $cwt_percent = 1;
            $vwt_percent = 5;

            $cwt_percent_new = $cwt_percent / 100;
            $vwt_percent_new = $vwt_percent / 100;

            $net_of_vat_new = $gross_amount;

            $total_vat_new = $gross_amount - $net_of_vat_new;
            $withholding_total_cwt = $cwt_percent_new * $net_of_vat_new;
            $withholding_total_vwt = $vwt_percent_new * $net_of_vat_new;


// client_id   
// business_id 
// branch_id   
// date    
// exp_class   
// exp_type    
// reference_num

// gross_amount    
// cwt_percent 
// vwt_percent 
// withholding_total_cwt   
// withholding_total_vwt   

// created_at  
// input_by_user  


            

            $insert = $pdo->prepare("INSERT INTO tb_tax_non_vat_purchase 
                
            SET 

            client_id = '$clientid', 
            business_id = '$businessid' , 
            branch_id = '$branchid' ,
            supplier_id = '$supplierid',
            
            date =  '$date' ,
            exp_class =  '$exp_classification' ,
            exp_type =  '$exp_type' ,
            reference_num =  '$reference_num' ,

            gross_amount = '$gross_amount' ,    
            cwt_percent = '$cwt_percent' , 
            vwt_percent = '$vwt_percent' , 
            withholding_total_cwt = '$withholding_total_cwt' ,   
            withholding_total_vwt = '$withholding_total_vwt' ,   

            created_at = '$timestamp' ,
            input_by_user = '$userid' ");


            // $insert->execute();


            }


}






echo 'data insert success, God is good!, Life is good!';

?>






