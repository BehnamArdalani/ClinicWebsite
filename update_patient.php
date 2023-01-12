<?php
include './config/connection.php';
include './common_service/common_functions.php';

// TO DO 


$showPatient;

if (isset($_POST["patient_name"]) && isset($_POST["address"]) && isset($_POST["cnic"]) && 
isset($_POST["date_of_birth"]) && isset($_POST["phone_number"]) && isset($_POST["gender"])){


            $Where["id"] = $_POST["hidden_id"];
            $editPatient = DBContext::Search("Patients",$Where);

            $editPatient[0]->setPatientName($_POST["patient_name"]);
            $editPatient[0]->setAddress($_POST["address"]);
            $editPatient[0]->setCnic($_POST["cnic"]);
            $editPatient[0]->setDateOfBirth($_POST["date_of_birth"]);
            $editPatient[0]->setPhoneNumber($_POST["phone_number"]);
            $editPatient[0]->setGender($_POST["gender"]);

            $editPatient[0]->save();
            
            header("Location: ./dashboard.php");


} elseif (isset($_GET["id"])) {

    $Where["id"] = $_GET["id"];
    $showPatient = DBContext::Search("Patients",$Where);


}



?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php include './config/site_css_links.php';?>

 <?php include './config/data_tables_css.php';?>

  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <title>Update Pateint Details - Montreal Clinic Management System in PHP</title>

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
            <h1>Patients</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
     <div class="card card-outline card-primary rounded-0 shadow">
        <div class="card-header">
          <h3 class="card-title">Update Patients</h3>
          
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            
          </div>
        </div>
        <div class="card-body">
          <form method="post">
            <input type="hidden" name="hidden_id" 
            value="<?php echo $showPatient[0]->getId(); ?>">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
              <label>Patient Name</label>
              <input type="text" id="patient_name" name="patient_name" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $showPatient[0]->getPatientName(); ?>" />
              </div>
              <br>
              <br>
              <br>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Address</label> 
                <input type="text" id="address" name="address" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $showPatient[0]->getAddress(); ?>" />
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>CNIC</label>
                <input type="text" id="cnic" name="cnic" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $showPatient[0]->getCnic(); ?>" />
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <div class="form-group">
                  <label>Date of Birth</label>
                    <div class="input-group date" 
                    id="date_of_birth" 
                    data-target-input="nearest">
                        <input type="text" class="form-control form-control-sm rounded-0 datetimepicker-input" data-target="#date_of_birth" name="date_of_birth" 
                        value="<?php $arrayDate = explode('-',$showPatient[0]->getDateOfBirth()); $stringDate = $arrayDate[1]."/".$arrayDate[2]."/".$arrayDate[0]; echo $stringDate; ?>" />
                        <div class="input-group-append" 
                        data-target="#date_of_birth" 
                        data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
              
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
                <label>Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" required="required"
                class="form-control form-control-sm rounded-0" value="<?php echo $showPatient[0]->getPhoneNumber(); ?>" />
              </div>
              <div class="col-lg-4 col-md-4 col-sm-4 col-xs-10">
              <label>Gender</label>
                <!-- $gender -->

                <select class="form-control form-control-sm rounded-0" id="gender" 
                name="gender">
                 <?php echo getGender($showPatient[0]->getGender()); ?>
                </select>
                
              </div>
              </div>
              
              <div class="clearfix">&nbsp;</div>
              <div class="row">
                <div class="col-lg-11 col-md-10 col-sm-10">&nbsp;</div>
              <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
                <button type="submit" id="save_Patient" 
                name="save_Patient" class="btn btn-primary btn-sm btn-flat btn-block">Save</button>
              </div>
            </div>
          </form>
        </div>
        
      </div>
      
    </section>
     <br/>
     <br/>
     <br/>

 
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


<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<script>
  showMenuSelected("#mnu_patients", "#mi_patients");

  var message = '<?php echo $message;?>';

  if(message !== '') {
    showCustomMessage(message);
  }
  $('#date_of_birth').datetimepicker({
        format: 'L'
    });
      
    
   $(function () {
    $("#all_patients").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#all_patients_wrapper .col-md-6:eq(0)');
    
  });

</script>
</body>
</html>