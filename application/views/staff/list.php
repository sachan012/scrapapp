<?php $this->load->view('includes/header_script', $data); ?>

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
							              <li class="breadcrumb-item"><a href="<?php echo base_url('staff/index/all')?>">Home</a></li>
							              <li class="breadcrumb-item active">Staff Users</li>
							            </ol>
							        </div>									
									<div class="col-sm-6">
										<ol class="breadcrumb float-sm-right">
											<li class="breadcrumb-item">
												<a href="<?php echo base_url();?>add-staff">
													<?php if(isset($adminid) && $adminid == 1) { ?>
														<button type="button" class="btn btn-block btn-primary btn-sm">&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;New Staff&nbsp;</button>
														<?php }?>
												</a>
											</li>
										</ol>
									</div>
								</div>
							</div>
						</section>
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
									<div class="col-sm-12">
										<form method="post" id="filter_form" name="filter_form" action="<?php if(isset($getData['page']) && $getData['page']!='0' && $getData['page']!='all'){echo base_url('staff/index/'.$getData['page']);}else{ echo base_url('staff/index'); } ?>" class="form-horizontal">
											<div class="card">
												<div class="card-header">
													<div class="row">
											            <div class="col-md-10"><h3>Staff List</h3> </div>
											            <div class="col-md-2"><a href="<?php echo base_url('staff/download_report'); ?>" class="btn btn-success btn-sm"><i class="far fa-file-excel"></i>&nbsp;&nbsp;Download as Excel</a> </div>
											          </div>  
												</div>
												<div class="card-body" style="padding-bottom: 0rem !important;padding-top: 1rem !important;">
													<div class="row">
													    <div class="col-md-4">															
															<button id="sendNotification" class="btn btn-danger" type="button"><i class="fas fa-user-times" title="Delete Staff"></i>&nbsp;&nbsp;Delete Staff</button>
														</div>
														<div class="col-md-8">
															<div class="row">
																<div class="col-md-3">
																	<input type="text" placeholder="Search by name" class="form-control like" maxlength="255" value="<?php if(isset($FormData['like']['name'])){echo $FormData['like']['name'];} ?>" name="FormData[like][name]" id="name">
																</div>
																<div class="col-md-3">
																	<input type="text" placeholder="Search by email id" class="form-control like" maxlength="255" value="<?php if(isset($FormData['like']['email'])){echo $FormData['like']['email'];} ?>" name="FormData[like][email]" id="email">
																</div>
																<div class="col-md-3">
																	<input type="text" placeholder="Search by phone" class="form-control like" maxlength="255" value="<?php if(isset($FormData['like']['phone'])){echo $FormData['like']['phone'];} ?>" name="FormData[like][phone]" id="phone">
																</div>
																<div class="col-md-3">
																	<button type="button" class="btn btn-primary" id="filter"><i class="fa fa-search"></i> Search</button>
																	<a href="<?php echo base_url(); ?>staff/index/all">
																		<button class="m-l-lg btn btn-default" type="button">Reset</button>
																	</a>
																</div>
															</div>
															<div class="form-group">
																<!--sorting-->
																<input type="hidden" name="FormData[sort][field]" id="field" value="<?php if(isset($FormData['sort']['field'])){echo $FormData['sort']['field'];} ?>" />
																<input type="hidden" name="FormData[sort][order]" id="order" value="<?php if(isset($FormData['sort']['order'])){echo $FormData['sort']['order'];} ?>" />
																<!--page-->
																<input type="hidden" name="FormData[form_name]" id="form_name" value="" />
																<input type="hidden" name="FormData[sort][page]" id="page" value="<?php if(isset($getData['page'])) {echo $getData['page']; } ?>" /> </div>
															</div>
														
													</div>
													<div class="row">
														<div class="table-responsive">
														<?php if(!empty($dbdata)) { ?>
															<table id="example1" class="table table-bordered table-striped text-nowrap">
																<thead>
																	<tr>
																		<th><input type="checkbox" id="select_all" /></th>
																		<th><a class="heading" id="name">NAME</a></th>
																		<th><a class="heading" id="email">EMAIL</a></th>																		
																		<th><a class="heading" id="username">USERNAME</a></th>																		
																		<th>STATUS</th>
																		<th>AUCTION</th>
																	</tr>
																</thead>
																<tbody>
																	<?php $i=1; 
																		foreach($dbdata as $row) {
																	?>
																	<form name="frmgrouplist" id="frmitf">
																		<tr>
																			<td><?php //echo $i++;?><input type="checkbox" id="<?php echo 'id'.$row['id'];?>" class="checkbox" name="checkboxSelect[]" value="<?php echo $row["id"]?>"/></td>
																			<td><?php echo ucwords(trim($row["name"]));?></td>
																			<td><?php echo (trim($row["email"]));?></td>
																			<td>
																				<?php echo ucwords(trim($row["username"]));?>
																			</td>															
																			<td style="color: <?php if($row[" status "] == "active ") { echo "green "; } else { echo "red "; } ?>">
																				<?php if($row["status"] == "active") { echo "Active"; } else { echo "Inactive"; } ?>
																			</td>
																			<td style="text-align: left;">
																				<?php if(isset($adminid) && $adminid == 1) { ?> 
																					 <a href="<?php echo base_url();?>view-staff/<?php echo ($row["id"]);?>" class="btn btn-rounded btn-sm btn-icon btn-success"><i class="fas fa-eye" title="View Details"></i></a>&nbsp;&nbsp;
																				    <a href="<?php echo base_url();?>edit-staff/<?php echo ($row["id"]);?>" class="btn btn-rounded btn-sm btn-icon btn-info"><i class="fas fa-user-edit" title="Edit Staff"></i></a>&nbsp;&nbsp;
																				    <!-- <a href="javascript:void(0);" class="removeProduct btn btn-sm btn-danger" data-id="<?php echo ($row["id"]);?>"><i class="fas fa-user-times" title="Delete Staff"></i></a> -->
																				
																					<?php } ?>
																			</td>
																		</tr>
																		</form>
																		<?php  } ?>
																</tbody>
															</table>
															<?php } else{ ?>
																<h5 style="color: red;">No Staff Is Found</h5>
																<?php } ?>
														</div>
													</div>
												</div>
												<!-- /.card-body -->
											</div>
										</form>
									</div>
								</div>								
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
			<!-- jQuery -->
			<?php $this->load->view('includes/footer_scripts'); ?>
			<script type="text/javascript">
				SyonApp.setPage('StaffList');
				SyonApp.init();
			</script>
			
			<!-- <script>
              $(document).ready(function() {        
                  $(".removeProduct").on("click", function() {     
                    var Id = $(this).attr("data-id");        
                    if(confirm("Are you sure to delete ?")){
                      $.ajax({
                          type: 'POST',
                          url: '<?php //echo base_url('staff/delete');?>',
                          data: 'id=' + Id,
                          success: function(data) {                      
                            window.location.reload();
                          }
        
                      })
                    }
                  });
              });
          </script> -->
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
                      url: '<?php echo base_url('staff/delete');?>',
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