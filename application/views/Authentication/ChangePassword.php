<style> 
        .panel { 
            padding: 10px; 
            border: 1px solid #c0c2c4;
        } 
    </style> 

<?php $this->load->view('includes/header_script', $data); ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
<?php $this->load->view('includes/header', $data); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
<?php $this->load->view('includes/sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <br>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <!-- <div class="col-lg-2"></div> -->
            <div class="col-lg-8">
                   <?php $this->load->view('includes/msg_alert'); ?>
            </div>
        </div>

       <div class="row">
                 
                   <!-- <div class="col-lg-2"></div> -->
                    <div class="col-lg-8">

            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
                 <div class="card-body">
<form action="<?php echo base_url('change-password'); ?>" method="post" name="ChangePassword" id="ChangePassword">
                                        <div class="form-group">
                                            <label>Current Password</label>
                                            <input type="password" placeholder="Change Password" name="OldPassword" id="OldPassword" class="form-control">
                                            <?php echo form_error('OldPassword'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" placeholder="New Password" name="NewPassword" id="NewPassword" class="form-control">
                                            <?php echo form_error('NewPassword'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" placeholder="Confirm Password" name="ConfirmPassword" id="ConfirmPassword" class="form-control">
                                            <?php echo form_error('ConfirmPassword'); ?>
                                        </div>

                                        <button id="submit" class="btn btn-sm btn-primary" type="submit">Submit</button>&nbsp;
                                         <button class="btn btn-sm btn-danger" type="reset">Reset</button>
                                    </form>
                    
                                </div>
                            </div>
                            </div>
                             <div class="col-lg-1">
                   <button type="button" onclick="goBack()" class="btn btn-block btn-primary btn-sm">Back</button>

                    </div>
                    </div>
                   
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
  $('#ChangePassword').validate({
    rules: {
      OldPassword: {
        required: true,
        minlength: 6
      },
      NewPassword: {
        required: true,
        minlength: 6
      },
     ConfirmPassword : {
                    minlength : 6,
                    equalTo : "#NewPassword"
                }
    },
    messages: {
     
      OldPassword: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long"
      },
      NewPassword: {
        required: "Please provide a new password",
        minlength: "Your password must be at least 6 characters long"
      },
      ConfirmPassword: {
        required: "Please provide a confirm password",
        minlength: "Your password must be at least 6 characters long"
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
<script>
function goBack()
 {
  window.history.back();  // back history
 }
</script>


</body>
</html>
