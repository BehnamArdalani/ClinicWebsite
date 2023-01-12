<?php 
	include_once './config/connection.php';

// TO DO

if (isset($_POST["user_name"]) && isset($_POST["password"])){
    
  $user_name = $_POST["user_name"];
  $password = $_POST["password"];

  $Where["user_name"] = $user_name;
  $Where["password"] = MD5($password);

  $loggedInUser = DBContext::Search("Users", $Where);
  


  if ($loggedInUser[0]) {
      $_SESSION["user_id"] = $loggedInUser[0]->getId();
      $_SESSION["user_name"] = $loggedInUser[0]->getUsername();
      $_SESSION["display_name"] = $loggedInUser[0]->getDisplayName();
      $_SESSION["profile_picture"] = $loggedInUser[0]->getProfilePicture();

      //var_dump($loggedInUser[0]);
      //die();

      header("Location: ./dashboard.php");
  }
} 



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Montreal Clinic Management System in PHP</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style>
  	
  	.login-box {
    	width: 430px;
	}
  
#system-logo {
    width: 5em !important;
    height: 5em !important;
    object-fit: cover;
    object-position: center center;
}
  </style>
</head>
<body class="hold-transition login-page dark-mode">
<div class="login-box">
  <div class="login-logo mb-4">
    <img src="dist/img/logo.jpg" class="img-thumbnail p-0 border rounded-circle" id="system-logo">
    <div class="text-center h2 mb-0">Montreal Clinic Management System - PHP</div>
  </div>
  <!-- /.login-logo -->
  <div class="card card-outline card-primary rounded-0 shadow">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Please enter your login credentials</p>
      <form method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control form-control-lg rounded-0 autofocus" 
          placeholder="Username" id="user_name" name="user_name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control form-control-lg rounded-0" 
          placeholder="Password" id="password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button name="login" type="submit" class="btn btn-primary rounded-0 btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>

        <div class="row">
          <div class="col-md-12">
            <p class="text-danger">
              <?php 
              // TO DO 
              ?>
            </p>
          </div>
        </div>
      </form>

      
    </div>

  </div>
</div>


</body>
</html>
