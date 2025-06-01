<?php
include_once '../connectdb.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

session_start(); // Ensure session is started for $_SESSION usage

function check_format_cell_data(string $cell, \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
{
    $cellObj = $sheet->getCell($cell);
    $cellValue = $cellObj->getValue();

    if (Date::isDateTime($cellObj)) {
        $phpDate = Date::excelToDateTimeObject($cellValue);
        return $phpDate->format('Y-m-d');
    } else {
        return $cellValue;
    }
}

if (!isset($_POST['branchid'], $_POST['clientid'], $_POST['businessid'], $_FILES['file']) || !isset($_SESSION['userid'])) {
    die('Missing required parameters.');
}

$branchid = $_POST['branchid'];
$clientid = $_POST['clientid'];
$businessid = $_POST['businessid'];
$userid = $_SESSION['userid'];
$timestamp = date("Y-m-d H:i:s");

// File upload handling
$uploadDir = '../upload_excel/';
$filename = basename($_FILES['file']['name']);
$uploadFile = $uploadDir . $filename;

if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
    die('Failed to upload file.');
}

// Load spreadsheet
try {
    $spreadsheet = IOFactory::load($uploadFile);
} catch (Exception $e) {
    die('Error loading file: ' . $e->getMessage());
}

// Prepare insert statement once
$sql = "INSERT INTO tb_tax_sales 
        (client_id, business_id, branch_id, customer_id, date, tin, order_status, payment_method, description, invoice_no, gross_amount, net_amount, vat, vat_percent, input_by_user, created_at)
        VALUES
        (:client_id, :business_id, :branch_id, :customer_id, :date, :tin, :order_status, :payment_method, :description, :invoice_no, :gross_amount, :net_amount, :vat, :vat_percent, :input_by_user, :created_at)";

$insert = $pdo->prepare($sql);

try {
    $pdo->beginTransaction();

    // Loop through sheets 2 to 13 (inclusive)
    for ($sheetIndex = 2; $sheetIndex <= 13; $sheetIndex++) {
        if ($sheetIndex >= $spreadsheet->getSheetCount()) {
            // Skip if sheet index is out of bounds
            continue;
        }
        
        $sheet = $spreadsheet->getSheet($sheetIndex);
        
        // You can optionally get the sheet name for debugging/logging
        $sheetName = $sheet->getTitle();

        // Loop through rows, adjust as needed per your data layout
        for ($i = 8; $i <= 40; $i++) {
            $date = check_format_cell_data('B' . $i, $sheet);

            // Skip insert if date is empty or null
            if (empty($date)) {
                continue; // skip to next iteration
            }

            $or_no = check_format_cell_data('E' . $i, $sheet);
            $gross_amount = (float) check_format_cell_data('H' . $i, $sheet);

            $net_amount = $gross_amount / 1.12;
            $vat = $gross_amount - $net_amount;

            $insert->execute([
                ':client_id' => $clientid,
                ':business_id' => $businessid,
                ':branch_id' => $branchid,
                ':customer_id' => 38,
                ':date' => $date,
                ':tin' => 'NP',
                ':order_status' => 'Completed',
                ':payment_method' => 'Cash',
                ':description' => 'Various Customer Sales',
                ':invoice_no' => $or_no,
                ':gross_amount' => $gross_amount,
                ':net_amount' => $net_amount,
                ':vat' => $vat,
                ':vat_percent' => 1.12,
                ':input_by_user' => $userid,
                ':created_at' => $timestamp,
            ]);

            echo htmlspecialchars("Sheet: $sheetName - $date $or_no $gross_amount") . "<br>";
        }
    }

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    die('Database error: ' . $e->getMessage());
}
?>
