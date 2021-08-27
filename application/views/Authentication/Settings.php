<?php $this->load->view('includes/header_script', $data); ?>

<style type="text/css">
  
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    color: #fff;
    background-color: #28a745!important;
}
  
</style>
<body class="hold-transition sidebar-mini">

<!-- Main Wrapper Start -->
<div class="wrapper">

   <!-- Navbar -->
  <?php $this->load->view('includes/header', $data); ?>
  <!-- /.navbar -->


  <!-- Sideabr -->

  
    

<!-- Main Sidebar Container -->
 <?php $this->load->view('includes/sidebar'); ?>

<script>
  $("#general_settings").addClass('menu-open');
  $("#general_settings > a").addClass('active');
</script>
  
  <!-- / .Sideabr -->
<!-- Content Wrapper. Contains page content -->



<div class="content-wrapper">

 <?php $this->load->view('includes/msg_alert'); 

//print_r(validation_errors());

 ?>
    <!-- Main content -->

    <section class="content">

        <div class="card card-default color-palette-bo">

           <!--  <div class="card-header">

              <div class="d-inline-block">

                  <h3 class="card-title"> <i class="fa fa-plus"></i>

                  General Settings </h3>

              </div>

            </div> -->

            <div class="card-body">   

                 <!-- For Messages -->

                
    <!--print error messages-->
    
    <!--print custom error message-->
    
    <!--print custom success message-->
    


                <form action="<?php echo base_url();?>setting/admin_setting" enctype="multipart/form-data" method="post" accept-charset="utf-8">

                <!-- Nav tabs -->

                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                  <li class="nav-item">

                    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#main" role="tab" aria-controls="main" aria-selected="true">General Setting</a>

                  </li>

                  <li class="nav-item">

                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#email" role="tab" aria-controls="email" aria-selected="false">Email Setting</a>

                  </li>


                   <li class="nav-item">

                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#social" role="tab" aria-controls="email" aria-selected="false">Social Setting</a>

                  </li>

                   <li class="nav-item">

                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#sms" role="tab" aria-controls="reCAPTCHA" aria-selected="false">Sms Setting</a>

                  </li>


                  <li class="nav-item">

                    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#reCAPTCHA" role="tab" aria-controls="reCAPTCHA" aria-selected="false">Google reCAPTCHA</a>

                  </li>

                </ul>
                <hr>



                 <!-- Tab panes -->

                <div class="tab-content">



                    <!-- General Setting -->

                    <div role="tabpanel" class="tab-pane active" id="main">

                      <div class="row">



                            <div class="col-sm-6 col-md-6">

                              <div class="form-group">

                           <label class="control-label">Logo</label><br/>

                           
                              <p><img src="<?php if(!empty($setting["logo"])) { echo base_url()."assets/uploads/logo/".$setting["logo"]; } ?>" class="logo" width="150"></p> 

                           
                           <input type="file" name="logo" accept=".png, .jpg, .jpeg, .gif, .svg">

                           <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>

                           <input type="hidden" name="old_logo" value="<?php if(!empty($setting["logo"])) { echo $setting["logo"]; } ?>">

                       </div>

                        </div>

                        <div class="col-sm-6 col-md-6">


                       <div class="form-group">

                            <label class="control-label">Favicon (25*25)</label><br/>

                            
                               <p><img src="<?php if(!empty($setting["favicon"])) { echo base_url()."assets/uploads/logo/".$setting["favicon"]; } ?>" class="favicon"></p> 

                           
                           <input type="file" name="favicon" accept=".png, .jpg, .jpeg, .gif, .svg, ico">

                           <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>

                           <input type="hidden" name="old_favicon" value="<?php if(!empty($setting["favicon"])) { echo $setting["favicon"]; } ?>">

                       </div>

                        </div>





                      </div>


                    

                        <div class="form-group">

                            <label class="control-label">Application Name</label>

                            <input type="text" class="form-control" name="application_name" placeholder="application name" value="<?php if(!empty($setting["application_name"])) { echo $setting["application_name"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">Timezone</label>

                            <input type="text" class="form-control" name="timezone" value="<?php if(!empty($setting["timezone"])) { echo $setting["timezone"]; } ?>">

                            <!-- <a href="http://php.net/manual/en/timezones.php" target="_blank">Timeszones</a> -->

                        </div>

                        <div class="form-group">

                            <label class="control-label">Currency</label>

                            <input type="text" class="form-control" name="currency" value="<?php if(!empty($setting["currency"])) { echo $setting["currency"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">Copyright</label>

                            <input type="text" class="form-control" name="copyright"

                            value="<?php if(!empty($setting["copyright"])) { echo $setting["copyright"]; } ?>"

                            >

                        </div>

                    </div>



                    <!-- Email Setting -->

                    <div role="tabpanel" class="tab-pane" id="email">

                        <div class="form-group">

                            <label class="control-label">Email From/ Reply to</label>

                            <input type="text" class="form-control" name="email_from" value="<?php if(!empty($setting["email_from"])) { echo $setting["email_from"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">SMTP Host</label>

                            <input type="text" class="form-control" name="smtp_host" value="<?php if(!empty($setting["smtp_host"])) { echo $setting["smtp_host"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">SMTP Port</label>

                            <input type="text" class="form-control" name="smtp_port" value="<?php if(!empty($setting["smtp_post"])) { echo $setting["smtp_post"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">SMTP User</label>

                            <input type="text" class="form-control" name="smtp_user" value="<?php if(!empty($setting["smtp_user"])) { echo $setting["smtp_user"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">SMTP Password</label>

                            <input type="password" class="form-control" name="smtp_password" value="<?php if(!empty($setting["smtp_password"])) { echo $setting["smtp_password"]; } ?>">

                        </div>

                    </div>



                    <!-- Social Media Setting -->

                    <div role="tabpanel" class="tab-pane" id="social">

                        <div class="form-group">

                            <label class="control-label">Facebook</label>

                            <input type="text" class="form-control" name="facebook" value="<?php if(!empty($setting["facebook"])) { echo $setting["facebook"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">Twitter</label>

                            <input type="text" class="form-control" name="twitter" value="<?php if(!empty($setting["twitter"])) { echo $setting["twitter"]; } ?>">

                        </div>

                        <!-- <div class="form-group">

                            <label class="control-label">Google Plus</label>

                            <input type="text" class="form-control" name="google_link" placeholder="" value="https://google.com">

                        </div> -->

                        <div class="form-group">

                            <label class="control-label">Youtube</label>

                            <input type="text" class="form-control" name="youtube" value="<?php if(!empty($setting["youtube"])) { echo $setting["youtube"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">LinkedIn</label>

                            <input type="text" class="form-control" name="linkedin" value="<?php if(!empty($setting["inkedin"])) { echo $setting["inkedin"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">Instagram</label>

                            <input type="text" class="form-control" name="instagram" value="<?php if(!empty($setting["instagram"])) { echo $setting["instagram"]; } ?>">

                        </div>

                    </div>





                    <!-- Sms Setting -->

                    <div role="tabpanel" class="tab-pane" id="sms">

                        <div class="form-group">

                            <label class="control-label">Sms Url</label>

                            <input type="text" class="form-control" name="sms_url" value="<?php if(!empty($setting["sms_url"])) { echo $setting["sms_url"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">Username</label>

                            <input type="text" class="form-control" name="sms_username" value="<?php if(!empty($setting["sms_username"])) { echo $setting["sms_username"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">Password</label>

                            <input type="text" class="form-control" name="sms_password" value="<?php if(!empty($setting["sms_password"])) { echo $setting["sms_password"]; } ?>">

                        </div>

                    
                    </div>



                    <!-- Google reCAPTCHA Setting-->

                    <div role="tabpanel" class="tab-pane" id="reCAPTCHA">

                        <div class="form-group">

                            <label class="control-label">Site Key</label>

                            <input type="text" class="form-control" name="site_key" value="<?php if(!empty($setting["site_key"])) { echo $setting["site_key"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">Secret Key</label>

                            <input type="text" class="form-control" name="secret_key" value="<?php if(!empty($setting["secret_key"])) { echo $setting["secret_key"]; } ?>">

                        </div>

                        <div class="form-group">

                            <label class="control-label">Language</label>

                            <input type="text" class="form-control" name="language" value="<?php if(!empty($setting["language"])) { echo $setting["language"]; } ?>">

                            <!-- <a href="https://developers.google.com/recaptcha/docs/language" target="_blank">https://developers.google.com/recaptcha/docs/language</a> -->

                        </div>

                    </div>



                </div>



                <div class="box-footer">

                    <input type="submit" name="submit" value="Save Changes" class="btn btn-success pull-right">

                </div>  

                </form>
            </div>

        </div>

    </section>

</div>



<script>

    $("#setting").addClass('active');

    $('#myTabs a').click(function (e) {

     e.preventDefault()

     $(this).tab('show')

 })

</script>

<?php $this->load->view('includes/footer'); ?>

  
</div>
<!-- ./wrapper -->

<?php $this->load->view('includes/footer_scripts'); ?>
</body>
</html>
