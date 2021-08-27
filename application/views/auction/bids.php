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
      <!-- Default box -->
      <div class="card">
         <div class="card-header">
          <div class="row">

            <?php if($roleType == 1) { ?>
            <div class="col-md-8"><h3>Bid Entries</h3> </div>
          <?php } else { ?>
           <div class="col-md-10"><h3>Bid Entries</h3> </div>
          <?php } ?>


<?php if($roleType == 1) { ?>
              <div class="col-md-2"><a onclick="return confirm('Are you sure?')" href="<?php echo base_url('auction/clearremarks').'/'.$auction_details['id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i>&nbsp;&nbsp;Cancel Result</a> </div>
<?php }?>


            <div class="col-md-2"><a href="<?php echo base_url('auction/download_report').'/'.$auction_details['id']; ?>" class="btn btn-success btn-sm"><i class="far fa-file-excel"></i>&nbsp;&nbsp;Download as Excel</a> </div>
          </div>          
        </div>
        <div class="card-footer">
               <?php if(isset($auction_details)) {?>         
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">                     
                      <span class="description-header">MATERIAL CODE</span>
                       <h5 class="description-text"><?php echo $auction_details['material_code'] ;?></h5>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">                     
                      <h5 class="description-header">PLANT CODE</h5>
                      <span class="description-text"><?php echo $auction_details['plant_code'] ;?></span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">                     
                      <h5 class="description-header">MATERIAL TYPE</h5>
                      <span class="description-text"><?php echo $auction_details['material_type'] ;?></span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">                     
                      <h5 class="description-header">MATERIAL WEIGHT</h5>
                      <span class="description-text"><?php echo $auction_details['material_weight'] ;?></span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                 <?php }?> 
                <!-- /.row -->
              </div>
       
        <div class="card-body table-responsive p-0">
            <table id="example1" class="table table-bordered text-wrap">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Bid Amount (rate/Kg)</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">GST</th>
                    <th scope="col">PAN</th>

                     <th><a class="heading" id="publish_status">APPROVER</a></th> 

                      <th><a class="heading" id="publish_status">APPROVER STATUS</a></th> 

                    <th scope="col">RESULT STATUS</th>
                </tr>
            </thead>
            <tbody> 

           <?php  //echo "<pre>"; print_r($bids_details); die; ?>
            
                <?php if(count($bids_details)>0){ $i=1; foreach($bids_details as $bids){?>
                    <tr bgcolor="<?php if($bids['bid_status']==2){echo "#ABEBC6"; };?>">
                        <td><?php echo $i;?></td>
                        <td><?php echo $bids['fullname'];?></td>
                        <td><?php echo $bids['company_name'];?></td>
                         <td><?php echo "&#8377;".$bids['bid_amount'];?></td>
                        <td><?php echo $bids['email'];?></td>
                        <td><?php echo $bids['phone'];?></td>
                        <td><?php echo $bids['address'];?></td>
                        <td><?php echo $bids['gst_no'];?></td>
                        <td><?php echo $bids['pan_no'];?></td>

                         <td>


                          <?php if(count($bids_details) == 1) { ?>

                            <a href="<?php echo base_url();?>view-approval/<?php echo ($bids["bidid"]);?>" class="btn btn-warning"><i class="fas fa fa-check" title="Approver"></i></a>&nbsp;&nbsp;

                          <?php } else { ?>



                           <?php  if($approvedBid == 0) {   ?>
                            <a href="<?php echo base_url();?>view-approval/<?php echo ($bids["bidid"]);?>" class="btn btn-warning"><i class="fas fa fa-check" title="Approver"></i></a>&nbsp;&nbsp;
                           <?php } else { if($approvedBid["id"] == $bids["bidid"]) {  ?>

                            <a href="<?php echo base_url();?>view-approval/<?php echo ($bids["bidid"]);?>" class="btn btn-warning"><i class="fas fa fa-check" title="Approver"></i></a>&nbsp;&nbsp;
                           <?php } } ?>

                             <?php }  ?>
                           


                         </td>

                        <td>
                           

                             <?php  if($bids["approver_one_status"] == 1) { ?>
                          <p>Approver 1 : <?php if($bids["approver_one_status"] == 1) { echo "<b style='color:green'>Approved</b>"; } ?></p>

                          <p>Approver 2 : <?php if($bids["approver_two_status"] == 1) { echo "<b style='color:green'>Approved</b>"; } ?></p>

                          <p>Approver 3 : <?php if($bids["approver_three_status"] == 1) { echo "<b style='color:green'>Approved</b>"; } ?></p>

                          <p>Approver 4 : <?php if($bids["approver_four_status"] == 1) { echo "<b style='color:green'>Approved</b>"; } ?></p>

                        <?php } ?>


                         </td>     

                        <td>

                          <?php  if($bids["approver_one_status"] == 1 &&  $bids["approver_two_status"] == 1 && $bids["approver_three_status"] == 1 && $bids["approver_four_status"] == 1  && ($roleType == 1 || $roleType == 6)) { ?>

                             <select name="bid_user_status" class="bid_user_status" data-bidid="<?php echo $bids['bidid'];?>" data-user_id="<?php echo $bids['user_id'];?>" data-auction_id="<?php echo $bids['auction_id'];?>">
                                <option value="1" <?php if($bids['bid_status']=='1'){echo "selected";}?> class="text-warning">Pending</option>
                                <option value="2" <?php if($bids['bid_status']=='2'){echo "selected";}?> class="text-success">Winner</option>
                                <option value="3" <?php if($bids['bid_status']=='3'){echo "selected";}?> class="text-danger">Looser</option>
                            </select>
                    
                        <?php } else { ?>

                          <select disabled name="bid_user_status" class="bid_user_status" data-bidid="<?php echo $bids['bidid'];?>" data-user_id="<?php echo $bids['user_id'];?>" data-auction_id="<?php echo $bids['auction_id'];?>">
                                <option value="1" <?php if($bids['bid_status']=='1'){echo "selected";}?> class="text-warning">Pending</option>
                                <option value="2" <?php if($bids['bid_status']=='2'){echo "selected";}?> class="text-success">Winner</option>
                                <option value="3" <?php if($bids['bid_status']=='3'){echo "selected";}?> class="text-danger">Looser</option>
                            </select>
                          <?php }  ?>



                          </td>
                    </tr>
                <?php $i++;} }else{?>
                    <tr><td colspan="9" class="text-center">No Bids Available for this Auction</td></tr>
                <?php }?>   
            </tbody>
                
   
            </table>
        </div>
        <!-- /.card-body -->
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
                                    //console.log(result);
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
