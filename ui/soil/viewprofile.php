<?php
include_once 'connectdb.php';
include_once 'function.php';
session_start();


if($_SESSION['userid']=="" )
{

header('location:../../index.php');

}
else
{
  $id = $_SESSION['userid'];
}


include_once "header.php";


$select = $pdo->prepare("SELECT * from tb_user where id = $id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);

$userlevel_name = user_level($pdo,$row->user_level_id);


?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Admin Dashboard</h1> -->
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Starter Page</li> -->
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
        

        <div class="card card-grey card-outline">
            <div class="card-header" style="background-color:rgba(50,63,81,255);">
              <h5 class="m-0 text-white">View Profile</h5>
            </div>
            <div class="card-body">

<div class="row">

<!-- <div class="col-md-6">
  <ul class="list-group">
      
  </ul>
</div> -->

<div class="col-md-6">

<ul class="list-group">

  <li class="list-group-item"><b>Full name : </b>&emsp;<?= $row->name ?></li>
  <li class="list-group-item"><b>Address : </b>&emsp;<?= $row->address ?></li>
  <li class="list-group-item"><b>Contact No : </b>&emsp;<?= $row->contact_num ?></li>
  <li class="list-group-item"><b>User level : </b>&emsp;<?= ucfirst($userlevel_name) ?></li>
</ul>
</div>


</div>


<div class="card-footer">
    <div class="text-center">      
      <a href="editprofile.php?id=<?= $id ?>" class="btn btn-md btn-primary">Edit Profile</a>
    </div>
</div>
             






             
            </div>
          </div>
     

       
        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->


  
</div>
<!-- /.content-wrapper -->


<?php

include_once "footer.php";

?>