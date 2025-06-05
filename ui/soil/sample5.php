<?php
include_once 'connectdb.php';
include_once 'function.php';
session_start();

// echo 'God is good, life is good!';

$username = 'clinkz17';
$password = 'dotaislife999';
$name = 'dinjz';
$tablename = 'tb_user';

// $insertdata = 
// [
//     'username' => $username,
//     'password' => $password,
//     'name' => $name
// ];

// insert($pdo, $tablename, $insertdata);
// function insert($pdo, $tablename, $data)
// {
//     $columns = implode(", ", array_keys($data));
//     $placeholders = ":" . implode(", :", array_keys($data));

//     $sql = "INSERT INTO $tablename ($columns) VALUES ($placeholders)";
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute($data);
// }



$updatedata = 
[
    'username' => $username,
    'password' => $password,
    'name' => $name
];



update($pdo, $tablename, $updatedata,1);
function update($pdo, $tablename, $data, $id)
{

   // $columns = implode(", ", array_keys($data));
   // $placeholders = ":" . implode(", :", array_keys($data));
   // $sql = "INSERT INTO $tablename ($columns) VALUES ($placeholders)";
   // $sql = "UPDATE  $tablename SET ($columns) VALUES ($placeholders) WHERE id = '$id' ";
   // $stmt = $pdo->prepare($sql);
   // $stmt->execute($data);

$set = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));

$sql = "UPDATE $tablename SET $set WHERE id = :id";
// Add the id to the data array for binding
$data['id'] = $id;

// Now you can prepare and execute the statement with PDO
$stmt = $pdo->prepare($sql);
$stmt->execute($data);


}





echo 'update data success!';

?>
