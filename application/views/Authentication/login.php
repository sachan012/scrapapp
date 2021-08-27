<?php $this->load->view('includes/header_script', $data); ?>
<body class="hold-transition login-page" style="background-image: url(<?php echo base_url("assets/star-background-1.png");?>); background-repeat: no-repeat; background-size: cover;">


<div class="login-box">
  <!-- <div class="login-logo">
   <img src="<?php echo base_url();?>maadima.png">
  </div> -->
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><strong>Sign in to access <?php echo ADMIN_COMPANY;?> Admin</strong></p>

      <!-- <form name="LoginForm" id="LoginForm" method="post" class="form-validation" onsubmit="return loginValidation()"> -->
        <form name="LoginForm" id="LoginForm" method="post" class="form-validation">
         <?php $this->load->view('includes/msg_alert'); ?>

        <div class="input-group mb-3">
          <input type="text" name="username" id="username" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          
        </div>
         <!-- <span id="username_error"></span> -->
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          
        </div>
     <!--     <span id="password_error"></span> -->
        <div class="row">

          <!-- /.col -->
          <div class="col-6">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>

          <!-- /.col -->
          <div class="col-6">
            <a href="<?php echo base_url("forget-password");?>">I forgot my password</a>
          </div>
          <!-- /.col -->

        </div>
      </form>
       

    
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<?php $this->load->view('includes/footer_scripts', $data); ?>
<!-- <script src="<?php echo assets_url('validation','formValidation.js'); ?>"></script> -->


<!-- jquery-validation -->
<script src="<?php echo assets_url('plugins','jquery-validation/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo assets_url('plugins','jquery-validation/additional-methods.min.js'); ?>"></script>


<script type="text/javascript">
$(document).ready(function () {
  
  $('#LoginForm').validate({
    rules: {
      username: {
        required: true,
        minlength: 6
      },
      password: {
        required: true,
        minlength: 6
      },
   
    },
    messages: {
     
      OldPassword: {
        required: "Please provide a username",
        minlength: "Your username must be at least 6 characters long"
      },
      NewPassword: {
        required: "Please provide a password",
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

</body>
</html>
