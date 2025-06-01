<?php 
include_once '../connectdb.php';
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

function check_format_cell_data($cell,$sheet)
{
    $cellValue = $sheet->getCell($cell)->getValue();

    if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($sheet->getCell($cell))) {
        $phpDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cellValue);
        return $phpDate->format('Y-m-d');
    } else {
        return $cellValue;
    }
}


$branchid = $_POST['branchid'];
$clientid = $_POST['clientid'];
$businessid = $_POST['businessid'];
$userid = $_SESSION['userid'];
$timestamp = date("Y-m-d H:i:s");

$filename = $_FILES['file']['name'];
move_uploaded_file($_FILES['file']['tmp_name'], '../upload_excel/' .$filename);
$path = "../upload_excel/$filename";
$spreadsheet = IOFactory::load($path);
$sheet = $spreadsheet->getSheet(2); 


// $cellValue = $sheet->getCell('G9')->getValue();



for ($i=8; $i <= 11; $i++) 
{ 

	$cellB = 'B'.$i;
	$cellE = 'E'.$i;
	$cellH = 'H'.$i;


	$date = check_format_cell_data($cellB,$sheet);
	$or_no = check_format_cell_data($cellE,$sheet);
	$gross_amount = check_format_cell_data($cellH,$sheet);
	$net_amount = $gross_amount / 1.12;
	$vat = $gross - $net_amount;


	$insert = $pdo->prepare("
	INSERT INTO tb_tax_sales 
	SET 
	client_id = '$clientid'	,
	business_id = '$businessid'	,
	branch_id = '$branchid'	,
	customer_id	 = '38',
	date = '$date'	,
	tin = 'NP'	,
	order_status = 'Completed'	,
	payment_method = 'Cash'	,
	description = 'Various Customer Sales'	,
	invoice_no = '$or_no'	,
	gross_amount = '$gross_amount'	,
	net_amount = '$net_amount'	,
	vat = '$vat'	,
	vat_percent = '1.12'	,
	input_by_user = '$userid'	,
	created_at = '$timestamp'

	");
	
	$insert->execute();






	echo $date.' '.$or_no.' '.$gross_amount;


	

}










?>

















