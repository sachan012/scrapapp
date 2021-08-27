<?php

$this->db->select("*")->from("settings");
$this->db->where("id", 0);
$query = $this->db->get();
$settingResult = $query->row_array();

?>
<footer class="main-footer">
<!--     <strong><?php echo $settingResult["copyright"];?> <a href="http://adminlte.io">finApp</a>.</strong>
    All rights reserved. -->


    <strong><?php echo $settingResult["copyright"];?></strong>

    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>

      <div class="float-right d-none d-sm-inline-block">
      <b style="margin-right: 10px; color: #007bff;">Execution Time &nbsp; : &nbsp;<?php echo $this->benchmark->elapsed_time();?></b>
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->