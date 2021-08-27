<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller
{
    public $viewData = array();
    public $loggedInAdmin = array();
    private $upload_data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');  // load the admin model
        $this->viewData['data'] = array();
        $this->loggedInId = trim(getSessionUserData("id"));
    }

//log the user in
function login()
    {
      if (getSessionUserData("logged_in") == TRUE && !empty(getSessionUserData("id"))) 
        {
            // if session is login then it will move to dashboard
            redirect(base_url('dashboard'));  
        }

        $this->viewData['title'] = "Admin Login";
        
        $this->set_rules('login');
        if ($this->form_validation->run() !== FALSE) {
            $ip = $this->input->ip_address();
            $client = $_SERVER['HTTP_USER_AGENT'];
            $remember = $this->input->post('remember') ? TRUE : FALSE;
            // get user from database
            $user = $this->admin_model->get('username', $this->input->post('username'));
            
            if ($user) {

              // checking the account is active or not if not then it will go to the login page
              if($user["status"] != "active")
                {
                    setSessionFlashData('error', 'Whoops! Account Is Block .');
                    redirect(base_url()); // sending back to the login page
                }

                // compare passwords
                if (!in_array( $user['role_type'], array(1,2,3,4,5,6))) {

                    setSessionFlashData('error', 'This Account Or Role Type Is Not Exist');
                    redirect(base_url()); // sending back to the login page
                } else {

                    if(md5(trim($this->input->post('password'))) === trim($user['password']))
                    {
                        $userInfoInSession = array(
                                            'id' => trim($user['id']),
                                            'username' => trim($user['username']),
                                            'name' => trim($user['name']),
                                            'email' => trim($user['email']),
                                            'status' => trim($user['status']),
                                            'role_type' => trim($user['role_type']),
                                            'logged_in' => TRUE
                                         );

                        $this->session->set_userdata($userInfoInSession);

                        //after success login user entry will update with some entries

                         $this->admin_model->_update('admins', array('last_login' => set_local_to_gmt(), 'ip_address' => $ip, "login_browser"=>$client), array('id' => $user['id']));

                         setSessionFlashData('success', 'Great! You have successfully logged in.');
                        
                        redirect(base_url('dashboard'));
                    }
                    else
                    {
                        setSessionFlashData('error', 'Whoops! Invalid access.');
                        redirect(base_url()); // sending back to the login page
                    }
                }
            } else {
                setSessionFlashData('error', 'Whoops! Invalid access.');
                redirect(base_url()); // sending back to the login page
            }
        }

    $this->load->view('Authentication/login', $this->viewData);
    }

    //log the user out
    function logout()
    {
        $userInfoInSession = array(
                            'id' => "",
                            'username' =>"",
                            'email' => "",
                            'status' => "",
                            'role_type' => "",
                            'logged_in' => FALSE
                        );
    // it will set the all session data "" (null or empty)
    $this->session->set_userdata($userInfoInSession); 
    // redirect to the login page of panel
    redirect(base_url(''));  
    }


    //change password

    function change_password()
    {
        isLoggedIn();
        $this->set_rules('ChangePassword');
        if ($this->form_validation->run($this) !== FALSE) {

            $OldPasswordPlane = $this->input->post('OldPassword');
            $OldPassword = md5($OldPasswordPlane);

            $NewPasswordPlane = $this->input->post('NewPassword');
            $NewPassword = md5($NewPasswordPlane);

            $user = $this->admin_model->get('id', $this->loggedInId);
        
        if(trim($user["password"]) === $OldPassword) // check the user current password
        {

             if ($this->admin_model->_update('admins', array('updated_at' => set_local_to_gmt(), 'password' => $NewPassword), array('id' => $this->loggedInId))) {
              
                setSessionFlashData('success', 'Congrats! You have successfully updated your Admin Panel password. Please login with new Password');
                  $this->logout();
                redirect(base_url("change-password"));
            } else {
                setSessionFlashData('error', 'Whoops! Seems like some thing technical problem occurred. Please try later.');
                redirect(base_url('change-password'));
            }
        }
        else
        {
             setSessionFlashData('error', 'Whoops! Old Password Is Wrong.');
                redirect(base_url('change-password'));
        }
  
        }
        $this->viewData['title'] = "Change Password";
        $this->load->view('Authentication/ChangePassword', $this->viewData);
    }



    function profile()
    {
       isLoggedIn();
       $userid = $this->loggedInId;
       $aminDetails = $this->admin_model->_profile($userid);
       if($_POST)
       {
        $this->set_rules('updateprofile');
        
        if ($this->form_validation->run($this) !== FALSE) {

            if($_FILES["AdminImage"]["size"] == 0)
            {
                
                $icon = $aminDetails['profileicon'];
            }
            else
            {
                $icon = $this->upload_data['file_name'];
            }

         $details = array("name"=>trim(_inputPost("name")),"email"=>trim(_inputPost("email")),"phone"=>trim(_inputPost("phone")), "address"=>trim(_inputPost("address")), "profileicon"=>$icon);

            $userid = $this->loggedInId;
           if ($this->admin_model->_update('admins',  $details, array('id' => $this->loggedInId))) {
                  
            setSessionFlashData('success', 'Congrats! You have successfully updated your Profile.');
                    
            redirect(base_url("profile"));

               }
           else
                {
                   setSessionFlashData('error', 'Whoops! Some Problem Is Occured.');
                    redirect(base_url('profile'));
               }
           }
       }

       $aminDetails = $this->admin_model->_profile($userid);

       //executed query 
       //select admins.id, admins.name, admins.email, admins.phone, admins.address, admins.status, admins.role_type, roles.roll_name from admins left join roles on admins.role_type = roles.role_id where admins.id = 2

       $this->viewData['title'] = "Profile";
       $this->viewData['aminDetails'] = $aminDetails;
       $this->load->view('Authentication/profile', $this->viewData);

    }


function admin_setting()
    {
       isLoggedIn();
       $userid = $this->loggedInId;
       $aminDetails = $this->admin_model->_profile($userid);
       if($_POST)
       {

        print_r($this->input->post()); die;
        $this->set_rules('updateprofile');
        
        if ($this->form_validation->run($this) !== FALSE) {

            if($_FILES["AdminImage"]["size"] == 0)
            {
                
                $icon = $aminDetails['profileicon'];
            }
            else
            {
                $icon = $this->upload_data['file_name'];
            }

         $details = array("name"=>trim(_inputPost("name")),"email"=>trim(_inputPost("email")),"phone"=>trim(_inputPost("phone")), "address"=>trim(_inputPost("address")), "profileicon"=>$icon);

            $userid = $this->loggedInId;
           if ($this->admin_model->_update('admins',  $details, array('id' => $this->loggedInId))) {
                  
            setSessionFlashData('success', 'Congrats! You have successfully updated your Profile.');
                    
            redirect(base_url("profile"));

               }
           else
                {
                   setSessionFlashData('error', 'Whoops! Some Problem Is Occured.');
                    redirect(base_url('profile'));
               }
           }
       }

       $aminDetails = $this->admin_model->_profile($userid);

       $this->viewData['title'] = "Website Setting";
       $this->viewData['aminDetails'] = $aminDetails;
       $this->load->view('Authentication/Settings', $this->viewData);

    }


    function forgetPassword()
    {
        $this->load->helper("basic_helper");
        $this->viewData['title'] = "Forget Password";
        
        $this->set_rules('forgetPassword');



        if ($this->form_validation->run() !== FALSE) {
            
            $email = $this->input->post('email');
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $email = filter_var($email, FILTER_VALIDATE_EMAIL);

            // get user from database
            $user = $this->admin_model->get('email', $email);
           
            if ($user)
             {
                $name = trim($user["name"]);
                $emailid = trim($user["email"]);
                $NewPasswordPlane = $this->random_strings(7);
                $NewPassword = md5($NewPasswordPlane);


                /*---------------------------------------------*/

                   $expFormat = mktime(
                   date("H"), date("i"), date("s"), date("m") ,date("d")+1, date("Y")
                   );
                   $expDate = date("Y-m-d H:i:s",$expFormat);
                   $key = md5(2418*2+$emailid);
                   $addKey = substr(md5(uniqid(rand(),1)),3,10);
                   $key = $key . $addKey;

                   //$this->db->insert("password_reset_temp", array("email"=>$emailid,"key"=>$key,"expDate"=>$expDate));

                /*---------------------------------------------*/

                if ($this->db->insert("password_reset_temp", array("email"=>$emailid,"key"=>$key,"expDate"=>$expDate)))
                 {

                        $subject = "Scrap Dealer : PASSWORD RECOVERY EMAIL";

                        $output='<p>Dear user,</p>';
                        $output.='<p>Please click on the following link to reset your password.</p>';
                        $output.='<p>-------------------------------------------------------------</p>';


                        $output.='<p><a href='.base_url().'forgot-password-link/'.$key.'/'.$email.' target=_blank">
                        '.base_url().'forgot-password-link/'.$key.'/'.$email.'</a></p>'; 


                        $output.='<p>-------------------------------------------------------------</p>';
                        $output.='<p>Please be sure to copy the entire link into your browser.
                        The link will expire after 1 day for security reason.</p>';
                        $output.='<p>If you did not request this forgotten password email, no action 
                        is needed, your password will not be reset. However, you may want to log into 
                        your account and change your security password as someone may have guessed it.</p>';   
                        $output.='<p>Thanks,</p>';
                        $output.='<p>Scrap Dealer Team</p>';

                        //echo  $output; die;

                       /* $mailContent = "<p>Dear ".ucwords($name)." <br /> <br /> you have succesfully reset your password.</p>
                          <p>Your new password is : <b>".$NewPasswordPlane."</b><br/><strong>Help Desk</strong> <br /> 011 019 3100 <br /> <a href='mailto:help.cs@maadima.com'>help.cs@maadima.com</a> &nbsp;&nbsp;</p>";*/

                           $mailContent = $output;

                           //echo $mailContent; die;

                        $mailTo = $emailid;
                        $this->send_mail( $mailTo,$subject, $mailContent); // forsending pdf to client or admin use

                       
                    setSessionFlashData('success', 'An email has been sent to you with instructions on how to reset your password.');
                    redirect(base_url("forget-password"));
                } 
                else
                 {
                    setSessionFlashData('error', 'Whoops! Seems like some thing technical problem occurred. Please try later.');
                    redirect(base_url('forget-password'));
                 }
             
             }
            else
             {
                setSessionFlashData('error', 'Whoops ! Email Id Is Not Exist.');
                redirect(base_url("forget-password")); // sending back to the login page
             }
        }

      $this->load->view('Authentication/forgetPassword', $this->viewData);
    }


        public function send_mail($to,$subject,$msg){     
        $this->load->library('email');  
        $config = Array(
            'protocol' => 'tls',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 587,
            'smtp_user' => EMAIL,
            'smtp_pass' => PASSWORD,
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
          );
        $this->email->initialize($config);      
        $this->email->set_newline("\r\n");
        $this->email->from(EMAIL, 'Scrap Dealer');      
        $this->email->to($to);
        //$this->email->to('sachan012@gmail.com');
        $this->email->set_mailtype('html');
        $this->email->subject($subject);
        $this->email->message($msg);
        if(!$this->email->send()){
                echo $this->email->print_debugger();
                return false;
        }else{
            return true;
        }

    }


function forgetPasswordlink()
    {
         $this->load->helper("basic_helper");
        $this->viewData['title'] = "Forget Password Reset";
        if($_POST)
        { 
                $this->set_rules('PasswordResetLink');

                if ($this->form_validation->run() !== FALSE) {
                    
                    $password = $this->input->post('password');
                    $cpassword = $this->input->post('cpassword');


                    $key = $this->uri->segment(2);
                    $email = $this->uri->segment(3);


                    $curDate = date("Y-m-d H:i:s");
                    $where = array("email"=>$email,"key"=>$key);
                    $query = $this->db->get_where("password_reset_temp", $where);
                    $result = $query->row_array();

                    if(count($result)>0)
                    {
                        $expDate = $result['expDate'];
                        if ($expDate >= $curDate)
                         {
                                $array = array("password"=>md5($password));
                                //print_r($array); die;
                                $this->db->where("email", $email);
                                if($this->db->update("admins", $array))
                                    {
                                         $this->db->where('key', $key);
                                         $this->db->delete('password_reset_temp');

                                        setSessionFlashData('success', 'Congratulations! Your password has been updated successfully.');
                                        redirect(base_url("forgot-password-link/".$key."/".$email));
                                    }
                                 else
                                    {
                                        setSessionFlashData('error', 'Try again!');
                                        redirect(base_url("forgot-password-link/".$key."/".$email));
                                    }
                         }
                         else
                         {
                            
                           setSessionFlashData('error', 'The link is expired. You are trying to use the expired link which as valid only 24 hours (1 days after request).');
                            redirect(base_url("forgot-password-link/".$key."/".$email));

                         }
                    }
                    else
                    {
                         setSessionFlashData('error', 'The link is invalid/expired. Either you did not copy the correct link from the email, or you have already used the key in which case it is deactivated.');
                         redirect(base_url("forgot-password-link/".$key."/".$email));
                    }
                    
                }
       }

      $this->load->view('Authentication/forgetPasswordReset', $this->viewData);
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
            $this->form_validation->set_rules('FullName', 'Admin Full Name', 'required');
            $this->form_validation->set_rules('AdminImage', 'Profile Image', 'callback_handle_upload');
        }

         if ($option == 'forgetPassword') {
            $this->form_validation->set_rules('email', 'Email id', 'required');
        }

           if ($option == 'PasswordResetLink') {
            $this->form_validation->set_rules('password', 'New Password', 'trim|required');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
        }
    }



    function handle_upload()
    {  
        if (isset($_FILES['AdminImage']) && !empty($_FILES['AdminImage']['name'])) {

            $imgInfo = pathinfo($_FILES['AdminImage']['name'], PATHINFO_EXTENSION);
            $rand_val = date('YMDHIS') . rand(11111, 99999);
            $filename = md5($rand_val) . "." . $imgInfo;
            $_FILES['AdminImage']['name'] = $filename;

            $config['upload_path'] = "assets/uploads/AdminUser";
            $config['allowed_types'] = "gif|jpg|jpeg|png";
            $config['max_size'] = "204800";
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('AdminImage')) {
               
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


    // This function will return a random 
    // string of specified length 
    function random_strings($length_of_string) 
        { 
          
            // String of all alphanumeric character 
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
          
            // Shufle the $str_result and returns substring 
            // of specified length 
            return substr(str_shuffle($str_result),  0, $length_of_string); 
        } 


function sendMail($subject, $mailContent, $mailTo, $mailFromId, $mailFromName, $attachment_file = '')
    {
            require_once(APPPATH."third_party/phpmailer/class.phpmailer.php");
            $CI =& get_instance();
            $account= EMAIL;
            $password= PASSWORD;
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = "ssl://smtp.googlemail.com";
            $mail->SMTPAuth= true;
            $mail->Port = 587;
            $mail->Username= $account;
            $mail->Password= $password;
            $mail->SMTPSecure = 'tls';
            $mail->From = $mailFromId;
            $mail->FromName= $mailFromName;
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $mailContent;
            $mail->addAddress($mailTo);
            if ($attachment_file != '') 
              {
                $mail->AddAttachment($attachment_file);  /* Enables you to send an attachment */
              }
            if(!$mail->send()){
             return true;
            }else{
              return false;
            }
    }
    

}