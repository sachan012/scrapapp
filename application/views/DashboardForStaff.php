<?php $this->load->view('includes/header_script', $data);
$role_type = trim(getSessionUserData("role_type"));
$rolename = getAdminRoleInfo($role_type, $table = "roles");  // geting the user role
?>

<style type="text/css">
  
.small-box .icon {
    color: rgba(0,0,0,.15);
    z-index: 0;
    float: right;
    margin-top: -100px!important;
    margin-right: 10px!important;
}

</style>


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

    <!-- <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <h1 class="m-0 text-dark">Dashboard</h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php //echo base_url("dashboard");?>">Home</a></li>
              <li class="breadcrumb-item active"><?php //echo ucwords(trim(($title)));?></li>
            </ol>
          </div>
        </div>
      </div>
    </div> -->
    <br>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->

        <div class="row">
          <div class="col-lg-12 col-12">
         <?php $this->load->view('includes/msg_alert'); ?>
       </div>
        </div>

         <div class="row">

            <?php if(!empty($rolename["role_id"]) && $rolename["role_id"] == 1) { ?>
          
            <div class="col-lg-2 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $TotalStaff; ?></h3>

                <p>Staff</p>
              </div>
              <div class="icon">
               <!--  <i class="ion ion-person"></i> -->
                <img src="<?php echo base_url();?>assets/uploads/dashboard_icon/admin-users.png" class="img-responsive">
              </div>
              <a href="<?php echo base_url("staff/index/all");?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        <?php } ?>
          <!-- ./col -->
        </div>

         

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php $this->load->view('includes/footer'); ?>

</div>
<!-- ./wrapper -->

<?php $this->load->view('includes/footer_scripts'); ?>
</body>
</html>
