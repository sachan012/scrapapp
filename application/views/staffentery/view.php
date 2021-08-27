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
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url('staffentery/index/all')?>">Vehicle Entry</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>   
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">            
            <!-- /.card -->
            <div class="card card-secondary mt-4">
              <div class="card-header">
                <h3 class="card-title">Vehocle Entry Details</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <?php //echo "<pre>";print_r($entery_details);die;?>
                  
              <table class="table" id="myTable">                    
                    <tbody>                                    
                    <tr>
                        <th>Vehicle Registration No</th>
                        <td><?php echo $entery_details['vehicle_registration'] ;?></td>
                    </tr>

                    <tr>
                        <th>Driver Name</th>
                        <td><?php echo $entery_details['driver'] ;?></td>
                    </tr>

                    <tr>
                        <th>Entry Time</th>
                        <td><?php echo $entery_details['time_of_entry'] ;?></td>
                    </tr>

                    <tr>
                        <th>Entry Weight</th>
                        <td><?php echo $entery_details['weight'] ;?></td>
                    </tr>

                    <tr>
                        <th>Exit Time</th>
                        <td><?php echo $entery_details['time_of_exit'] ;?></td>
                    </tr>

                    <tr>
                        <th>Exit weight</th>
                        <td><?php echo $entery_details['weight_after'] ;?></td>
                    </tr>

                    <tr>
                        <th>More Details</th>
                        <td><?php echo $entery_details['scrape_dealer'] ;?></td>
                    </tr>                    
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
           
            <!-- /.card -->
          </div>
          <!-- /.col -->
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
</body>
</html>





