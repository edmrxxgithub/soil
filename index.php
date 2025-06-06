<?php
include_once "ui/soil/connectdb.php";
session_start();

if (isset($_POST['btn_login'])) 
{


  $username = $_POST['txt_username'];
  $password = $_POST['txt_password'];

  // echo $username.' '.$password;

  $select = $pdo->prepare("SELECT * FROM tb_user where username='$username' AND password='$password'");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

 


  if (is_array($row)) 
  {

   
    // if ($row['username'] == $username and $row['password'] == $password and $row['user_level_id'] == "1") 
    if ($row['username'] == $username and $row['password'] == $password ) 
    {

        if ($row['status'] == '0') 
        {
            $_SESSION['status']="User is deactivated!";
            $_SESSION['status_code']="error";
        }
        else
        {

          $_SESSION['status']="Login Success By Admin";
          $_SESSION['status_code']="success";
          $_SESSION['userid']=$row['id'];
          $_SESSION['name'] = $row['name'];
          $_SESSION['user_level_id'] = $row['user_level_id'];
          // header('refresh: 1;ui/dashboard.php');
          // header('refresh: 1;ui/soil/dashboard.php');
          header('refresh: 1;ui/soil/tax_view_client.php?id=1');
          
          
        }

      


    }

  }


  else 
  {

    

    $_SESSION['status']="Wrong Email or Password";
    $_SESSION['status_code']="error";

  }


}



?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login menu</title>

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->

 <!-- SweetAlert2 -->
 <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

<link rel="stylesheet" href="dist/css/adminlte.min.css">


</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-white">
      <div class="card-header text-center">
        <!-- <a href="../../index2.html" class="h1"><b>SOIL</b></a> -->
        <!-- <a href="#" class="h1"><b>SOIL</b></a> -->
        <a href="#" class="h1"><b>ENTITY</b></a>
      </div>
      <div class="card-body">
        <!-- <p class="login-box-msg">Sign in to start your session</p> -->

        <form action="" method="post">
          <div class="input-group mb-3">

            <input type="text" class="form-control" placeholder="Username" name="txt_username" value="admin" required autocomplete="off">


            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">

            <input type="password" class="form-control" placeholder="Password" name="txt_password" value="soil123" required autocomplete="off">


            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn  btn-block" style="background-color:rgba(50,63,81,255)" name="btn_login"><font class="text-white">Login</button>
            </div>
            <!-- /.col -->
          </div>
        </form>


        <!-- /.social-auth-links -->

        <p class="mb-1">

        </p>
        <p class="mb-0">

        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->


 
</body>


</html>
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert2 -->
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
 
  <script src="dist/js/adminlte.min.js"></script>





  <?php
  if(isset($_SESSION['status']) && $_SESSION['status']!='')
 
  {

?>
<script>

$(function() {
    var Toast = Swal.mixin({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 5000
    });

  
      Toast.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      })
    });



</script>


<?php
unset($_SESSION['status']);
  }
  ?>









     






   

   