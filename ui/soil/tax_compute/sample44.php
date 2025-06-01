<?php
include_once '../connectdb.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

$spreadsheet = IOFactory::load('crispyking3.xlsx');
$sheet = $spreadsheet->getSheet(2);

/**
 * Get formatted date or cell value.
 * Returns null if the cell is empty or date is invalid.
 */
function check_format_cell_data($value, $cell)
{
    // Return null if cell is empty
    if ($value === null || $value === '') {
        return null;
    }

    // Convert Excel date serial to Y-m-d format if it's a date
    if (Date::isDateTime($cell)) {
        try {
            $phpDate = Date::excelToDateTimeObject($value);
            return $phpDate->format('Y-m-d');
        } catch (Exception $e) {
            // Could not convert to date; return null
            return null;
        }
    }

    // If not a date, return original value
    return $value;
}

try {
    // Read rows B8:F11, indexed by column letters
    $rows = $sheet->rangeToArray('B8:F11', null, true, false, true);

    $allValues = [];
    $params = [];
    $paramIndex = 0;

    foreach ($rows as $rowIndex => $row) {
        $dateRaw = $row['B'];
        $tin = $row['C'];
        $payment_method = $row['F'];

        $date = check_format_cell_data($dateRaw, $sheet->getCell('B' . ($rowIndex + 8)));

        // Skip rows where date is empty or invalid
        if (empty($date)) {
            echo "Row " . ($rowIndex + 8) . " skipped due to empty or invalid date.<br>";
            continue;
        }

        echo "Row " . ($rowIndex + 8) . ": Date = $date, TIN = $tin, Payment Method = $payment_method <br>";

        // Prepare named placeholders for bulk insert
        $allValues[] = "(:date$paramIndex, :tin$paramIndex, :payment$paramIndex)";
        $params[":date$paramIndex"] = $date;
        $params[":tin$paramIndex"] = $tin;
        $params[":payment$paramIndex"] = $payment_method;

        $paramIndex++;
    }

    if (count($allValues) > 0) {
        // Build and execute bulk insert query
        $sql = "INSERT INTO tb_tax_sales (date, tin, payment_method) VALUES " . implode(', ', $allValues);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        echo "Bulk insert completed successfully!";
    } else {
        echo "No valid data to insert.";
    }
} catch (Exception $e) {
    echo "Failed: " . $e->getMessage();
}
