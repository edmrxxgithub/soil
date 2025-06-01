<?php 
include_once 'connectdb.php';
include_once 'function.php';

$data = array();

$yearnow = date('Y');

// Fetch all data using JOINs
$select = $pdo->prepare("
    SELECT 
        s.*,
        c.name AS clientname,
        b.name AS businessname,
        br.address AS branchname
    FROM tb_tax_sales s
    LEFT JOIN tb_tax_client c ON s.client_id = c.id
    LEFT JOIN tb_tax_business b ON s.business_id = b.id
    LEFT JOIN tb_tax_branch br ON s.branch_id = br.id
");
$select->execute();

while ($row = $select->fetch(PDO::FETCH_OBJ)) 
{
    // $collectible = $row->gross_amount - $row->withholding_total_cwt - $row->withholding_total_vwt;

    $subdata = [];

    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';

    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';

    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';

    // $subdata[] = '<center><font class="text-black" size="2">'.$row->id.'</font></center>';
    // $subdata[] = '<center><font class="text-black" size="2">'.$row->date.'</font></center>';
    // $subdata[] = '<center><font class="text-black" size="2">'.$row->client_id.'</font></center>';
    // $subdata[] = '<center><font class="text-black" size="2">'.$row->business_id.'</font></center>';
    // $subdata[] = '<center><font class="text-black" size="2">'.$row->branch_id.'</font></center>';

    // $subdata[] = '<center>
    //                 <font class="text-black" size="2">
    //                     <a href="tax_view_client.php?id='.$row->client_id.'" target="_blank">'.$row->clientname.'</a>
    //                 </font>
    //              </center>';

    // $subdata[] = '<center>
    //                 <font class="text-black" size="2">
    //                     <a href="tax_view_client_business.php?id='.$row->business_id.'" target="_blank">'.$row->businessname.'</a>
    //                 </font>
    //              </center>';

    // $subdata[] = '<center>
    //                 <font class="text-black" size="2">
    //                     <a href="tax_view_branch_data.php?id='.$row->branch_id.'&yearnow='.$yearnow.'" target="_blank">'.$row->branchname.'</a>
    //                 </font>
    //              </center>';

    // $subdata[] = '<center><font style="color:rgb(6, 61, 119);" size="2">'.number_format($row->gross_amount,2).'</font></center>';
    // $subdata[] = '<center><font style="color:rgb(142, 8, 11);" size="2">'.number_format($row->vat,2).'</font></center>';
    // $subdata[] = '<center><font style="color:rgb(55, 142, 55);" size="2">'.number_format($row->net_amount,2).'</font></center>';
    // $subdata[] = '<center><font style="color:rgb(177, 149, 59);" size="2">'.number_format($row->withholding_total_cwt,2).'</font></center>';
    // $subdata[] = '<center><font style="color:rgb(177, 149, 59);" size="2">'.number_format($row->withholding_total_vwt,2).'</font></center>';
    // $subdata[] = '<center><font class="text-black" size="2">'.number_format($collectible,2).'</font></center>';

    // $subdata[] = '
    //     <center>
    //         <div class="btn-group">
    //             <a href="tax_view_sales_revenue2.php?id='.$row->id.'" class="btn btn-primary btn-sm">
    //                 <span class="fa fa-list" data-toggle="tooltip" title="View"></span>
    //             </a>
    //             <a href="tax_edit_sales_revenue3.php?id='.$row->id.'" class="btn btn-success btn-sm">
    //                 <span class="fa fa-edit" data-toggle="tooltip" title="Edit"></span>
    //             </a>
    //             <button data-id='.$row->id.' class="btn btn-danger btn-sm" id="btn_delete_sales_revenue">
    //                 <span class="fa fa-trash" style="color:#ffffff" data-toggle="tooltip" title="Delete"></span>
    //             </button>
    //         </div>
    //     </center>';

    $data[] = $subdata;
}

$return_arr = array("data" => $data);
echo json_encode($return_arr);
?>
