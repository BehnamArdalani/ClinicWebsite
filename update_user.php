<?php
include './config/connection.php';
include './common_service/common_functions.php';


$showUser;


if (isset($_POST["display_name"]) && isset($_POST["username"]) && 
    isset($_POST["password"])){



      $target_dir = "user_images/";
      $file_name = time() . "_" . basename($_FILES["profile_picture"]["name"]);
      $target_file = $target_dir . $file_name;
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      // Check if image file is a actual image or fake image
      if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
          if($check !== false) {
              echo "File is an image - " . $check["mime"] . ".";
              $uploadOk = 1;
          } else {
              echo "File is not an image.";
              $uploadOk = 0;
          }
      }
          
      // Check if file already exists
      if (file_exists($target_file)) {
          echo "Sorry, file already exists.";
          $uploadOk = 0;
      }
          
      // Check file size
      if ($_FILES["profile_picture"]["size"] > 500000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
      }
          
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
          && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
      }
          
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
              echo "The file ". htmlspecialchars( basename( $_FILES["profile_picture"]["name"])). " has been uploaded.";
              $uploadOk = 1;
          } else {
              echo "Sorry, there was an error uploading your file.";
              $uploadOk = 0;
          }
      }


      


      $Where["id"] = $_POST["hidden_id"];
      $editUser = DBContext::Search("Users",$Where);

      $editUser[0]->setDisplayName($_POST["display_name"]);
      $editUser[0]->setUsername($_POST["username"]);
      $editUser[0]->setPassword($_POST["password"]);
      
      if($uploadOk == 1)
        $editUser[0]->setProfilePicture($file_name);


      $editUser[0]->save();
      
      header("Location: ./dashboard.php");


} elseif (isset($_GET["user_id"])) {

    $Where["id"] = $_GET["user_id"];
    $showUser = DBContext::Search("Users",$Where);


}



?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php include './config/site_css_links.php';?>

 <title>Update User  Details - MOntreal Clinic Management System in PHP</title>

</head>
<body class="hold-transition sidebar-mini dark-mode layout-fixed layout-navbar-fixed">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <?php include './config/header.php';
include './config/sidebar.php';?>  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Users</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="card card-outline card-primary rounded-0 shadow">
          <div class="card-header">
            <h3 class="card-title">Update User</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>

            </div>
          </div>
          <div class="card-body">
            <form method="post" enctype="multipart/form-data">
              <input type="hidden" name="hidden_id" 
               value="<?php echo $showUser[0]->getId(); ?>">
              <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                  <label>Display Name</label>
                  <input type="text" id="display_name" name="display_name" required="required"
                  class="form-control form-control-sm rounded-0" value="<?php echo $showUser[0]->getDisplayName(); ?>" />
                </div>
                <br>
                <br>
                <br>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                  <label>Username</label> 
                  <input type="text" id="username" name="username" required="required"
                  class="form-control form-control-sm rounded-0" value="<?php echo $showUser[0]->getUsername(); ?>" />
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                  <label>Password</label> 
                  <input type="password" id="password" name="password" 
                  class="form-control form-control-sm rounded-0"/>

                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                  <label>Profile picture</label>
                  <input type="file" id="profile_picture" name="profile_picture" 
                  class="form-control form-control-sm rounded-0" />

                </div>

              </div>
              
            </div>

            <div class="clearfix">&nbsp;</div>
            <div class="row">
              <div class="col-lg-11 col-md-10 col-sm-10">&nbsp;</div>
              <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                <button type="submit" id="save_user" 
                name="save_user" class="btn btn-primary btn-sm btn-flat btn-block">Update</button>
              </div>
            </div>
          </form>
        </div>
        
      </div>
      
    </section>


    <?php 
    include './config/footer.php';

    $message = '';
    if(isset($_GET['message'])) {
      $message = $_GET['message'];
    }
    ?>  

    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <?php include './config/site_js_links.php'; ?>


  <script>

    var message = '<?php echo $message;?>';

    if(message !== '') {
      showCustomMessage(message);
    }
    


  </script>
</body>
</html>