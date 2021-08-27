<style type="text/css">
  .has-error
  {
    color: red;
  }
</style>
<?php $this->load->view('includes/header_script', $data); ?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php $this->load->view('includes/header', $data); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
 <?php $this->load->view('includes/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


   <!--  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <h1>Profile</h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url("dashboard");?>">Home</a></li>
              <li class="breadcrumb-item active"><?php echo ucwords(trim(($title)));?></li>
            </ol>
          </div>
        </div>
      </div>
    </section> -->

    <br>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            
            <div class="col-lg-12">
                   <?php $this->load->view('includes/msg_alert'); ?>
            </div>
        </div>
        <div class="row">
          <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">

                  <?php if(!empty($aminDetails["profileicon"])) { ?>
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo UPLOAD_PATH."/AdminUser/".$aminDetails["profileicon"];?>"
                       alt="User profile picture">
                  <?php } else { ?>

                     <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo UPLOAD_PATH."/AdminUser".$aminDetails["profileicon"];?>"
                       alt="User profile picture">

                  <?php } ?>
                       
                </div>

                <h3 class="profile-username text-center"><?php echo ucwords($aminDetails["name"]);?></h3>

                <p class="text-muted text-center"><?php echo ucwords(trim($aminDetails["roll_name"]));?></p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Username</b> <a class="float-right"><?php echo ucwords(trim($aminDetails["username"]));?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Phone</b> <a class="float-right"><?php echo ucwords(trim($aminDetails["phone"]));?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right"><?php echo ucwords(trim($aminDetails["email"]));?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Status</b> <a class="float-right"><?php echo ucwords(trim($aminDetails["status"]));?></a>
                  </li>

                  <li class="list-group-item">
                    <b>Added On</b> <a class="float-right"><?php echo ucwords(trim(date("d-m-Y", strtotime($aminDetails["created_at"]))));?></a>
                  </li>

                    <li class="list-group-item">
                    <b>Address</b> <br><a class="float-left"><?php echo ucwords(trim($aminDetails["address"]));?></a>
                  </li>
                </ul>
                <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

           
          </div>
          <!-- /.col -->
          <div class="col-md-8">
            <div class="card">
            <!--   <div class="card-header p-2">
                <ul class="nav nav-pills">
                
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Update Profile</a></li>
                </ul>
              </div> --><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                  <?php //echo validation_errors(); ?>
                  <div class="tab-pane active" id="settings">
                    <form class="form-horizontal" id="profile_update" method="post" action="<?php echo base_url("profile")?>" enctype="multipart/form-data">
                      <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="name" name="name" value="<?php echo ucwords($aminDetails["name"]);?>">
                        </div>
                         <?php echo form_error('name'); ?>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="email" name="email" value="<?php echo ucwords($aminDetails["email"]);?>">
                        </div>
                        <?php echo form_error('email'); ?>
                      </div>
                      <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $aminDetails["phone"];?>">
                        </div>
                        <?php echo form_error('phone'); ?>
                      </div>
                      <div class="form-group row">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="address" name="address"><?php echo ucwords($aminDetails["address"]);?></textarea>
                        </div>

                      </div>

                        <div class="form-group row">
                        <label for="AdminImage" class="col-sm-2 col-form-label">Profile Image</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" id="AdminImage" name="AdminImage">
                        </div>
                        <?php echo form_error('AdminImage'); ?>
                      </div>


                      
                     
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-primary">Update</button>
                          &nbsp;<button class="btn btn-sm btn-danger" type="reset">Reset</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php $this->load->view('includes/footer'); ?>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<?php $this->load->view('includes/footer_scripts'); ?>


<!-- jquery-validation -->
<script src="<?php echo assets_url('plugins','jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo assets_url('plugins','jquery-validation/additional-methods.min.js'); ?>"></script>


<script type="text/javascript">
$(document).ready(function () {
  /*$.validator.setDefaults({
    submitHandler: function () {
      alert( "Form successful submitted!" );
      $("form").submit();
    }
  });*/
  $('#profile_update').validate({
    rules: {
      name: {
        required: true,
        minlength: 6
      },
      email: {
        required: true,
        email : true
      },
     phone : {
                    minlength : 10,
                    maxlength : 10,
                    number: true
            }
    },
    messages: {
     
      name: {
        required: "Please Provide a Name",
        minlength: "Your Name Must Be At Least 6 Characters Long"
      },
      email: {
        required: "Please Provide a Valid Email Id",
      },
      phone: {
        required: "Please Provide a Phone Number",
        minlength: "Your Password Must Be At Least 10 Digit Long"
      },
      
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>


</body>
</html>
