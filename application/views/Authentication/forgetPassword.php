<?php $this->load->view('includes/header_script', $data); ?>
<body class="hold-transition login-page" style="background-image: url(<?php echo base_url("assets/star-background-1.png");?>); background-repeat: no-repeat; background-size: cover;">

<?php $this->load->view('includes/msg_alert'); ?>
<div class="login-box">
  <!-- <div class="login-logo">
   <img src="<?php echo base_url();?>maadima.png">
  </div> -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

    <form name="forgetPassword" id="forgetPassword" method="post" class="form-validation">
         <?php //$this->load->view('includes/msg_alert'); ?>
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" id="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="<?php echo base_url();?>">Login</a>
      </p>
     
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
  
  $('#forgetPassword').validate({
    rules: {
      email: {
        required: true,
        email: true
      }
    },
    messages: {
     
      email: {
        required: "Please provide a valid email id"
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
