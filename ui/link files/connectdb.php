<?php
try
{

    // $dbusername = "u657712204_soil";  
    // $dbpassword = "Ambotlangkah777!"; 
    // $server = "localhost";
    // $dbname = "u657712204_db_soil";


    $dbusername = "root";  
    $dbpassword = ""; 
    $server = "localhost";
    $dbname = "db_soil";

    $pdo = new PDO('mysql:host=localhost;dbname='.$dbname.'',$dbusername,$dbpassword);

}

catch(PDOException $e)
{

echo $e->getMessage();

}



//echo'connection success';




?>