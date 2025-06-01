<?php 
include_once 'connectdb.php';
include_once 'function.php';

$businessid = $_GET['businessid'] ?? '';

// Validate and sanitize input
if (!is_numeric($businessid)) {
    echo json_encode(["data" => []]);
    exit;
}

$yearnow = date('Y');
$data = [];

// Fetch all branch records with counts in one go using subqueries
$sql = "
    SELECT 
        b.id, b.address, b.tin,
        COALESCE(s.sales_num, 0) AS sales_num,
        COALESCE(p.purchase_num, 0) AS purchase_num
    FROM tb_tax_branch b
    LEFT JOIN 
    (
        SELECT branch_id, COUNT(*) AS sales_num
        FROM tb_tax_sales
        GROUP BY branch_id
    ) 
    s ON b.id = s.branch_id

    LEFT JOIN 
    (
        SELECT branch_id, COUNT(*) AS purchase_num
        FROM tb_tax_purchase
        GROUP BY branch_id
    ) 
    p ON b.id = p.branch_id

    WHERE b.business_id = :businessid
";

$select = $pdo->prepare($sql);
$select->bindParam(':businessid', $businessid, PDO::PARAM_INT);
$select->execute();

while ($row = $select->fetch(PDO::FETCH_OBJ)) {
    $subdata = [];

    $subdata[] = '<center>' . htmlspecialchars($row->id) . '</center>';
    $subdata[] = '<left>
                    <a href="tax_view_branch_data.php?id=' . $row->id . '&yearnow=' . $yearnow . '">' . 
                        htmlspecialchars($row->address) . 
                    '</a>
                  </left>';
    $subdata[] = '<center>' . htmlspecialchars($row->tin) . '</center>';
    $subdata[] = '<center>' . $row->sales_num . '</center>';
    $subdata[] = '<center>' . $row->purchase_num . '</center>';

    $subdata[] = '
        <center>
            <div class="btn-group">
                <a href="tax_view_branch_data.php?id=' . $row->id . '&yearnow=' . $yearnow . '" class="btn btn-primary btn-sm">
                    <span class="fa fa-eye" title="View"></span>
                </a>
                <a href="tax_edit_branch.php?id=' . $row->id . '" class="btn btn-success btn-sm">
                    <span class="fa fa-edit" title="Edit"></span>
                </a>
            </div>
        </center>';

    $data[] = $subdata;
}

echo json_encode(["data" => $data]);

?>
