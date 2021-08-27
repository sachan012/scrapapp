<style> 
   .panel { 
   padding: 10px; 
   border: 1px solid #c0c2c4;
   } 
</style>

 <link href="https://www.jqueryscript.net/demo/Clean-jQuery-Date-Time-Picker-Plugin-datetimepicker/jquery.datetimepicker.css" rel="stylesheet">

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
          
             <a href="<?php echo base_url();?>staffentery/index/all"> <button type="button" class="btn btn-block btn-primary btn-sm">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back</button></a>
            
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
                        <h3 class="card-title">Update Entry Details</h3>
                        <div class="card-tools">
                           <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                           <i class="fas fa-minus"></i></button>
                           <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                           <i class="fas fa-times"></i></button>
                        </div>
                     </div>
                     <div class="card-body">
                        <!-- Main content -->
                        <form action="<?php echo base_url('staffentery/edit')."/".$id; ?>" method="post" name="addentery" id="addentery" required>
                           <div class="form-group row">                              
                              <select class="form-control" name="auction" required>
                                 <option value="">----Select Auction Details -----<option
                                 <?php foreach($auctionList as $list){?>
                                 <option value="<?php echo $list['id']?>" <?php if($list['id'] == $entery_details["auction_id"]){ echo "selected";} ?>><?php echo ucfirst($list['material_code'])?>&nbsp;-&nbsp;<?php echo ucfirst($list['material_type'])?>&nbsp;-&nbsp;<?php echo ucfirst($list['plant_code'])?></option>  
                                 <?php }?>                               
                              </select>                                
                           </div>                       
                        
                           <div class="row">                              
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Vehicle Rrgistration <span style="color: red;">*</span></label>
                                    <input type="text" value="<?php echo $entery_details["vehicle_registration"]; ?>" name="vehicle_rgistration" id="vehicle_rgistration" class="form-control" required>
                                    <?php echo form_error('vehicle_rgistration'); ?>
                                 </div>
                              </div>

                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Driver<span style="color: red;">*</span></label>
                                    <input type="text" value="<?php echo $entery_details["driver"]; ?>" name="Driver" id="Driver" class="form-control" required>
                                    <?php echo form_error('Driver'); ?>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Entry Time</label>
                                    <input type="text" value="<?php echo $entery_details["time_of_entry"]; ?>" name="entry_time" id="entry_time" class="form-control entry_time" autocomplete="off"> 
                                    <?php echo form_error('entry_time'); ?>
                                 </div>
                              </div>							  
							  <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Exit Time </label>
                                    <input type="text" value="<?php echo $entery_details["time_of_exit"]; ?>" name="exit_time" id="exit_time" class="form-control exit_time" autocomplete="off">
                                    <?php echo form_error('exit_time'); ?>
                                 </div>
                              </div>					  
							  
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Weight before load</label>
                                    <input type="text" value="<?php echo $entery_details["weight"]; ?>" name="Weight" id="Weight" class="form-control" autocomplete="off">
                                    <?php echo form_error('Weight'); ?>
                                 </div>
                              </div>
							  
							  <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Weight After load</label>
                                    <input type="text" value="<?php echo $entery_details["weight_after"]; ?>" placeholder="Enter Weight" name="Weight_after" id="WeightLater" class="form-control" autocomplete="off">
                                    <?php echo form_error('Weight_after'); ?>
                                 </div>
                              </div>							  
                           </div>
                          
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                    <label>Scrap Dealer Details <span style="color: red;">*</span></label>

                                    <textarea required name="scrap_dealer" id="scrap_dealer" class="form-control" rows="2" placeholder="Enter scrap_dealer details."><?php echo $entery_details["scrape_dealer"]; ?></textarea>
                                    <?php echo form_error('scrap_dealer'); ?>
                                 </div>
                              </div>
                           </div>
                           <hr>
                          
                           <button id="submit" class="btn btn-md btn-primary" type="submit">Update</button>&nbsp;
                           
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
        $('#addentery').validate({
          rules: {
            vehicle_rgistration: {
              required: true,
              minlength: 5,
              /*lettersonly : true*/
            },
            
           Driver : {
                          required: true,
                          minlength: 5
                   },

           scrap_dealer: {
              required: true,
              minlength: 6,
            },
           
          
          },
          
          messages: {
           
            vehicle_rgistration: {
              required: "Please provide vehicle rgistration number",
            },           
            Driver: {
              required: "Please provide driver details",
            },
            scrap_dealer: {
              required: "Please provide scrap dealer details",
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
   <script src="https://www.jqueryscript.net/demo/Clean-jQuery-Date-Time-Picker-Plugin-datetimepicker/jquery.datetimepicker.js" type="text/javascript"></script>
<script type="text/javascript">
  
  $('.entry_time').datetimepicker({
  mask:'9999-19-39 29:59',
  format:'Y-m-d H:i:s',
  minDate:'-1970/01/02', // yesterday is minimum date
});

   $('.exit_time').datetimepicker({
  mask:'9999-19-39 29:59',
  format:'Y-m-d H:i:s',
  minDate:'-1970/01/02', // yesterday is minimum date
});

</script>

</body>
</html>