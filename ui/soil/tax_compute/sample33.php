<?php
include_once '../connectdb.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

$spreadsheet = IOFactory::load('crispyking3.xlsx');
$sheet = $spreadsheet->getSheet(2);

// Function to get cell value and convert Excel date to Y-m-d format if needed
function check_format_cell_data($cell, $sheet)
{
    $cellValue = $sheet->getCell($cell)->getValue();

    if (Date::isDateTime($sheet->getCell($cell))) {
        $phpDate = Date::excelToDateTimeObject($cellValue);
        return $phpDate->format('Y-m-d');
    } else {
        return $cellValue;
    }
}

// Loop through rows 8 to 11
for ($i = 8; $i <= 11; $i++) {
    $cellB = 'B' . $i;
    $cellC = 'C' . $i;
    $cellF = 'F' . $i;

    $date = check_format_cell_data($cellB, $sheet);
    $tin = $sheet->getCell($cellC)->getValue();
    $payment_method = $sheet->getCell($cellF)->getValue();

    echo "Row $i: Date = $date, TIN = $tin, Payment Method = $payment_method <br>";

    // Uncomment below lines if you want to insert into DB
    
    $insert = $pdo->prepare("INSERT INTO tb_tax_sales (date, tin, payment_method) VALUES (:date, :tin, :payment_method)");
    $insert->execute([
        ':date' => $date,
        ':tin' => $tin,
        ':payment_method' => $payment_method,
    ]);
    
}

echo 'Process completed!';
?>
