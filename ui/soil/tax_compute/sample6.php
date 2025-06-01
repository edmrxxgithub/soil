<?php
include_once '../connectdb.php';
require '../vendor/autoload.php';






// if (Date::isDateTime($sheet->getCell('G9'))) 
// {
//     $phpDate = Date::excelToDateTimeObject($cellValue);
//     echo "Date: " . $phpDate->format('Y-m-d'); // or any other format like 'd/m/Y'
// } else 
// {
//     echo "Value: " . $cellValue;
// }

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

$spreadsheet = IOFactory::load('crispyking3.xlsx');
$sheet = $spreadsheet->getSheet(2);




for ($i=8; $i <= 11; $i++) 
{ 

	// echo $cellB = 'B'.$i;
	// $cellC = 'C'.$i;
	// $cellF = 'F'.$i;
	// echo $cellValueB = check_format($cellB);


	// $cellValueB = $sheet->getCell($cellB)->getValue();
	// $cellValueC = $sheet->getCell($cellC)->getValue();
	// $cellValueF = $sheet->getCell($cellF)->getValue();

	// echo $cellValueB.' '.$cellValueC.' '.$cellValueF;
	// echo '<br>';


	// $insert = $pdo->prepare("INSERT INTO tb_tax_sales SET date = '$cellValueB',tin = '$cellValueC', payment_method = '$cellValueF' ");
	// $insert->execute();

	// $insert = $pdo->prepare("INSERT INTO tb_tax_sales SET date = '$cellValueB' ");
	// $insert->execute();

	$cellB = 'B'.$i;

	echo $cellValueB = check_format_cell_data($cellB);
	echo '<br>';

	// $cellValue = $sheet->getCell($cellB)->getValue();

	// if (Date::isDateTime($sheet->getCell($cellB))) 
	// {
	//     $phpDate = Date::excelToDateTimeObject($cellValue);
	//    echo  $phpDate->format('Y-m-d'); 
	//    echo '<br>';
	// } else 
	// {
	//     echo $cellValue;
	//     echo '<br>';
	// }

	

}

// $cellValue = $sheet->getCell('B9')->getValue();


// if (Date::isDateTime($sheet->getCell('B9'))) 
// {
//     $phpDate = Date::excelToDateTimeObject($cellValue);
//     echo "Date: " . $phpDate->format('Y-m-d'); // or any other format like 'd/m/Y'
// } else 
// {
//     echo "Value: " . $cellValue;
// }

// echo '<br><br>';

// echo 'Upload success!';

//tb_tax_sales
// date
// tin
// payment_method


function check_format_cell_data($cell, $sheet)
{
    $cellValue = $sheet->getCell($cell)->getValue();

    if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($sheet->getCell($cell))) {
        $phpDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cellValue);
        return $phpDate->format('Y-m-d');
    } else {
        return $cellValue;
    }
}

// Usage
echo check_format_cell_data($cellB, $sheet);


?>