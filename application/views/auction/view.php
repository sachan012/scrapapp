<?php $this->load->view('includes/header_script', $data); ?>
<style>
/*------------For Loader--------------*/
.spinner {
  position: fixed;
  z-index: 1;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 50 50'%3E%3Cpath d='M28.43 6.378C18.27 4.586 8.58 11.37 6.788 21.533c-1.791 10.161 4.994 19.851 15.155 21.643l.707-4.006C14.7 37.768 9.392 30.189 10.794 22.24c1.401-7.95 8.981-13.258 16.93-11.856l.707-4.006z'%3E%3CanimateTransform attributeType='xml' attributeName='transform' type='rotate' from='0 25 25' to='360 25 25' dur='0.6s' repeatCount='indefinite'/%3E%3C/path%3E%3C/svg%3E") center / 254px no-repeat;
}

</style>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 <?php $this->load->view('includes/header', $data); ?>
 <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatable/jquery.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/datatable/responsive.dataTables.min.css">
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  
    <?php $this->load->view('includes/sidebar'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="spinner" style="display:none;"></div>

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
    <!-- Main content -->
    <section class="content">
      <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="card-title">Auction Details</h5>              
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="chart">
                       <?php if(isset($auction_details)) {?>   
                        <!-- Sales Chart Canvas -->
                       <img src="<?php echo base_url();?>uploads/scraps/<?php echo $images['0']['image']?>" class="product-image img-responsive img-thumbnail" alt="Product Image"> 
                      <?php }?> 
                    </div>
                    <!-- /.chart-responsive -->
                     <?php if(count($images)>1){?>
                      <div class="col-12 product-image-thumbs">
                        <?php $i=0;foreach($images as $img){?>
                        <div class="img-responsive product-image-thumb  <?php if($i==0){echo "active";}?>" ><img src="<?php echo base_url();?>uploads/scraps/<?php echo $images[$i]['image'];?>" alt="Product Image"></div>
                       <?php $i++;}?>
                      </div>
                      <?php }?>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-9">
                    <table class="table table-bordered table-striped">                  
                  <tbody>
                    <tr>                     
                      <th>MATERIAL CODE:</th>                     
                      <td><?php echo $auction_details['material_code'] ;?></td>
                    </tr>

                    <tr>                     
                      <th>MATERIAL TYPE:</th>                     
                      <td><?php echo $auction_details['material_type'] ;?></td>
                    </tr> 

                    <tr>                     
                      <th>MATERIAL WEIGHT:</th>                     
                      <td><?php echo $auction_details['material_weight'] ;?></td>
                    </tr>

                    <tr>                     
                      <th>PLANT CODE:</th>                     
                      <td><?php echo $auction_details['plant_code'] ;?></td>
                    </tr>

                    <tr>                     
                      <th>AUCTION START-END DATE:</th>                     
                      <td><?php echo date("F j, Y", strtotime($auction_details['auction_start_date']))  ;?>&nbsp;-&nbsp;<?php echo date("F j, Y", strtotime($auction_details['auction_close_date'])) ;?></td>
                    </tr> 
                    <tr class="expandable-body">
                      <td colspan="5">
                        <p>
                          <?php echo $auction_details["material_description"] ;?>
                        </p>
                      </td>
                    </tr>



                  </tbody>
                </table>

                    

                   

                   

                   
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
             
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
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
<script src="<?php echo base_url();?>assets/plugins/datatable/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#example1').DataTable({
        "scrollX": true
    });
} );
</script>

<script type="text/javascript">
			$(document).ready(function() {
				$(".bid_user_status").change(function() {
                    if(confirm('Are you sure?')) { 
                        var bid_status = $(this).val();
                        var bid_id = $(this).data("bidid");
                        var auction_id = $(this).data("auction_id");
                        var user_id = $(this).data("user_id");
                        var dataString = 'bid_status='+ bid_status+'&bid_id='+bid_id;                       
                        $.ajax({
                            type:"POST",
                            url: "<?php echo base_url('auction/change_bid_status');?>",
                            data:'bid_status='+ bid_status+'&bid_id='+bid_id+'&auction_id='+auction_id+'&user_id='+user_id,
                            beforeSend: function(){
                              $('.spinner').show()
                              },
                              success: function(result){
                                  //alert(result);
                                  console.log(result);
								  location.reload();
                              },
                              complete: function(){
                                  $('.spinner').hide();
                              }
                              
                            });
                    }else{

                    }
				});
			});		
		</script>
</body>
</html>
