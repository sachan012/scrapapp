<?php $this->load->view('includes/header_script', $data); ?>
<style type="text/css">
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
          <div class="col-sm-6">
              <ol class="breadcrumb float-sm-left">
                <li class="breadcrumb-item"><a href="<?php echo base_url('auction/index/all')?>">Home</a></li>
                <li class="breadcrumb-item active">Auction Lists</li>
              </ol>
          </div>  
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('create-auction');?>">
                <?php if(isset($adminid) && $adminid == 1) { ?>
                  <button type="button" class="btn btn-block btn-primary btn-sm">&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Create Auction&nbsp;</button>
                <?php }?>
              </a></li>
              
            </ol>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         <div class="row">
            <!-- <div class="col-lg-2"></div> -->
            <div class="col-lg-12">
                   <?php $this->load->view('includes/msg_alert'); ?>
            </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">                
                 <div class="row">
                    <div class="col-md-2 text-right">
                      <button id="sendNotification" class="btn btn-danger" type="button"><i class="fas fa-user-times" title="Delete Staff"></i>&nbsp;&nbsp;Delete Auction</button>                     
                    </div>
                    <div class="col-md-10">
                      <form method="post" id="filter_form" name="filter_form" action="<?php if(isset($getData['page']) && $getData['page']!='0' && $getData['page']!='all'){echo base_url('auction/index/'.$getData['page']);}else{ echo base_url('auction/index'); } ?>" class="form-horizontal">
                      <div class="row">
                        <div class="col-md-3"> 
                          <input type="text" placeholder="Search by Material Code" class="form-control like"  maxlength="255"  value="<?php if(isset($FormData['like']['material_code'])){echo $FormData['like']['material_code'];} ?>" name="FormData[like][material_code]" id="material_code" >
                        </div>                       
                        <div class="col-md-3"> 
                          <input type="text" placeholder="Search by Plant Code" class="form-control like"  maxlength="255"  value="<?php if(isset($FormData['like']['plant_code'])){echo $FormData['like']['plant_code'];} ?>" name="FormData[like][plant_code]" id="plant_code" >
                        </div>
                        <div class="col-md-3"> 
                          <input type="text" placeholder="Search Material Type" class="form-control like"  maxlength="255"  value="<?php if(isset($FormData['like']['material_type'])){echo $FormData['like']['material_type'];} ?>" name="FormData[like][material_type]" id="material_type" >
                        </div>
                        <div class="col-md-3"> 
                          <button type="button" class="btn btn-success" id="filter"><i class="fa fa-search"></i> Search</button>
                          <a href="<?php echo base_url(); ?>auction/index/all"><button class="m-l-lg btn btn-default" type="button">Reset</button></a>
                        </div>
                      </div>
                      <div class="form-group">                                          
                        <!--sorting-->
                        <input type="hidden" name="FormData[sort][field]" id="field" value="<?php if(isset($FormData['sort']['field'])){echo $FormData['sort']['field'];} ?>"/>
                        <input type="hidden" name="FormData[sort][order]" id="order" value="<?php if(isset($FormData['sort']['order'])){echo $FormData['sort']['order'];} ?>"/>
                        <!--page-->
                        <input type="hidden" name="FormData[form_name]" id="form_name" value="" />
                        <input type="hidden" name="FormData[sort][page]" id="page" value="<?php if(isset($getData['page'])) {echo $getData['page']; } ?>"/>
                      </div>
                      </form>
                    </div>                    
                  </div>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <?php //echo $last_query;?>
                <table class="table table-hover table table-bordered">
                  <thead>
                    <tr>
                            <th><input type="checkbox" id="select_all" /></th>
                            <th>#</th>
                            <th><a class="heading" id="material_code">MATERIAL CODE</a></th>
                            <th><a class="heading" id="material_type">MATERIAL TYPE</a></th>
                            <th><a class="heading" id="auction_start_date">AUCTION START DATE</a></th>                 
                            <th><a class="heading" id="auction_close_date">AUCTION END DATE</a></th>
                            <th><a class="heading" id="publish_status">PUBLISH STATUS</a></th>    
                                                  
                            <th>ACTION</th>
                          </tr>
                  </thead>
                  <tbody>
                      <?php if(!empty($dbdata)) { ?>
                    <?php  foreach($dbdata as $row) { ?>
                      <tr>
                        <td><?php //echo $i++;?><input type="checkbox" id="<?php echo 'id'.$row['id'];?>" class="checkbox" name="checkboxSelect[]" value="<?php echo $row["id"]?>"/></td>
                        <td>
                          <?php

                              $imge_array = $this->db->select('image')->where('auction_id',$row['id'])->get('image_gallery')->result_array();
                              $thumb = $imge_array['0']['image'];
                          ?>
                            <img src="<?php echo base_url('uploads/scraps/').$thumb;?>" class="thumbnail" style="width:60px;">
                          </td>                       
                        <td><?php echo ucwords(trim($row["material_code"]));?></td>
                                           
                        <td><?php echo ucwords(trim($row["material_type"]));?></td>
                       
                        <td><?php echo ucwords(trim($row["auction_start_date"]));?></td>
                        <td><?php echo ucwords(trim($row["auction_close_date"]));?></td>
                                                 
                        <td><i style="cursor: pointer;" 
                              data="<?php echo $row['id'];?>" class="badge badge-warning status_checks label label-sm <?php echo $row['publish_status']?
                                                  'badge-success': 'badge-danger'?>"><?php echo $row['publish_status'] ? 'Active' : 'Inactive'?>
                                                 </i></td>  



                                         
                        
                        
                       
                        <td class="text-right py-0 align-middle">
                        <?php if(isset($adminid) &&  ($adminid == 1 || $roleDes == 3 || $roleDes == 4 || $roleDes == 5 || $roleDes == 6)) { ?>
                          <div class="btn-group btn-group-sm">
                            <a href="<?php echo base_url();?>view-auction/<?php echo ($row["id"]);?>" class="btn btn-success"><i class="fas fa-eye" title="View Action"></i></a>&nbsp;&nbsp;
                            <a href="<?php echo base_url();?>edit-auction/<?php echo ($row["id"]);?>" class="btn btn-info"><i class="fas far fa-edit" title="Edit Action"></i></a>&nbsp;&nbsp;
                            <a href="<?php echo base_url();?>view-bids/<?php echo ($row["id"]);?>" class="btn btn-warning"><i class="fas fa-briefcase" title="View Bids"></i></a>&nbsp;&nbsp;

                           
                           
                          </div>
                          <?php }?>
                        </td>                      
                      </tr>
                    <?php } }else{ ?>
                      <tr>
                          <td colspan="9" class="text-center">No Record Found</td>                        
                        </tr> 
                      <?php }?>                 
                  </tbody>     
                </table>
              </div>
              <div class="card-footer">
                <div class="row text-right" style="float: right;">
                    <div class="col-md-12" >
                        <?php echo $pagination; ?>
                    </div>
                </div>         
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
             
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('includes/footer'); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery -->

<?php $this->load->view('includes/footer_scripts'); ?>
<script type="text/javascript">
    SyonApp.setPage('AuctionList');
    SyonApp.init();
</script>
<script type="text/javascript">
    $(document).on('click','.status_checks',function(){
      var status = ($(this).hasClass("badge-success")) ? '0' : '1';
      var msg = (status=='0')? 'Deactivate' : 'Activate';
      if(confirm("Are you sure to "+ msg)){
        var current_element = $(this);
        url = "<?php echo site_url('auction/auctionStatus');?>";
        $.ajax({
          type:"POST",
          url: url,
          data: {id:$(current_element).attr('data'),status:status},
          success: function(data)
          {
            //console.log(data);
            location.reload();
          }
        });
      }
    });
</script>
    <script type="text/javascript">
  $(document).ready(function(){
      $('#select_all').on('click',function(){
          if(this.checked){                   
              $('.checkbox').each(function(){
                  this.checked = true;                                       
              });
          }else{
               $('.checkbox').each(function(){
                  this.checked = false;                                           
              });
          }
      });                    
  });
  </script>

    <script>
    $(document).ready(function() {
        $("#sendNotification").click(function() {
            var isChecked = $(".checkbox").is(":checked");
            if(isChecked==false){
                alert("Select Checkbox/s to delete");
            }else{
                var val = [];
                $('.checkbox:checked').each(function(i){
                    val[i] = $(this).val();
                }); 
                var confirmation = confirm("are you sure you want to remove the item?"); 
                if(confirmation) 
                {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('auction/delete');?>',
                        data: 'id=' + val,
                        success: function(data) 
                        {                      
                            window.location.reload();
                        }
                    });
                }
            }
        });
    });
    </script>

</body>
</html>





