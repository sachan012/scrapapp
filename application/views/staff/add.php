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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-11">
            <!-- <h1>Blank Page</h1> -->
          </div>
          <div class="col-sm-1">
          
             <a href="<?php echo base_url();?>staff/index/all"> <button type="button" class="btn btn-block btn-primary btn-sm">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back</button></a>
            
          </div>

        </div>
      </div>
    </section>
   <!-- /.content-header -->
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <!-- Small boxes (Stat box) -->
         <div class="row">
            <!-- <div class="col-lg-1"></div> -->
            <div class="col-lg-8">
               <?php $this->load->view('includes/msg_alert'); ?>
            </div>
         </div>
         <div class="row">
            <!-- <div class="col-lg-1"></div> -->
            <div class="col-lg-8">
               <!-- Main content -->
               <section class="content">
                  <!-- Default box -->
                  <div class="card">
                     <div class="card-header">
                        <h3 class="card-title">Add Staff Details</h3>
                        <div class="card-tools">
                           <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                           <i class="fas fa-minus"></i></button>
                           <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                           <i class="fas fa-times"></i></button>
                        </div>
                     </div>
                     <div class="card-body">
                        <!-- Main content -->
                        <form action="<?php echo base_url('add-staff'); ?>" method="post" name="addstaff" id="addstaff" required>
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Name <span style="color: red;">*</span></label>
                                    <input type="text" placeholder="Enter user name" name="name" id="name" class="form-control" required>
                                    <?php echo form_error('name'); ?>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Email Id <span style="color: red;">*</span></label>
                                    <input type="text" placeholder="Enter user email id" name="email" id="email" class="form-control" required>
                                    <?php echo form_error('email'); ?>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label>Phone Number <span style="color: red;">*</span></label>
                                    <input type="text" placeholder="Enter user phone number." name="phone" id="phone" class="form-control" required>
                                    <?php echo form_error('phone'); ?>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label>Address <span style="color: red;">*</span></label>

                                    <textarea required name="address" id="address" class="form-control" rows="2" placeholder="Enter user address."></textarea>
                                    <?php echo form_error('address'); ?>
                                 </div>
                              </div>
                           </div>
                           <hr>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Username / Login Id<span style="color: red;">*</span></label>
                                    <input type="text" placeholder="Enter username." name="username" id="username" class="form-control" required>
                                    <?php echo form_error('username'); ?>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Password <span style="color: red;">*</span></label>
                                    <input type="password" placeholder="Enter password." name="password" id="password" class="form-control" required>
                                    <?php echo form_error('password'); ?>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Role <span style="color: red;">*</span></label>
                                    <select class="form-control" id="role" name="role" required>
                                       <option value="">Select the user role</option> 
                                       <?php foreach($roles as $row) { if($row->role_id != 1) { ?>
                                       <option  value="<?php echo $row->role_id; ?>"><?php echo ucwords($row->roll_name); ?></option>
                                       <?php } } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Status <span style="color: red;">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                       <option value="">Select the user status</option>
                                       <option value="active">Active</option>
                                       <option value="inctive">Inactive</option>
                                    </select>
                                 </div>
                              </div>
                           </div>
                           <hr>
                           <button id="submit" class="btn btn-md btn-primary" type="submit">Submit</button>&nbsp;
                           <button class="btn btn-md btn-danger" type="reset">Reset</button>
                        </form>
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
               <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
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
        $('#addstaff').validate({
          rules: {
            name: {
              required: true,
              minlength: 5,
              /*lettersonly : true*/
            },
            email: {
              required: true,
              email: true
            },
           phone : {
                          required: true,
                          number : true,
                          minlength: 10,
                          maxlength: 12
                   },

           username: {
              required: true,
              minlength: 6,
            },
            password: {
              required: true,
               minlength: 6,
            },

           role: {
              required: true,
            },

            status: {
              required: true,
            },
             address: {
              required: true,
            },

          },
          
          messages: {
           
            name: {
              required: "Please provide user name",
            },
            email: {
              required: "Please provide user email id",
            },
            phone: {
              required: "Please provide user phone number",
            },
            username: {
              required: "Please provide user username",
            },
            password: {
              required: "Please provide user password",
            },
            role: {
              required: "Please selct user role",
            },
             status: {
              required: "Please select user status",
            },
             address: {
              required: "Please provide user full address",
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

      $("input").on("keypress", function(e) {
          if (e.which === 32 && !this.value.length)
              e.preventDefault();
      });
   </script>
</body>
</html>