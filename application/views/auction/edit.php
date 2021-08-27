<!-- <link href="https://www.jqueryscript.net/demo/Clean-jQuery-Date-Time-Picker-Plugin-datetimepicker/jquery.datetimepicker.css" rel="stylesheet"> -->
<style type="text/css">

.remove-image {
display: none;
position: absolute;
top: -10px;
right: -10px;
border-radius: 10em;
padding: 2px 6px 3px;
text-decoration: none;
font: 700 21px/20px sans-serif;
background: #555;
border: 3px solid #fff;
color: #FFF;
box-shadow: 0 2px 6px rgba(0,0,0,0.5), inset 0 2px 4px rgba(0,0,0,0.3);
  text-shadow: 0 1px 2px rgba(0,0,0,0.5);
  -webkit-transition: background 0.5s;
  transition: background 0.5s;
}
.remove-image:hover {
 background: #E54E4E;
  padding: 3px 7px 5px;
  top: -11px;
right: -11px;
}
.remove-image:active {
 background: #E54E4E;
  top: -10px;
right: -11px;
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
	             	<a href="<?php echo base_url();?>auction/index/all"> <button type="button" class="btn btn-block btn-primary btn-sm">&nbsp;<i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp;Back</button></a>            
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
                        <h3 class="card-title">Edit Auction Information</h3>
                        <div class="card-tools">
                           <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                           <i class="fas fa-minus"></i></button>
                           <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                           <i class="fas fa-times"></i></button>
                        </div>
                     </div>

                    
                     <div class="card-body">
                        <!-- Main content --> 
                        <form action="<?php echo base_url('auction/edit')."/".$id; ?>" method="POST" name="auction_insert" id="auction_insert" enctype="multipart/form-data">			    		    
          			    		    <div class="form-group">
          			    		        <label for="title">Material Code&nbsp;<span style="color: red;">*</span></label>
          			    		        <input type="text" class="form-control" name="material_code" placeholder="Enter Material Code"  value="<?php echo $auction_details['material_code']; ?>" />
          			    		        <?php echo form_error('material_code', '<div class="error text-danger">', '</div>'); ?>
          			    		    </div>

                                 <div class="form-group">
          			    		        <label for="title">Plant Code&nbsp;<span style="color: red;">*</span></label>
          			    		        <input type="text" class="form-control" name="plant_code" placeholder="Enter Plant code"  value="<?php echo $auction_details['plant_code']; ?>" />
          			    		        <?php echo form_error('plant_code', '<div class="error text-danger">', '</div>'); ?>
          			    		    </div>

                            <div class="form-group">
          			    		        <label for="title">Material Type&nbsp;<span style="color: red;">*</span></label>
          			    		        <input type="text" class="form-control" name="material_type" placeholder="Enter Material Type"  value="<?php echo$auction_details['material_type']; ?>" />
          			    		        <?php echo form_error('material_type', '<div class="error text-danger">', '</div>'); ?>
          			    		    </div>

                           
                               

          			    		    
          			    		    <div class="form-group">
          			    		        <label for="description">Material Images&nbsp;<span style="color: red;">*</span></label>
                                <div class="lightbox-gallery">
                                  <div class="container">                              
                                    <div class="row photos">
                                      <?php foreach($images as $img){?>
                                          <div class="col-sm-3">                                    
                                             <img src="<?php echo base_url('uploads/scraps/'.$img['image']);?>" class="img-fluid mb-2" alt="white sample">
                                             <a class="remove-image" href="javascript:void(0);" data-id="<?php echo $img['id']?>" style="display: inline;">&#215;</a>
                                          </div>
                                      <?php }?>                  
                                    </div>                                  
                                  </div>
                                </div>          			    		         
          			    		    </div>
                             <div class="form-group">                               
                                 <input type="file" class="form-control" name="userfile[]" id="file" accept=".png,.jpg,.jpeg,.gif" value="" multiple>
                            </div>
                            
                             <div class="form-group">
          			    		        <label for="description">Material Description&nbsp;<span style="color: red;">*</span></label>
          			    		        <textarea rows="5" class="form-control" name="material_description" placeholder="Enter Material Description"><?php echo $auction_details['material_description']; ?></textarea>
          			    		        <?php echo form_error('material_description', '<div class="error text-danger">', '</div>'); ?>
          			    		    </div>
                                

                                 
                              <div class="form-group">
          			    		        <label for="title">Tentative Quantity(kg/Ton/etc)&nbsp;<span style="color: red;">*</span></label>
          			    		        <input type="text" class="form-control" name="amount_measure" placeholder="Enter Tentative Quantity(kg/Ton/etc)"  value="<?php echo $auction_details['material_weight']; ?>" />
          			    		        <?php echo form_error('amount_measure', '<div class="error text-danger">', '</div>'); ?>
          			    		   </div>
          			    		    
          			    		   <h4 class="mt-3">Bidding Time</h4>
                              <hr>                           
          			    		    
          			    		   <div class="row">
                              <?php                               
                                 $auctionstart =  $auction_details['auction_start_date'];                               
                                 $asdt = explode(' ',$auctionstart);
                                 $asd = $asdt['0'];
                                 $ast = $asdt['1'];

                                 $auctionends =  $auction_details['auction_close_date'];                               
                                 $aedt = explode(' ',$auctionends);
                                 $aed = $aedt['0'];
                                 $aet = $aedt['1'];                              
                              ?>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label>Auction Start Date <span style="color: red;">*</span></label>
                                       <input type="text" name="auction_start" id="from" class="form-control entry_time from" value="<?php echo $asd ?>"  placeholder="Enter Date time." autocomplete="off" required>
                                       <?php echo form_error('auction_start', '<div class="error text-danger">', '</div>'); ?>
                                    </div>                                
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label>Time <span style="color: red;">*</span></label>
                                       <input type="text" name="auction_start_time" id="from_time" class="form-control timepicker timepicker_from" value="<?php echo $ast ?>" placeholder="Enter entry time."  autocomplete="off" required>
                                    </div>                                
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label>Auction End Date <span style="color: red;">*</span></label>
                                       <input type="text" name="auction_end" id="to" class="form-control exit_time to" value="<?php echo $aed ?>"  placeholder="Enter exit time." autocomplete="off" required>
                                       <?php echo form_error('auction_end', '<div class="error text-danger">', '</div>'); ?>
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                       <label>End Time <span style="color: red;">*</span></label>
                                       <input type="text" name="auction_finish_time" id="to_time" class="form-control timepicker timepicker_to" value="<?php echo $aet ?>" placeholder="Enter closed time."  autocomplete="off" required>
                                       <?php echo form_error('auction_finish_time', '<div class="error text-danger">', '</div>'); ?>
                                    </div>                                
                                 </div>                              
                              </div>
                              <h4 class="mt-3">Validity of Auction</h4>
                              <hr>                                 
                              <div class="row">
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label>From Date <span style="color: red;">*</span></label>
                                       <input type="text" name="auction_validity_from_date" id="auction_validity_from_date" class="form-control entry_time from" placeholder="Enter Bid time."  value="<?php echo $auction_details['auction_validity_start_date']; ?>"  autocomplete="off" required>
                                       <?php echo form_error('auction_validity_from_date', '<div class="error text-danger">', '</div>'); ?>
                                    </div>                                
                                 </div>
                                
                                 <div class="col-md-6">
                                    <div class="form-group">
                                       <label>To Date <span style="color: red;">*</span></label>
                                       <input type="text" name="auction_validity_to_date" id="auction_validity_to_date" class="form-control exit_time to" value="<?php echo $auction_details['auction_validity_end_date']; ?>"  placeholder="Enter exit time."  autocomplete="off" required>
                                       <?php echo form_error('auction_validity_to_date', '<div class="error text-danger">', '</div>'); ?>
                                    </div>
                                 </div>                                                             
                              </div> 

          			    		    <div class="form-group">
          			    		        <button type="submit" class="btn btn-primary">
          			    		            UPDATE
          			    		        </button>
          			    		        
          			    		    </div>			    		
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

   <script>   
      $(function(){
	      var dateFormat = "yy-mm-dd";    
         from = $("#from").datepicker({minDate: 0, maxDate: "+1M",dateFormat: 'yy-mm-dd'});
         to = $("#to").datepicker({minDate: 0, maxDate: "+1M",dateFormat: 'yy-mm-dd'});         

         from2 = $("#auction_validity_from_date").datepicker({minDate: 0, maxDate: "+4M",dateFormat: 'yy-mm-dd'});
         to2 = $("#auction_validity_to_date").datepicker({minDate: 0, maxDate: "+4M",dateFormat: 'yy-mm-dd'});  
         
         function getDate(element)
         {
            var date;
            try {
            date = $.datepicker.parseDate( dateFormat, element.value );
            } catch( error ) {
            date = null;
            } 
            return date;
         }
      });
   </script>
   <script>
     $('input.timepicker_from').timepicker({
         timeFormat: 'HH:mm:ss',         
         dynamic: false,
         dropdown: true,
         scrollbar: true
      });

      $('input.timepicker_to').timepicker({
         timeFormat: 'HH:mm:ss',         
         dynamic: false,
         dropdown: true,
         scrollbar: true
      });
  </script>

   <script type="text/javascript">
      $("#imageUploadForm").submit(function(e) {
          e.preventDefault(); 
          var fd = new FormData(this);
        var files = $('#file')[0].files;
        
        // Check file selected or not
        if(files.length > 0 ){
           fd.append('file',files[0]);

           $.ajax({
              url: '<?php echo base_url('auction/image_upload_ajax');?>',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
                //alert(response);
                 if(response != 0){
                   window.location.reload();
                 }else{
                    alert('file not uploaded');
                 }
              },
           });
        }else{
           alert("Please select a file.");
        }    

      });
  </script>
   <script>
      $(document).ready(function() {
          $(".remove-image").on("click", function() {


              var Id = $(this).attr("data-id");
              //alert("The data-id of clicked item is: " + Id);
              var x = confirm("Are you sure you want to delete?");
              if (x)
              $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url('auction/removeAuctionImage');?>',
                  data: 'id=' + Id,
                  success: function(data) {
                      //alert(data);
                      console.log(data);
                      window.location.reload();
                  }

              })
          });
      });
  </script>
   
   
  
 
</body>
</html>