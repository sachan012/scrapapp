<?php $this->load->view('includes/header_script', $data); ?>
<style type="text/css">
.spinner {
  position: fixed;
  z-index: 1;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 50 50'%3E%3Cpath d='M28.43 6.378C18.27 4.586 8.58 11.37 6.788 21.533c-1.791 10.161 4.994 19.851 15.155 21.643l.707-4.006C14.7 37.768 9.392 30.189 10.794 22.24c1.401-7.95 8.981-13.258 16.93-11.856l.707-4.006z'%3E%3CanimateTransform attributeType='xml' attributeName='transform' type='rotate' from='0 25 25' to='360 25 25' dur='0.6s' repeatCount='indefinite'/%3E%3C/path%3E%3C/svg%3E") center / 254px no-repeat;
}

#customerstatus > option:nth-child(1) {
  color: yellow;
}

#customerstatus > option:nth-child(2) {
  color: green;
}

#customerstatus > option:nth-child(3) {
  color: red;
}

select#customerstatus { color: green; }
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
              <li class="breadcrumb-item"><a href="<?php echo base_url('users/index/all')?>">Home</a></li>
              <li class="breadcrumb-item active">App Users</li>
            </ol>
          </div>                  
          <div class="col-sm-6"></div>
        </div>
      </div>
    </section>
    <div class="spinner" style="display:none;"></div>
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
                    <div class="col-md-10">
                      <h3>App Users List</h3> 
                    </div>
                    <div class="col-md-2">
                      <a href="<?php echo base_url('users/download_report'); ?>" class="btn btn-success btn-sm"><i class="far fa-file-excel"></i>&nbsp;&nbsp;Download as Excel</a> 
                    </div>                    
                  </div>  
                               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                 <div class="row">
                    <div class="col-md-4">
                      <button id="sendNotification" class="btn btn-danger" type="button"><i class="fas fa-user-times" title="Delete Staff"></i>&nbsp;&nbsp;Delete App User</button>                     
                    </div>
                    <div class="col-md-8">
                      <form method="post" id="filter_form" name="filter_form" action="<?php if(isset($getData['page']) && $getData['page']!='0' && $getData['page']!='all'){echo base_url('users/index/'.$getData['page']);}else{ echo base_url('users/index'); } ?>" class="form-horizontal">
                      <div class="row">
                        <div class="col-md-3"> 
                          <input type="text" placeholder="Search Name" class="form-control like"  maxlength="255"  value="<?php if(isset($FormData['like']['fullname'])){echo $FormData['like']['fullname'];} ?>" name="FormData[like][fullname]" id="fullname" >
                        </div>                       
                        <div class="col-md-3"> 
                          <input type="text" placeholder="Search by email id" class="form-control like"  maxlength="255"  value="<?php if(isset($FormData['like']['email'])){echo $FormData['like']['email'];} ?>" name="FormData[like][email]" id="email" >
                        </div>
                        <div class="col-md-3"> 
                          <input type="text" placeholder="Search Phone" class="form-control like"  maxlength="255"  value="<?php if(isset($FormData['like']['phone'])){echo $FormData['like']['phone'];} ?>" name="FormData[like][phone]" id="phone" >
                        </div>
                        <div class="col-md-3"> 
                          <button type="button" class="btn btn-success" id="filter"><i class="fa fa-search"></i> Search</button>
                          <a href="<?php echo base_url(); ?>users/index/all"><button class="m-l-lg btn btn-default" type="button">Reset</button></a>
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
                <div class="table-responsive p-0">
                <table class="table table-hover text-nowrap table table-bordered">
                  <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all" /></th>
                        <th><a class="heading" id="fullname">FULL NAME</a></th>
                        <th><a class="heading" id="company_name">COMPANY NAME</a></th>                       
                        <th><a class="heading" id="email">EMAIL ID</a></th>
                        <th><a class="heading" id="pan_no">PAN NUMBER</a></th>
                        <th><a class="heading" id="gst_no">GST NUMBER</a></th> 
                        <th>ACCOUNT STATUS</th>
                        <th>ACTION</th>                  
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($dbdata>0){ ?>
                    <?php $i=1;  foreach($dbdata as $row) {  ?>
                      <tr>
                       <td><?php //echo $i++;?><input type="checkbox" id="<?php echo 'id'.$row['id'];?>" class="checkbox" name="checkboxSelect[]" value="<?php echo $row["id"]?>"/></td>
                        <td><?php echo ucwords($row["fullname"]);?></td> 
                        <td><?php echo ucwords($row["company_name"]);?></td>
                        <td><?php echo $row["email"];?></td>
                        <td><?php echo $row["pan_no"];?></td>
                        <td><?php echo $row["gst_no"];?></td>
                        <td>
                          <select class="form-control" style="width: 100%;" onchange="customerstatus(this.value)" id="customerstatus" > 
                            <option <?php if($row["status"] == 0) { echo "selected"; } ?> value="0_<?php echo $row["id"];?>">Pending</option>
                            <option <?php if($row["status"] == 1) { echo "selected"; } ?> value="1_<?php echo $row["id"];?>">Approved</option>
                            <option <?php if($row["status"] == 2) { echo "selected"; } ?> value="2_<?php echo $row["id"];?>">Reject</option>
                          </select>
                        </td>
                        <td> <a href="<?php echo base_url();?>view-user/<?php echo ($row["id"]);?>" class="btn btn-rounded btn-sm btn-icon btn-success"><i class="fas fa-eye" title="View Details"></i></a></td>
                      </tr>
                    <?php }?>
                    <?php }else{?>
                      <tr><td colspan="6" class="text-center">No Record Found</tr>
                    <?php }?>                   
                  </tbody>
                </table>
              </div>
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
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view('includes/footer'); ?>
</div>
<!-- ./wrapper -->

<!-- jQuery -->

<?php $this->load->view('includes/footer_scripts'); ?>

<script type="text/javascript">
    SyonApp.setPage('UserList');
    SyonApp.init();
</script>
<script type="text/javascript">
  
function customerstatus(item)
{

  var result = confirm("Are you sure to perform this operation?");
            if (result) 
    {
        var str = item;  
        var res = str.split("_");
        var id = res[1];  // getting the customer id
        var status = res[0];  // getting the status of user

        $.ajax({
                  type: "POST",
                  url: "<?php echo base_url();?>user-approve/"+id + "/"+status,
                   beforeSend: function(){
                       $('.spinner').show()
                   },
                  success: function(result){
                      //alert(result);
                      console.log(result);
                  },
                  complete: function(){
                       $('.spinner').hide();
                  }
              });
   }
}


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
             alert("Select a Checkbox to delete record");
          }else{
            var val = [];
            $('.checkbox:checked').each(function(i){
              val[i] = $(this).val();
            }); 
            var confirmation = confirm("are you sure you want to remove the data?"); 
            if(confirmation) 
            {
               $.ajax({
                      type: 'POST',
                      url: '<?php echo base_url('users/delete');?>',
                      data: 'id=' + val,
                      success: function(data) {                      
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





