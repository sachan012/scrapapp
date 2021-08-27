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
             <a href="<?php echo base_url();?>users/index/all"> <button type="button" class="btn btn-block btn-primary btn-xs">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back</button></a>           
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
                <h3 class="card-title">App User Detail</h3>
              </div>
                <div class="card-body box-profile">
                  <?php if(isset($customerdetails)){ ?>
                      <?php if(!empty($customerdetails["fullname"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["fullname"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["company_name"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Company Name</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["company_name"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["gst_no"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">GST No</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["gst_no"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["pan_no"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">PAN No</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["pan_no"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["email"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">EMAIL ID</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["email"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["phone"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">PHONE</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["phone"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["address"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">ADDRESS</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["address"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["username"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">USERNAME</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["username"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["roll_name"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">ROLE</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["roll_name"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["created_at"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">ADDED ON</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["created_at"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["last_login"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">LAST LOGIN DATE</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["last_login"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>

                      <?php if(!empty($customerdetails["ip_address"])) {  ?>                  
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">LAST LOGIN IP ADDRESS</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="inputName" value="<?php echo ucwords(trim($customerdetails["ip_address"]));  ?>" readonly>
                        </div>
                      </div>
                      <?php } ?>                    


                       <div class="form-group row">
                        <label for="inputName" class="col-sm-3 col-form-label">Status</label>

                       
                      

                        <?php if($customerdetails["status"] == "0"){?>
                            <button type="button" class="btn btn-warning btn-sm">Pending</button>
                         <?php   } ?>

                        <?php if($customerdetails["status"] == "1"){?>
                            <button type="button" class="btn btn-success btn-sm">Active</button>
                         <?php   } ?>

                        <?php if($customerdetails["status"] == "2"){?>
                          <button type="button" class="btn btn-danger btn-sm">Rejected</button>
                       

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
