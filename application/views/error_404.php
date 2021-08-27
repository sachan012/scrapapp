<?php $this->load->view('includes/header_script', $data); ?>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 <?php $this->load->view('includes/header', $data); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  
    <?php $this->load->view('includes/sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-11">
            <!-- <h1>Blank Page</h1> -->
          </div>
          <div class="col-sm-1">
          
       <button type="button" onclick="goBack()" class="btn btn-block btn-primary btn-xs">Back</button>
            
          </div>

        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
       <!--  <div class="card-header">
          <h3 class="card-title">Admin User Details</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div> -->
        <div class="card-body">
         

 <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="<?php echo base_url();?>dashboard">return to dashboard</a> or try using the search form.
          </p>

        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->



        </div>
        <!-- /.card-body -->
       <!--  <div class="card-footer">
          Footer
        </div> -->
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php $this->load->view('includes/footer'); ?>

</div>
<!-- ./wrapper -->

<!-- jQuery -->

<?php $this->load->view('includes/footer_scripts'); ?>
<script>
function goBack()
 {
  window.history.back();  // back history
 }
</script>
</body>
</html>

