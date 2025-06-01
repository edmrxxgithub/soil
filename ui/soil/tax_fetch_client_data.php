<?php
include_once 'connectdb.php';
include_once 'function.php';

// echo 'God is good! life is good, rich mindset!';


	$output='';
    $select=$pdo->prepare("SELECT * FROM tb_tax_client order by id asc");
    $select->execute();
    $result=$select->fetchAll();

    $output .= '<option value="">Select client</option>';

    foreach($result as $row)
    {
        $output.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
    }

    echo $output; 

?>