<?php  $this->load->view('includes/header_script', $data); ?>
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

      <!-- Small boxes (Stat box) -->
         <div class="row">
            <!-- <div class="col-lg-1"></div> -->
            <div class="col-lg-12">
               <?php $this->load->view('includes/msg_alert'); ?>
            </div>
         </div>
      <!-- Default box -->
      <div class="card">
        
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
              <br>
       
        <div class="card-body table-responsive p-0">
            <table id="example1" class="table table-bordered text-wrap">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Approver</th>
                    <th scope="col">Remarks</th>
                    <th scope="col" style="
    width: 240px;
">Date</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody> 

           <?php  //echo "<pre>"; print_r($roleNames[2]["roll_name"]); die; ?>
               <form action="<?php echo base_url();?>auction/approver" method="post">
                    <tr style="margin-top:5px;">
                        <td>
                            <br>1.</td>
                        <td> <br><?php echo strtoupper($roleNames[2]["roll_name"]); ?></td>

                        <td>
                          <?php if($bids_details["approver_one_status"] == 1) { ?>

                             <!-- <input type="text" class="form-control" name="remark" value="<?php echo $bids_details["approver_remark_one"]; ?>"></td> -->

                             <textarea class="form-control" rows="5" id="comment" name="remark">
                                 <?php echo trim($bids_details["approver_remark_one"]); ?></textarea>
                            
                             </td>

                          <?php } else { ?>

                            <!--  <input type="text" class="form-control" required name="remark" placeholder="Enter the approver 1 remark"></td> -->

                            <textarea class="form-control" rows="5" id="remark" name="remark"></textarea>
                             
                             </td>

                          <?php  } ?>

                         
                         <td><!-- <input type="text" class="form-control" name="approved_date" readonly value="<?php echo $bids_details["approver_remark_one_date"];?>"> --> <br>
                             <?php echo $bids_details["approver_remark_one_date"];?>
                         </td>


                        <td> <br>

                          <?php if($bids_details["approver_one_status"] == 0 && $roleType == 3) { ?>
                          <input class="btn btn-primary" type="submit" value="approved"><?php } else if($bids_details["approver_one_status"] == 1) { ?>

                            <b style="color:green;">DONE</b>
                          <?php } else { ?>

                             <b>PENDING</b>

                          <?php } ?>
</td>




                        <input type="hidden" name="bidid" value="<?php echo $bids_details["id"]; ?>">
                        <input type="hidden" name="auctionid" value="<?php echo $bids_details["auction_id"]; ?>">
                         <input type="hidden" name="type" value="1">
                       
                    </tr>
                </form>

                <form action="<?php echo base_url();?>auction/approver" method="post">
                    <tr style="margin-top:5px;">
                        <td> <br>2.</td>
                         <td> <br><?php echo strtoupper($roleNames[3]["roll_name"]); ?></td>
                        <td>
                          <?php if($bids_details["approver_two_status"] == 1) { ?>

                             <!-- <input type="text" class="form-control" name="remark" value="<?php echo $bids_details["approver_remark_two"]; ?>"></td> -->

                                <textarea class="form-control" rows="5" id="remark" name="remark">
                                 <?php echo $bids_details["approver_remark_two"]; ?></textarea>
                             </td>



                          <?php } else { ?>

                            <!--  <input type="text" class="form-control" required name="remark" placeholder="Enter the approver 2 remark"></td> -->

                            <textarea class="form-control" rows="5" id="remark" name="remark">
                             </textarea>


                          <?php  } ?>

                         
                         <td><!-- <input type="text" class="form-control" name="approved_date" readonly value="<?php echo $bids_details["approver_remark_two_date"];?>"> --> <br>
                             
                             <?php echo $bids_details["approver_remark_two_date"];?>

                         </td>


                        <td> <br>

                          <?php if($bids_details["approver_two_status"] == 0 && $roleType == 4 && $bids_details["approver_one_status"] == 1) { ?>
                          <input class="btn btn-primary" type="submit" value="approved"><?php } else if($bids_details["approver_two_status"] == 1) { ?>

                            <b style="color:green;">DONE</b>
                          <?php } else { ?>

                             <b>PENDING</b>

                          <?php } ?>
</td>


                        <input type="hidden" name="bidid" value="<?php echo $bids_details["id"]; ?>">
                        <input type="hidden" name="auctionid" value="<?php echo $bids_details["auction_id"]; ?>">
                        <input type="hidden" name="type" value="2">
                    </tr>
                </form>


                <form action="<?php echo base_url();?>auction/approver" method="post">
                    <tr style="margin-top:5px;">
                        <td> <br>3.</td>
                        <td> <br><?php echo strtoupper($roleNames[4]["roll_name"]); ?></td>
                        <td>
                          <?php if($bids_details["approver_three_status"] == 1) { ?>

                            <!--  <input type="text" class="form-control" name="remark" value="<?php echo $bids_details["approver_remark_three"]; ?>"></td> -->

                            <textarea class="form-control" rows="5" id="remark" name="remark">
                                 <?php echo $bids_details["approver_remark_three"]; ?></textarea>
                             </td>



                          <?php } else { ?>

                            <!--  <input type="text" class="form-control" required name="remark" placeholder="Enter the approver 3 remark"></td> -->
                             <textarea class="form-control" rows="5" id="remark" name="remark"></textarea>
                             </td>

                          <?php  } ?>

                         
                         <td><!-- <input type="text" class="form-control" name="approved_date" readonly value="<?php echo $bids_details["approver_remark_three_date"];?>"> --> <br>
                             <?php echo $bids_details["approver_remark_three_date"];?>
                         </td>


                        <td> <br>

                          <?php if($bids_details["approver_three_status"] == 0 && $roleType == 5 && $bids_details["approver_two_status"] == 1) { ?>
                          <input class="btn btn-primary" type="submit" value="approved"><?php } else if($bids_details["approver_three_status"] == 1) { ?>

                            <b style="color:green;">DONE</b>
                          <?php } else { ?>

                             <b>PENDING</b>

                          <?php } ?>


                          </td>


                        <input type="hidden" name="bidid" value="<?php echo $bids_details["id"]; ?>">
                        <input type="hidden" name="auctionid" value="<?php echo $bids_details["auction_id"]; ?>">
                         <input type="hidden" name="type" value="3">
                    </tr>
                </form>



                <form action="<?php echo base_url();?>auction/approver" method="post">
                    <tr style="margin-top:5px;">
                        <td> <br>4.</td>
                         <td> <br><?php echo strtoupper($roleNames[5]["roll_name"]); ?></td>

                       <td>
                          <?php if($bids_details["approver_four_status"] == 1) { ?>

                           <!--   <input type="text" class="form-control" name="remark" value="<?php echo $bids_details["approver_remark_four"]; ?>"></td> -->

                           <textarea class="form-control" rows="5" id="remark" name="remark">
                                 <?php echo $bids_details["approver_remark_four"]; ?> </textarea>
                            </td>

                          <?php } else { ?>

                            <!--  <input type="text" class="form-control" name="remark" required placeholder="Enter the approver 4 remark"></td> -->

                             <textarea class="form-control" rows="5" id="remark" name="remark"></textarea>
                             </td>

                          <?php  } ?>

                         
                         <td><!-- <input type="text" class="form-control" name="approved_date" readonly value="<?php echo $bids_details["approver_remark_four_date"];?>"> -->
                              <br><?php echo $bids_details["approver_remark_four_date"];?>
                         </td>


                        <td> <br>

                          <?php if($bids_details["approver_four_status"] == 0 && $roleType == 6 && $bids_details["approver_three_status"] == 1) { ?>
                          <input class="btn btn-primary" type="submit" value="approved"><?php } else if($bids_details["approver_four_status"] == 1) { ?>

                            <b style="color:green;">DONE</b>
                          <?php } else { ?>

                             <b>PENDING</b>

                          <?php } ?>
                    </td>

                        <input type="hidden" name="bidid" value="<?php echo $bids_details["id"]; ?>">
                        <input type="hidden" name="auctionid" value="<?php echo $bids_details["auction_id"]; ?>">
                        <input type="hidden" name="type" value="4">
                    </tr>
                </form>

              
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
