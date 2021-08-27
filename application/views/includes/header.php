<?php
$role_type = trim(getSessionUserData("role_type"));
$rolename = getAdminRoleInfo($role_type, $table = "roles");  // geting the user role

$loginUserName = trim(getSessionUserData("name"));
if($loginUserName == ""  && empty($loginUserName))
{
  redirect(base_url("logout"));  // getting the login user name with trim
}

?>

<!-- css for managing the logout dropdown -->
<style type="text/css">  
    /*.navbar-right
    {
        margin-right: 15px!important;
    }*/
    .dropstyle
    {
            padding: 2px 0px 0px 1px;
    }



</style>


<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="border-bottom: 5px solid #249946;">
    
<!-- <nav class="main-header navbar navbar-expand navbar-white navbar-light"> -->
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
       <li class="breadcrumb-item" style="padding-top: 3px;"><a href="<?php echo base_url("dashboard");?>">Home</a></li>
       <li class="breadcrumb-item active" style="padding-top: 3px;"><?php echo ucwords(trim(($title)));?></li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
    
<ul class="nav navbar-nav navbar-right">
    <li class="dropdown" style="width: 10rem;">
        <a style="color: black" href="#" data-toggle="dropdown" class="dropdown-toggle clear" data-toggle="dropdown">
              <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
              
                    <img alt="Admin Profile Pic" height="40" width="40" class="img-full" src="<?php echo assets_url('uploads','a0.jpg'); ?>">
      
                <i class="on md b-white bottom"></i>
              </span>
            <span class="hidden-sm hidden-md" style="font-size: 14px;"><?php echo ucwords($loginUserName); ?></span> <b class="caret"></b>
        </a>

        <!-- dropdown -->
        <ul class="dropdown-menu animated fadeInRight w" style="margin-top: 10px;min-width: 12rem;padding-left:10px;padding-right:5px;" >
           <li class="dropstyle">
                <a style="color: black;" title="Admin Settings" href="<?php echo base_url('profile'); ?>">
                    <span><i class="fas fa-user-circle"></i>&nbsp;</span> Profile
                </a>
            </li>
            <hr>
            <li class="dropstyle">
                <a style="color: black;" title="Admin Change Password" href="<?php echo base_url('change-password'); ?>">
                    <span><i class="fa fa-eye icon m-r-sm text-success-dker"></i>&nbsp;</span> Change Password</a>
            </li>
            <hr>

 <!--   <?php if(!empty($rolename["role_id"]) && $rolename["role_id"] == 1) { ?>
            <li class="dropstyle">
                <a style="color: black;" title="Admin Change Password" href="<?php echo base_url('admin-setting'); ?>">
                    <span><i class="fa fa-cogs icon m-r-sm text-success-dker"></i>&nbsp;</span> Setting</a>
            </li>
            <hr>
  <?php } ?>  -->      
            <li class="dropstyle">
                <a style="color: black;" href="<?php echo base_url('logout'); ?>" title="Admin Logout"><span><i class="fa fa-power-off icon m-r-sm text-danger-dker"></i>&nbsp;</span> Logout</a>
            </li>

        </ul>
        <!-- / dropdown -->
    </li>
</ul>

    </ul>
  </nav>