<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public $viewData = array();
    public $loggedInAdmin = array();
    private $upload_data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_model');  // load the admin model
        $this->load->model('admin_model');  // load the admin model
        $this->viewData['data'] = array();
        $this->loggedInId = trim(getSessionUserData("id"));  //output=0/1
        if (getSessionUserData("logged_in") == FALSE && getSessionUserData("id") == "" && empty(getSessionUserData("id"))) 
        {
            // if user is not login then it will rediret to the login page of panel
            redirect(base_url(''));  
        }
        $role_type = trim(getSessionUserData("role_type"));
        $rolename = getAdminRoleInfo($role_type, $table = "roles");  // geting the user role
        if($rolename["role_id"] != 1)
        {
            redirect(base_url("dashboard"));
        }
    }


function admin_setting()
    {
       $this->load->helper("basic_helper");
       isLoggedIn();
       $userid = $this->loggedInId;
       $aminDetails = $this->admin_model->_profile($userid);
       if($_POST)
       {

        $this->set_rules('Settings');



        if ($this->form_validation->run() !== FALSE) {

            if($_FILES["logo"]["size"] == 0)
            {
                
                $logoicon = trim(_inputPost("old_logo"));
            }
            else
            {
                /*$logoicon = base_url()."assets/uploads/logo/".$this->upload_data['file_name'];*/
                $logoicon = $this->upload_data['file_name'];
            }


             if($_FILES["favicon"]["size"] == 0)
            {
                
                $favicon = trim(_inputPost("old_favicon"));
            }
            else
            {
                /*$favicon = base_url()."assets/uploads/logo/".$this->upload_data['file_name'];*/
                $favicon = $this->upload_data['file_name'];
            }

        $array = array(
            "logo" => $logoicon,
            "favicon" => $favicon,
            "application_name" => trim(_inputPost("application_name")),
            "timezone" => trim(_inputPost("timezone")),
            "currency" => trim(_inputPost("currency")),
            "copyright" => trim(_inputPost("copyright")),
            "email_from" => trim(_inputPost("email_from")),
            "smtp_host" => trim(_inputPost("smtp_host")),
            "smtp_post" => trim(_inputPost("smtp_port")),
            "smtp_user" => trim(_inputPost("smtp_user")),
            "smtp_password" => trim(_inputPost("smtp_password")),
            "facebook" => trim(_inputPost("facebook")),
            "twitter" => trim(_inputPost("twitter")),
            "youtube" => trim(_inputPost("youtube")),
            "inkedin" => trim(_inputPost("linkedin")),
            "instagram" => trim(_inputPost("instagram")),

            "sms_url" => trim(_inputPost("sms_url")),
            "sms_username" => trim(_inputPost("sms_username")),
            "sms_password" => trim(_inputPost("sms_password")),

            "site_key" => trim(_inputPost("site_key")),
            "secret_key" => trim(_inputPost("secret_key")),
            "language" => trim(_inputPost("language")),

        );

    
           if ($this->admin_model->_update('settings',  $array, array('id' => 0))) {
                  
            setSessionFlashData('success', 'Congrats! You have successfully updated your Profile.');
                    
            redirect(base_url("admin-setting"));

               }
           else
                {
                   setSessionFlashData('error', 'Whoops! Some Problem Is Occured.');
                    redirect(base_url('admin-setting'));
               }
           }
           else
           {
                setSessionFlashData('error', validation_errors());
                redirect(base_url('admin-setting'));
           }
       }
      

       $this->viewData['title'] = "Website Setting";
       $this->viewData['aminDetails'] = $aminDetails;
       $this->viewData['setting'] = $this->setting_model->get("id", 0);
       $this->load->view('Authentication/Settings', $this->viewData);

    }



    function set_rules($option)
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="has-error"><span class="help-block">', '</span></div>');
        if ($option == 'login') {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
        }
        if ($option == 'ChangePassword') {
            $this->form_validation->set_rules('OldPassword', 'Old Password', 'trim|required');
            $this->form_validation->set_rules('NewPassword', 'New Password', 'trim|required');
            $this->form_validation->set_rules('ConfirmPassword', 'Confirm Password', 'trim|required|matches[NewPassword]');
        }

         if ($option == 'updateprofile') {
            $this->form_validation->set_rules('name', 'name', 'trim|required');
            $this->form_validation->set_rules('email', 'email id', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'phone', 'trim|required|min_length[10]|max_length[10]');
            $this->form_validation->set_rules('AdminImage', 'Profile Image', 'callback_handle_upload');
        }

        if ($option == 'Settings') {
            $this->form_validation->set_rules('application_name', 'Application name', 'trim|required|min_length[5]|max_length[20]|alpha_numeric_spaces');
            $this->form_validation->set_rules('timezone', 'Timezone', 'trim|required');
            $this->form_validation->set_rules('currency', 'Currency', 'trim|required');
            $this->form_validation->set_rules('copyright', 'Copyright', 'trim|required');
            $this->form_validation->set_rules('email_from', 'Email From', 'trim|required|valid_email');
            $this->form_validation->set_rules('smtp_host', 'Smtp Host', 'trim|required');

            $this->form_validation->set_rules('smtp_port', 'Smtp Port', 'trim|required|integer');
            $this->form_validation->set_rules('smtp_user', 'Smtp User', 'trim|required');
            $this->form_validation->set_rules('smtp_password', 'Smtp Password', 'trim|required');
            $this->form_validation->set_rules('sms_url', 'Sms Url', 'trim|required|valid_url');
            $this->form_validation->set_rules('sms_username', 'Sms Username', 'trim|required');
            $this->form_validation->set_rules('sms_password', 'Sms Password', 'trim|required');
            $this->form_validation->set_rules('logo', 'Logo Image', 'callback_handle_upload');
            $this->form_validation->set_rules('favicon', 'Favicon Image', 'callback_handle_favicon_upload');
        }
    }



    function handle_upload()
    {  
        if (isset($_FILES['logo']) && !empty($_FILES['logo']['name'])) {

            $imgInfo = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $rand_val = date('YMDHIS') . rand(11111, 99999);
            $filename = md5($rand_val) . "." . $imgInfo;
            $_FILES['logo']['name'] = $filename;

            $config['upload_path'] = "assets/uploads/logo";
            $config['allowed_types'] = "gif|jpg|jpeg|png";
            $config['max_size'] = "204800";
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('logo')) {
               
                // set a $_POST value for 'image' that we can use later
                $this->upload_data = $this->upload->data();
                return true;
            } else {
                
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('handle_upload', $this->upload->display_errors());
                return false;
            }
        }
    }

        function handle_favicon_upload()
    {  
        if (isset($_FILES['favicon']) && !empty($_FILES['favicon']['name'])) {

            $imgInfo = pathinfo($_FILES['favicon']['name'], PATHINFO_EXTENSION);
            $rand_val = date('YMDHIS') . rand(11111, 99999);
            $filename = md5($rand_val) . "." . $imgInfo;
            $_FILES['favicon']['name'] = $filename;

            $config['upload_path'] = "assets/uploads/logo";
            $config['allowed_types'] = "gif|jpg|jpeg|png|ico";
            $config['max_size'] = "102400";
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('favicon')) {
               
                // set a $_POST value for 'image' that we can use later
                $this->upload_data = $this->upload->data();
                return true;
            } else {
                
                // possibly do some clean up ... then throw an error
                $this->form_validation->set_message('handle_favicon_upload', $this->upload->display_errors());
                return false;
            }
        }
    }

    

}