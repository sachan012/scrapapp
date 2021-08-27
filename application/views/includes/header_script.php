<?php
  $this->db->select("*")->from("settings");
  $this->db->where("id", 1);
  $query = $this->db->get();
  $settingResult = $query->row_array();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- icon -->
  <link rel="shortcut icon" href="<?php echo base_url()."assets/uploads/logo/".$settingResult["favicon"];?>" type="image/x-icon">
  <link rel="icon" href="<?php echo base_url()."assets/uploads/logo/".$settingResult["favicon"];?>" type="image/x-icon"> 
  <!-- <link rel="stylesheet" href="<?php echo assets_url('plugins','bootstrap-datepicker/css/bootstrap-datepicker.min.css');?>"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo assets_url('plugins','fontawesome-free/css/all.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo assets_url('plugins','tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo assets_url('plugins','icheck-bootstrap/icheck-bootstrap.min.css'); ?>">  
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo assets_url('dist','css/adminlte.min.css'); ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo assets_url('plugins','overlayScrollbars/css/OverlayScrollbars.min.css'); ?>">
  <!-- Daterange picker -->
  <!-- <link rel="stylesheet" href="<?php echo assets_url('plugins','daterangepicker/daterangepicker.css'); ?>"> -->
  <!-- summernote -->
   <link rel="stylesheet" href="<?php echo assets_url('plugins','summernote/summernote-bs4.css'); ?>"> 
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo assets_url('plugins','sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
  <link href= 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'> 
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <link rel="stylesheet" href="<?php echo assets_url('dist','css/jquery.timepicker.min.css'); ?>">

  <style type="text/css">    
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
      z-index: 2;
      color: #fff;
      cursor: default;
      background-color: #337ab7;
      border-color: #337ab7;
    }

    .pagination > li > a {
      border-color: #dee5e7;
    }

    .pagination-sm > li > a,
    .pagination-sm > li > span {
      padding: 5px 10px;
      font-size: 12px;
    }

    .pagination > li > a,
    .pagination > li > span {
      position: relative;
      float: left;
      padding: 6px 12px;
      margin-left: -1px;
      line-height: 1.42857143;
      color: #337ab7;
      text-decoration: none;
      background-color: #fff;
      border: 1px solid #ddd;
    }

    .pagination-sm > li > a,
    .pagination-sm > li > span {
      padding: 5px 10px;
      font-size: 12px;
    }

    .pagination > li > a,
    .pagination > li > span {
      position: relative;
      float: left;
      padding: 6px 12px;
      margin-left: -1px;
      line-height: 1.42857143;
      color: #337ab7;
      text-decoration: none;
      background-color: #fff;
      border: 1px solid #ddd;
    }
    
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
  <title>Admin Panel | <?php echo ucwords(trim(($title)));?></title>
  <title>RaS E-Tender</title>
    <script>
        var BASE_URL = "<?php echo base_url(); ?>";
    </script>
</head>
<!-- <body class="hold-transition sidebar-mini layout-fixed"> -->