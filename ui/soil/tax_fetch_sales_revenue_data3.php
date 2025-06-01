<?php
include_once 'connectdb.php';
include_once 'function.php';

$columns = 
[
    0 => 's.id',
    1 => 's.date',
    2 => 's.client_id',
    3 => 's.business_id',
    4 => 's.branch_id',
    5 => 'c.name',
    6 => 'b.name',
    7 => 'br.address',
    8 => 's.gross_amount',
    9 => 's.vat',
    10 => 's.net_amount',
    11 => 's.withholding_total_cwt',
    12 => 's.withholding_total_vwt'
];



// $columns = 
// [
//     0 => 's.date',
//     1 => 's.date',
//     2 => 's.date',
//     3 => 's.date',
//     4 => 's.date',
//     5 => 's.date',
//     6 => 's.date',
//     7 => 's.date',
//     8 => 's.date',
//     9 => 's.date',
//     10 => 's.date',
//     11 => 's.date',
//     12 => 's.date'
// ];


$limit = $_GET['length'];
$start = $_GET['start'];
$orderColumn = $columns[$_GET['order'][0]['column']];
$orderDir = $_GET['order'][0]['dir'];
$searchValue = $_GET['search']['value'];

$yearnow = date('Y');

// Count total records
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tb_tax_sales");
$stmt->execute();
$totalData = $stmt->fetchColumn();
$totalFiltered = $totalData;

// Build base query
$query = "
    SELECT 
        s.*,
        c.name AS clientname,
        b.name AS businessname,
        br.address AS branchname
    FROM tb_tax_sales s
    LEFT JOIN tb_tax_client c ON s.client_id = c.id
    LEFT JOIN tb_tax_business b ON s.business_id = b.id
    LEFT JOIN tb_tax_branch br ON s.branch_id = br.id
";

// Add search filter
// if (!empty($searchValue)) 
// {
//     $query .= " WHERE 
//         s.id LIKE :search OR
//         c.name LIKE :search OR
//         b.name LIKE :search OR
//         br.address LIKE :search
//     ";
// }

if (!empty($searchValue)) 
{
    $query .= " WHERE 
    
        s.date LIKE :search OR
        s.id LIKE :search OR
        c.name LIKE :search OR
        b.name LIKE :search OR
        br.address LIKE :search
    ";
}


// Add order and limit
$query .= " ORDER BY $orderColumn $orderDir LIMIT :start, :limit";
$stmt = $pdo->prepare($query);

// Bind search value
if (!empty($searchValue)) 
{
    $stmt->bindValue(':search', "%$searchValue%", PDO::PARAM_STR);
}
$stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);

$stmt->execute();

$data = [];

while ($row = $stmt->fetch(PDO::FETCH_OBJ)) 
{
    $collectible = $row->gross_amount - $row->withholding_total_cwt - $row->withholding_total_vwt;
    $subdata = [];

    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->date.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->client_id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->business_id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->branch_id.'</font></center>';

    $subdata[] = '<center><font class="text-black" size="2">
                    <a href="tax_view_client.php?id='.$row->client_id.'" target="_blank">'.$row->clientname.'</a></font></center>';
    $subdata[] = '<center><font class="text-black" size="2">
                    <a href="tax_view_client_business.php?id='.$row->business_id.'" target="_blank">'.$row->businessname.'</a></font></center>';

    $subdata[] = '<center>
                    <font class="text-black" size="2">
                        <a href="tax_view_branch_data.php?id='.$row->branch_id.'&yearnow='.$yearnow.'" target="_blank">'.$row->branchname.'</a>
                    </font>
                  </center>';


    $subdata[] = '<center><font style="color:rgb(6, 61, 119);" size="2">'.number_format($row->gross_amount, 2).'</font></center>';
    $subdata[] = '<center><font style="color:rgb(142, 8, 11);" size="2">'.number_format($row->vat, 2).'</font></center>';
    $subdata[] = '<center><font style="color:rgb(55, 142, 55);" size="2">'.number_format($row->net_amount, 2).'</font></center>';
    $subdata[] = '<center><font style="color:rgb(177, 149, 59);" size="2">'.number_format($row->withholding_total_cwt, 2).'</font></center>';
    $subdata[] = '<center><font style="color:rgb(177, 149, 59);" size="2">'.number_format($row->withholding_total_vwt, 2).'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.number_format($collectible, 2).'</font></center>';



    $subdata[] = '<center>
        <div class="btn-group">
            <a href="tax_view_sales_revenue2.php?id='.$row->id.'" class="btn btn-primary btn-sm">
                <span class="fa fa-list" title="View"></span>
            </a>
            <a href="tax_edit_sales_revenue3.php?id='.$row->id.'" class="btn btn-success btn-sm">
                <span class="fa fa-edit" title="Edit"></span>
            </a>
            <button data-id='.$row->id.' class="btn btn-danger btn-sm" id="btn_delete_sales_revenue">
                <span class="fa fa-trash" style="color:#fff" title="Delete"></span>
            </button>
        </div>
    </center>';

    $data[] = $subdata;
}

$json_data = 
[
    "draw" => intval($_GET['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

echo json_encode($json_data);

?>
