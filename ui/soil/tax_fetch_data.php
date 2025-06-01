<?php
include_once 'connectdb.php';
include_once 'function.php';


$id = $_POST['id'];


$businessdata ='';

$businessdata .='<option value="">Select business</option>';

$select=$pdo->prepare("SELECT * FROM tb_tax_business WHERE client_id = '$id' order by id asc");
$select->execute();
$result=$select->fetchAll();
foreach($result as $row)
{
	$businessdata .=' <option value="'.$row["id"].'">'.$row["name"].'</option>';
}



$branchdata='';

$branchdata .= '<option value="">Select branch</option>';

$select1 = $pdo->prepare("SELECT * FROM tb_tax_branch WHERE business_id = '$id' order by id asc");
$select1 -> execute();
$result1 = $select1->fetchAll();
foreach($result1 as $row1)
{
	$branchdata .=' <option value="'.$row1["id"].'">'.$row1["address"].'</option>';
}


$select2 = $pdo->prepare("SELECT * FROM tb_tax_business WHERE id = '$id' ");
$select2 -> execute();
$row2 = $select2->fetch(PDO::FETCH_OBJ);


$supplierdata='';

$supplierdata .= '<option value="">Select supplier</option>';

$select1 = $pdo->prepare("SELECT * FROM tb_tax_supplier order by id asc");
$select1 -> execute();
$result1 = $select1->fetchAll();
foreach($result1 as $row1)
{
	$supplierdata .=' <option value="'.$row1["id"].'">'.$row1["name"].'</option>';
}


$output['businessid'] = $businessdata;
$output['branchid'] = $branchdata;
$output['supplierid'] = $supplierdata;
$output['tin'] = $row2->tin;

echo json_encode($output);

?>