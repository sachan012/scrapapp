<?php

$this->db->select("*")->from("admins");
$this->db->where("id", $adminid);
$query = $this->db->get();
$adminDetails = $query->row_array();
$role_type_value = $adminDetails["role_type"]; 
//echo $role_type_value; die;
?>
<?php $this->load->view('includes/header_script', $data); ?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <?php $this->load->view('includes/header', $data); ?>   <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php $this->load->view('includes/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

   <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1>DataTables</h1> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>add-entery">
                <?php if(isset($role_type_value) && $role_type_value == 2) { ?>
                  <button type="button" class="btn btn-block btn-primary btn-sm">&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;New Entery&nbsp;</button>
                <?php }?>
              </a></li>
              <li class="breadcrumb-item"><a href="<?php echo base_url();?>add-entery">
                 <a href="<?php echo base_url(); ?>staffentery/entryExcel"><button class="btn btn-sm btn-success" type="button"><i class="far fa-file-excel"></i>&nbsp;&nbsp;Download as Excel</button></a>
              </a></li>
              
            </ol>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">           
          <div class="col-lg-12">
            <?php $this->load->view('includes/msg_alert'); ?>
          </div>
        </div> 
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">                
                 <div class="row">
                    <div class="col-md-3">
                      <h3>Vehicle Entries</h3>
                    </div>
                    <div class="col-md-3 text-right">
                       <?php if(isset($role_type_value) && $role_type_value == 1) { ?>
                      <button id="sendNotification" class="btn btn-danger" type="button"><i class="fas fa-user-times" title="Delete Entry"></i>&nbsp;&nbsp;Delete Entry</button>
                      <?php }?>
                    </div>
                    <div class="col-md-6">
                     <form name="select_option_form"  id="select_option_form" action="<?php echo base_url('staffentery/index/');?>">
                      <select class="form-control" name="auction" id="auction" required>
                        <option value="">----Select Auction Details -----</option>
                        <?php foreach($auctionList as $list){?>
                        <option value="<?php echo $list['id']?>" <?php if($_GET['auction']==$list['id']){echo "selected";}?>><?php echo ucfirst($list['material_code'])?>&nbsp;-&nbsp;<?php echo ucfirst($list['material_type'])?></option>  
                        <?php }?>                               
                      </select>
                    </form> 
                    </div>                    
                  </div>                
              </div>
              <!-- /.card-header -->
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <?php //echo $dataQuery;?>
                <table class="table table-hover text-nowrap table-bordered">
                  <thead>
                   <tr>
                    <?php if(isset($role_type_value) && $role_type_value == 1) { ?>
                    <th><input type="checkbox" id="select_all" /></th>    
                    <?php }else{?>
                    <th>SN</th>    
                    <?php }?>           
                    <th><a class="heading" id="vehicle_registration">VEHICLE NUMBER</a></th> 
                    <th><a class="heading" id="driver">DRIVER NAME</a></th>                  
                    <th><a class="heading" id="time_of_entry">ENTRY TIME</a></th>                   
                    <th><a class="heading" id="time_of_exit">EXIT TIME</a></th>
                    <th>ACTION</th>
                  </tr>
                  </thead>
                  <tbody>
                        <?php if(!empty($dbdata)) { ?>
                        <?php  foreach($dbdata as $row) { ?>
                        <tr>
                            <?php if(isset($role_type_value) && $role_type_value == 1) { ?>
                            <td><input type="checkbox" id="<?php echo 'id'.$row['id'];?>" class="checkbox" name="checkboxSelect[]" value="<?php echo $row["id"]?>"/></td>
                            <?php }else{?>
                            <td><?php echo $i++;?></td>
                            <?php }?> 
                          <td><?php echo $row['vehicle_registration']?></td>
                          <td><?php echo $row['driver']?></td>
                          <td><?php echo $row['time_of_entry']?></td>
                          <td><?php echo $row['time_of_exit']?></td>            
                          <td><a title="Edit" href="<?php echo base_url('edit-entry/').$row['id'];?>" class="btn btn-rounded btn-sm btn-icon btn-info "><i class="fa fa-edit"></i></a></td>           
                        </tr>   
                        <?php } ?>
                        <?php }else{?>
                        <tr><td colspan="6" class="text-center">No record found.</td></tr>
                        <?php }?>                  
                  </tbody>                  
                </table>
              </div>
              <!-- /.card-body -->
               <div class="card-footer">
                <div class="row text-right">
                    <div class="col-md-12" >
                        <?php echo $pagination; ?>
                    </div>
                </div>         
              </div>
            
            </div>
            <!-- /.card -->
          </div>
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
<script type="text/javascript">
    SyonApp.setPage('EnteryList');
    SyonApp.init();
</script>


<script>
$(document).ready(function(){
    $("#auction").change(function () {
     $("#select_option_form").submit(); 
     return false;
        var auction_id = $("#auction").val();
        //alert(auction_id);
        jQuery.ajax({
            url: "<?php echo base_url('Staffentery/ajax_filter_select');?>",    // Send the data with your url.
            type: "POST",
            dataType: "json",
            data:  {'auction_id': auction_id},     // Here you have written as {GenderID: gender} , not {'GenderID': gender}
            cache: false,
            dataType: "html",
            success:function(result) {
              //alert(result);
              $('tbody').html(result);
            }              
        });
    });
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
             alert("Select Checkbox/s to Record");
          }else{
            var val = [];
            $('.checkbox:checked').each(function(i){
              val[i] = $(this).val();
            }); 
            var confirmation = confirm("are you sure you want to remove the Data?"); 
            if(confirmation) {
               $.ajax({
                      type: 'POST',
                      url: '<?php echo base_url('Staffentery/delete');?>',
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





