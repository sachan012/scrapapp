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
             <a href="<?php echo base_url();?>staff/index/all"> <button type="button" class="btn btn-block btn-primary btn-xs">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back</button></a>           
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="row">
          <div class="col-md-8">
             <div class="card card-primary card-outline">
                <div class="card-header">
                <h3 class="card-title">Staff user Detail</h3>
              </div>
                <div class="card-body box-profile">
                  <?php if(isset($adminusers)){ ?>
                      <?php if(!empty($adminusers["name"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($adminusers["name"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($adminusers["email"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">EMAIL ID</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($adminusers["email"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($adminusers["phone"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">PHONE</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($adminusers["phone"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($adminusers["address"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">ADDRESS</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($adminusers["address"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($adminusers["username"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">USERNAME</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($adminusers["username"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($adminusers["roll_name"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">ROLE</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($adminusers["roll_name"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($adminusers["created_at"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">ADDED ON</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($adminusers["created_at"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($adminusers["last_login"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">LAST LOGIN DATE</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($adminusers["last_login"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($adminusers["ip_address"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">LAST LOGIN IP ADDRESS</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($adminusers["ip_address"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>                    


                       <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Status</label>
                        <?php 
                        if(!empty($adminusers["status"])) { 
                          if($adminusers["status"] == "active")
                          { ?>
                            <button type="button" class="btn btn-block btn-primary btn-xs" style="width: 100px;">Active</button>
                        <?php   } else { ?>
                            <button type="button" class="btn btn-block btn-danger btn-xs" style="width: 100px;">Inactive</button>
                        <?php  } ?>
                        <?php  } ?>
                      </div>
                      
                     
                      
                                     
                <?php }  ?>         
                </div>
                <!-- /.card-body -->
              </div>
          </div>
          <div class="col-md-4"></div>        
      </div>     
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php $this->load->view('includes/footer'); ?>

</div>
<!-- ./wrapper -->

<!-- jQuery -->

<?php $this->load->view('includes/footer_scripts'); ?>
</body>
</html>
