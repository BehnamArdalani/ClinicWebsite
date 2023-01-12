<?php 
include './config/connection.php';

if (isset($_POST["display_name"]) && isset($_POST["user_name"]) && 
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




    $newUser = Users::create($_POST["display_name"], $_POST["user_name"], MD5($_POST["password"]), $uploadOk == 1 ? $file_name : "nophoto.jpg");
    $newUser->save();

} 


?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php include './config/site_css_links.php';?>

 
 <?php include './config/data_tables_css.php';?>
 <title>Users - Montreal Clinic Management System in PHP</title>

 <style>
  .user-img{
    width:3em;
    width:3em;
    object-fit:cover;
    object-position:center center;
  }
 </style>
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
            <h3 class="card-title">Add User</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <form method="post" enctype="multipart/form-data">
             <div class="row">

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Display Name</label>
                <input type="text" id="display_name" name="display_name" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Username</label>
                <input type="text" id="user_name" name="user_name" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Password</label>
                <input type="password" id="password" 
                name="password" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>

              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Picture</label>
                <input type="file" id="profile_picture" 
                name="profile_picture" required="required"
                class="form-control form-control-sm rounded-0" />
              </div>

              <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                <label>&nbsp;</label>
                <button type="submit" id="save_medicine" 
                name="save_user" class="btn btn-primary btn-sm btn-flat btn-block">Save</button>
              </div>
            </div>
          </form>
        </div>

      </div>
      <!-- /.card -->
    </section>
    <section class="content">
      <!-- Default box -->
      
      <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
          <h3 class="card-title">All Users</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            
          </div>
        </div>
        <div class="card-body">
         <div class="row table-responsive">

          <table id="all_users" 
          class="table table-striped dataTable table-bordered dtr-inline" 
          role="grid" aria-describedby="all_users_info">
          <colgroup>
            <col width="5%">
            <col width="10%">
            <col width="50%">
            <col width="25%">
            <col width="10%">
          </colgroup>
          <thead>
            <tr>
             <th class="p-1 text-center">S.No</th>
             <th class="p-1 text-center">Picture</th>
             <th class="p-1 text-center">Display Name</th>
             <th class="p-1 text-center">Username</th>
             <th class="p-1 text-center">Action</th>
           </tr>
         </thead>

         <tbody>
          <?php 

          $allUsers = DBContext::Search("Users");

          $serial = 0;
          foreach($allUsers as $user) {
           $serial++;
           ?>
           <tr>
             <td class="px-2 py-1 align-middle text-center"><?php echo $serial; ?></td>
             <td class="px-2 py-1 align-middle text-center">
               <img class = "img-thumbnail rounded-circle p-0 border user-img" src="user_images/<?php echo $user->getProfilePicture(); ?>">
             </td>
             
             <td class="px-2 py-1 align-middle"><?php echo $user->getDisplayName(); ?></td>
             <td class="px-2 py-1 align-middle"><?php echo $user->getUsername(); ?></td>

             <td class="px-2 py-1 align-middle text-center">
                <a href="update_user.php?user_id=<?php echo $user->getId(); ?>" class="btn btn-primary btn-sm btn-flat">
                  <i class="fa fa-edit"></i> 
                </a>
              </td>
         </tr>
       <?php } ?>
     </tbody>
   </table>
 </div>
</div>

<!-- /.card-footer-->
</div>

<!-- /.card -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
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
<?php include './config/data_tables_js.php'; ?>


<script>
  showMenuSelected("#mnu_users", "");

  var message = '<?php echo $message;?>';

  if(message !== '') {
    showCustomMessage(message);
  }

  
  $(document).ready(function() {

    $("#user_name").blur(function() {
      var userName = $(this).val().trim();
      $(this).val(userName);

      if(userName !== '') {
        $.ajax({
          url: "ajax/check_user_name.php",
          type: 'GET', 
          data: {
            'user_name': userName
          },
          cache:false,
          async:false,
          success: function (count, status, xhr) {
            if(count > 0) {
              showCustomMessage("This user name exists. Please choose another username");
              $("#save_user").attr("disabled", "disabled");

            } else {
              $("#save_user").removeAttr("disabled");
            }
          },
          error: function (jqXhr, textStatus, errorMessage) {
            showCustomMessage(errorMessage);
          }
        });
      }

    });    
  });
</script>
</body>
</html>