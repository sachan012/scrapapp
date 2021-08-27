<?php
require APPPATH . '/libraries/REST_Controller.php';  //load the rest controller library.
use Restserver\Libraries\REST_Controller;  // without this line it will give the error.

class User extends REST_Controller {
    
      /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() 
    { 
        
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) 
        {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
         {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }

       parent::__construct();      
       // Load these helper to create JWT tokens
       $this->load->helper(['jwt', 'authorization']); 
       $this->load->helper(array('form', 'url'));
       $this->load->library('form_validation');
       $this->load->model("Api_model");
       $this->load->model("common_model");
       $this->load->helper("basic_helper");
    }


    private function validate_token(){		
        $access_token = $this->input->get_request_header('authorisation');            
        $this->load->model("Api_model");
        if ($access_token == false) {
            $this->return['error'] = 1;
            $this->return['message'] = ERROR_UNAUTHORIZED_ACCESS;
            $this->response($this->return, REST_Controller::HTTP_UNAUTHORIZED);
        }
        $user = $this->Api_model->check_access_web_app_token($access_token);
        //print_r($user);die;
        if (!$user) {
            $this->return['error'] = ERROR_INVALID_ACCESS_TOKEN;
            $this->return['message'] = ERROR_INVALID_ACCESS_TOKEN_MSG;
            $this->response($this->return, REST_Controller::HTTP_OK);
        }
        $this->user_id = $user;        
        return $this->user_id;
    }
	
	    public function generate_access_token()
    {
        //Generate a random string.
        $token = openssl_random_pseudo_bytes(64);

        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);

        //Print it out for example purposes.
        return $token;
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
        $this->email->from(EMAIL, 'Ras E-Tender');		
		$this->email->to($to);		
		$this->email->set_mailtype('html');
		$this->email->subject($subject);
        $this->email->message($msg);
		if(!$this->email->send()){
		        //echo "<pre>";print_r($this->email->print_debugger());die;
               return true;
		}else{
			return true;
		}

    }
    

    public function login_post(){
        try {
            $config =   [
                            [
                                'field' => 'username',
                                'rules' => 'required|trim|valid_email',
                                'errors' => [
                                                'required' => 'Email Id is required'
                                            ],
                            ],
                            [
                                'field' => 'password',
                                'rules' => 'required|trim',
                                'errors' => [
                                                'required' => 'We need valid password'
                                            ],
                            ],
                            
                        ];

            $params = $this->post();
            $this->form_validation->set_data($params);
            $this->form_validation->set_rules($config);

            if($this->form_validation->run()==FALSE)
            {  
                $username_error = $this->form_validation->error('username');  // username validation
                if (!empty($username_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($username_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }    
              
                $password_error = $this->form_validation->error('password');  // username validation
                if (!empty($password_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($password_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }
                
            }
            else
            {
                $username = strip_tags($params["username"]);  // username for login
                $password = strip_tags(md5($params["password"]));  // password for login
                $token = $params["device_token"];  // device_token for notification
                $loginResult = $this->Api_model->_login($username,$password);
                if(!$loginResult)
                {
                    $status = parent::HTTP_OK;
                    $this->return["msg"]="Invalid username Or Password.";
                    $this->return["status"]=0;
                    $this->response($this->return, $status);
                }
                else
                {
                    $status = $loginResult["status"];
                    if($status == 0)
                    {
                        $status = parent::HTTP_OK;
                        $this->return["msg"]="Admin approval is pending now. Plese conatct to adminstrator.";
                        $this->return["status"]=0;
                        $this->response($this->return, $status);
                    }
                    else
                    {   
                        /*---- check the device token and storation -----*/
                        $params['access_token'] = $this->generate_access_token();
                        $access_token = $params['access_token'];
                        //echo $access_token;die;                       
                            $this->db->set("access_token", $access_token);
                            $this->db->where("email", $username);
                            $this->db->update("users");                        

                        if($token)
                        {
                            $array = array("device_token"=>$token, "last_login"=>date("Y-m-d H:i:s"));
                            $this->db->where("email", $username);
                            $this->db->update("users", $array);
                        }

                        // Create a token from the user data and send it as reponse
                        $token = AUTHORIZATION::generateToken(['username' => $username, 'password'=>$password]);
                        //echo $token; die;
                        $loginResponse = $this->Api_model->_login($username,$password);
                        //echo "<pre>";print_r($loginResponse);die;
                        unset($loginResponse["device_token"]);
                        $loginResponse["token"]=$token;
                        $status = parent::HTTP_OK;
                        $this->return["msg"]="Login successfully.";
                        $this->return["status"]=1;
                        $this->return["data"]=$loginResponse;
                        $this->response($this->return, $status);
                    }
                }

            }
        } //try
        catch(Exception $e) 
            { 
                log_message('error', "\n Exception Caught", $e->getMessage());
                $status = parent::HTTP_OK;
                $this->return["status"]=0;
                $this->return["msg"]= $e->getMessage();
                $this->response($this->return, $status);
            }  
    }


  function  registration_post()
    {
        try 
        {
         $config = [
                        [
                            'field' => 'fullname',
                            'rules' => 'required|trim',
                            'errors' => [
                                    'required' => 'Full Name is Required'
                            ],
                        ],

                        [
                            'field' => 'companyname',
                            'rules' => 'required|trim',
                            'errors' => [
                                    'required' => 'Company Name is Required'
                            ],
                        ],


                        [
                            'field' => 'email',
                            'rules' => 'required|trim|valid_email|is_unique[users.email]',
                            'errors' => [
                                    'required' => 'Email Id is required.',
                                    'is_unique'     => 'This %s already exists.'
                            ],
                        ],
                        [
                            'field' => 'phone',
                            'rules' => 'required|trim|integer',
                            'errors' => [
                                    'required' => 'PHONE NUMBER is required.'
                            ],
                        ],

                        [
                                    'field' => 'gst',
                                    'rules' => 'required|trim|is_unique[users.gst_no]',
                                    'errors' => [
                                            'required' => 'GST NUMBER is required.',
                                            'is_unique'     => 'This %s already exists.Enter Different GST NUMBER.'
                                    ],
                        ],

                                [
                                    'field' => 'pan',
                                    'rules' => 'required|trim|is_unique[users.pan_no]|regex_match[/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/]',
                                    'errors' => [
                                            'required' => 'PAN NUMBER is required.',
                                            'is_unique'     => 'This %s already exists.Enter Different PAN NUMBER.'
                                    ],
                        ],
                        
                        [
                                    'field' => 'address',
                                    'rules' => 'required|trim',
                                    'errors' => [
                                            'required' => 'Address field is required.'
                                    ],
                        ],

                        [
                                    'field' => 'password',
                                    'rules' => 'required|trim|min_length[6]',
                                    'errors' => [
                                            'required' => 'Enter Secure Password.'
                                    ],
                        ],
                        [
                                    'field' => 'cpassword',
                                    'rules' => 'required|trim|matches[password]',
                                    'errors' => [
                                            'required' => 'We need a confirm password'
                                    ],
                        ],
                     ];

            $params = $this->post();
            $this->form_validation->set_data($params);
            $this->form_validation->set_rules($config);
            if($this->form_validation->run()==FALSE)
            {  

                $fullname_error = $this->form_validation->error('fullname');  // username validation
                if (!empty($fullname_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($fullname_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }


                $companyname_error = $this->form_validation->error('companyname');  // username validation
                if (!empty($companyname_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($companyname_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }

                $email_error = $this->form_validation->error('email');  // device validation
                if (!empty($email_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($email_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }

                $phone_error = $this->form_validation->error('phone');  // device validation
                if (!empty($phone_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($phone_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }

                $gst_error = $this->form_validation->error('gst');  // device validation
                if (!empty($gst_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($gst_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }

                $pan_error = $this->form_validation->error('pan');  // device validation
                if (!empty($pan_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($pan_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }

                $address_error = $this->form_validation->error('address');  // device validation
                if (!empty($address_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($address_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }

                $password_error = $this->form_validation->error('password');  // device validation
                if (!empty($password_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($password_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }

                $cpassword_error = $this->form_validation->error('cpassword');  // device validation
                if (!empty($cpassword_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($cpassword_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }
            }   // validation part
            else
            {   
                
                $userarray["fullname"]   =  ucwords($params["fullname"]);
                $userarray["email"]   =  strtolower($params["email"]);
                $userarray["phone"]   =  trim($params["phone"]); 
                $userarray["password"]   = md5(trim($params["password"])); 
                $userarray["address"]   =  ucwords($params["address"]); 
                $userarray["company_name"]   =  ucwords($params["companyname"]); 
                $userarray["pan_no"]   =  strtoupper($params["pan"]); 
                $userarray["gst_no"]   =  strtoupper($params["gst"]);
                $userarray["status"]   =  0;
                $checkEmailExistence = $this->Api_model->email_exists("email", trim($params["email"]));
                if($checkEmailExistence > 0)
                {
                    $status = parent::HTTP_OK;
                    $this->return["status"]=0;
                    $this->return["msg"]="This email id exist allready.";
                    $this->response($this->return, $status);
                }else{ 
                        $lastuserid = $this->Api_model->add_user($userarray);
                        if($lastuserid)
                        {
                            $getUserDetails['getUserDetails'] = $this->Api_model->get("id", $lastuserid);                          
                            $to = $getUserDetails['getUserDetails']['email'];                        
                            $subject = 'Registration Confirmation Mail';
                            $msg = $this->load->view('email/registration_mailer',$getUserDetails,true);
                            $this->send_mail($to,$subject,$msg);
                            unset($userarray["status"]);  
                            $status = parent::HTTP_OK;
                            $this->return["status"]=1;
                            $this->return["data"]=$userarray;
                            $this->return["msg"]="You have been successfully registered!. Please wait for the admin approval.";
                            $this->response($this->return, $status);
                        }
                    }

              }
        } //try
        catch(Exception $e) 
            { 
                log_message('error', "\n Exception Caught", $e->getMessage());
                $status = parent::HTTP_OK;
                $this->return["status"]=0;
                $this->return["msg"]= $e->getMessage();
                $this->response($this->return, $status);
            }  
    }

    function forgotpassword_post(){
        try {
            $config =   [
                            [
                                'field' => 'email',
                                'rules' => 'required|trim|valid_email',
                                'errors' => [
                                                'required' => 'Email Id is required'
                                            ],
                            ],                            
                            
                        ];

            $params = $this->post();
            $this->form_validation->set_data($params);
            $this->form_validation->set_rules($config);

            if($this->form_validation->run()==FALSE)
            {  
                $username_error = $this->form_validation->error('email');  // username validation
                if (!empty($username_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($username_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }                  
            }
            else
            {
                $email = strip_tags($params["email"]);  // username for login               
                $isEmailExist = $this->Api_model->email_exists($email);
                //echo $isEmailExist;die;
                if($isEmailExist==false){
                    $status = parent::HTTP_OK;
                    $this->return["msg"]="Email Id You Have entered is not registered with us.";
                    $this->return["status"]=0;
                    $this->response($this->return, $status);
                }else{
                    $row = $this->db->select('*')->where('email',$email)->get('users')->row_array();
                    $status = $row["status"];                   
                    if($status == 0)
                    {
                        $status = parent::HTTP_OK;
                        $this->return["msg"]="Admin approval is pending now. Conatct to admin.";
                        $this->return["status"]=0;
                        $this->response($this->return, $status);
                    }
                    else
                    {   
                        /*---- 
                        generate new random password and 
                        update it on database and 
                        sent email to user on email id 
                        -----*/
                        
                        $randpassword = substr(str_shuffle('1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz'), 0, 9);
                        $this->db->set('password',md5($randpassword))->where('email',$email)->update('users');
						
						$to = $email;
                        $subject = "New Password";
                        $msg = "Your New Password is:".$randpassword;                        
                        $this->send_mail($to,$subject,$msg);
						
                        $status = parent::HTTP_OK;
                        $this->return["msg"]="Updated Password Sent your registered mail id.";
                        $this->return["newpassword"]=$randpassword;
                        $this->return["status"]=1;                       
                        $this->response($this->return, $status);
                    }
                }

            }
        } //try
        catch(Exception $e) 
            { 
                log_message('error', "\n Exception Caught", $e->getMessage());
                $status = parent::HTTP_OK;
                $this->return["status"]=0;
                $this->return["msg"]= $e->getMessage();
                $this->response($this->return, $status);
            }  

    }
	
	
	function auctions_get(){
        try{                  
            //$userid = $this->validate_token();
            $params = $this->get(); 
			$userid = $params['user_id'];
			//echo $userid;die;
            $bidstatus = $params['bid_status'];   
            if(empty($bidstatus)){
                $bidapplied = array('bid_status'=>0,'result'=>'Open Bid');
            }
            if($bidstatus ==1){
                $bidapplied = array('bid_status'=>$bidstatus,'result'=>'Bid is Pending for result Declaration');                
            }
            if($bidstatus ==2){
                $bidapplied = array('bid_status'=>$bidstatus,'result'=>'Congratulation! You are winner.');
            }
            if($bidstatus ==3){
                $bidapplied = array('bid_status'=>$bidstatus,'result'=>'You have lost this bid.Try for another.');
            }            
            
            $dbdata = $this->Api_model->get_auction_list($userid,$bidstatus);             
            $i = 0;
            foreach($dbdata as $x=>$val){				
				$bid_status = $this->Api_model->check_bid($userid,$dbdata[$i]['id']);
                if(empty($bid_status)){
                    $bda = 0;
                }else{
                    $bda = 1;
                }
				
				//$data[$i]= $val  ;  
				$data[$i]['id'] = $val['id'] ;
				$data[$i]['material_code'] = $val['material_code'] ;
				$data[$i]['plant_code'] = $val['plant_code'] ;
				$data[$i]['material_description'] = $val['material_description'] ;
				$data[$i]['base_url'] = $val['base_url'] ;
				$data[$i]['material_image'] = $val['material_image'] ;
				$data[$i]['material_type'] = $val['material_type'] ;
				$data[$i]['material_weight'] = $val['material_weight'] ;
				$data[$i]['auction_start_date'] = date("F j, Y, g:i a",strtotime($val['auction_start_date'] )); 
				$data[$i]['auction_close_date'] = date("F j, Y, g:i a",strtotime($val['auction_close_date']));
				$data[$i]['auction_validity_start_date'] = date("F j, Y",strtotime($val['auction_validity_start_date']));
				$data[$i]['auction_validity_end_date'] = date("F j, Y",strtotime($val['auction_validity_end_date']));
				$data[$i]['publish_status'] = $val['publish_status'] ;
				$data[$i]['created'] = $val['created'];			
				
				$data[$i]['bidsubmitted'] = $bda;
				$data[$i]['bit_status'] = $bidapplied['bid_status'];
				$data[$i]['result'] = $bidapplied['result'];
                $i++;
            }

            
            
            if(!empty($data)){				
                $status = parent::HTTP_OK;                
                $this->return["status"]=1;
                $this->return["msg"]="Success"; 
                $this->return["auction_list"]=$data;
            }else{
                $status = parent::HTTP_OK;
                $this->return["status"]=0;
                $this->return["msg"]="No List Available"; 
            }
            $this->response($this->return, $status);
           
        }catch(Exception $e) 
            { 
                log_message('error', "\n Exception Caught", $e->getMessage());
                $status = parent::HTTP_OK;
                $this->return["status"]=0;
                $this->return["msg"]= $e->getMessage();
                $this->response($this->return, $status);
            }

    }

	
	function auction_detail_get($id){
		//echo $id;die;
        try{
            $auction_detail = $this->Api_model->auction_detail_get($id);
            //$img = explode(',',$auction_detail['material_image']);
			//$auction_detail['material_image'] = $img[0]; 
		    //$auction_detail['image_gallery'] = $img;
		    
		    $images = $this->Api_model->get_auction_images($id);
			$auction_detail['material_image'] = $images['0']['image'];	
			foreach($images as $val){
				$a[] = $val['image'];				
			}
			$auction_detail['image_gallery'] = $a; 
            
            
			$status = parent::HTTP_OK;
			$this->return["status"]=1;
			$this->return["msg"]="success";               
			$this->return['auction_detail'] = $auction_detail;			
			$this->response($this->return, $status); 

        }
        catch(Exception $e) 
            { 
                log_message('error', "\n Exception Caught", $e->getMessage());
                $status = parent::HTTP_OK;
                $this->return["status"]=0;
                $this->return["msg"]= $e->getMessage();
                $this->response($this->return, $status);
            }

    }
    
    /*---------------Prsently using api for auction detaills---------------------------*/

    function auction_detail_get_new_post(){
        try{             
				$params = $this->post();           
				$auctionid = $params['auction_id'];            
				$userid = $params['user_id'];                
				$auction_detail = $this->Api_model->get_auction_detail($auctionid);	
				$auction_detail['auction_start_date'] = date("F j, Y, g:i a",strtotime($auction_detail['auction_start_date'] ));
				$auction_detail['auction_close_date'] = date("F j, Y, g:i a",strtotime($auction_detail['auction_close_date'] ));
				$auction_detail['auction_validity_start_date'] = date("F j, Y",strtotime($auction_detail['auction_validity_start_date'] ));
				$auction_detail['auction_validity_end_date'] = date("F j, Y",strtotime($auction_detail['auction_validity_end_date'] ));
				
				
				$bid_status = $this->Api_model->check_bid_detail_page($userid,$auctionid);
				$bidstts =  $bid_status['bid_status'];
				//echo "<pre>";print_r($bidstts);die;
				if(empty($bidstts)){
					$bidapplied = array('bidsubmitted'=>0,'bit_status'=>0,'result'=>'Open Bid');
				}
				if($bidstts==1){
					$bidapplied = array('bidsubmitted'=>1,'bit_status'=>1,'result'=>'pending');
				}
				if($bidstts==2){
					$bidapplied = array('bidsubmitted'=>2,'bit_status'=>2,'result'=>'winner');
				}
				if($bidstts==3){
					$bidapplied = array('bidsubmitted'=>3,'bit_status'=>3,'result'=>'looser');
				}			
				$images = $this->Api_model->get_auction_images($auctionid);			
				unset($auction_detail['material_image']);
				$auction_detail['material_image'] = $images['0']['image'];	
				//$i=1;
				foreach($images as $val){
					$a[] = $val['image'];				
				}
				$auction_detail['image_gallery'] = $a;
			
			//$img = explode(',',$auction_detail['material_image']);			
			//$auction_detail['material_image'] = $img[0]; 
			//$auction_detail['image_gallery'] = $img;


            
            //echo $auction_detail;die;
            if(empty($auction_detail)){
                $status = parent::HTTP_OK;
                $this->return["status"]=0;
                $this->return["msg"]="error";               
                $this->return['auction_detail'] = $auction_detail;											
                $this->response($this->return, $status);
            } else{
                $status = parent::HTTP_OK;
                $this->return["status"]=1;
                $this->return["msg"]="success";
                    		$auction_detail=array_merge($auction_detail,$bidapplied);		
                           //print_r($auction_detail);die;				
                $this->return['auction_detail'] = $auction_detail;                  
                $this->response($this->return, $status); 
            }            
        }
        catch(Exception $e) 
            { 
                log_message('error', "\n Exception Caught", $e->getMessage());
                $status = parent::HTTP_OK;
                $this->return["status"]=0;
                $this->return["msg"]= $e->getMessage();
                $this->response($this->return, $status);
            }

    }

    public function bid_submit_post(){
        try{
                $params = $this->post();
                $userid = $params['user_id'];
                $auctionid = $params['auction_id'];
                $bid_amount = $params['bid_amount'];
                $bidStatus = $this->Api_model->check_bid($userid,$auctionid);								
                if(!empty($bidStatus)){			
                    $status = parent::HTTP_OK;
                    $this->return["status"]=0;
                    $this->return["msg"]="Error ! Bid Already submit For this auction"; 
                    $this->return["details"]=$bidStatus;
                    $this->response($this->return, $status);
                }else{               
                    if($data = $this->Api_model->insert_bid($userid,$auctionid,$bid_amount)){
                        $status = parent::HTTP_OK;                       
                        $this->return["status"]=1;
                        $this->return["msg"]="Success.You have submitted the bid.";
                        $this->return['data'] = $data; 
                        $this->response($this->return, $status);
                    }else{
                        $status = parent::HTTP_OK;
                        $this->return["status"]='failed';
                        $this->return["msg"]="Bid subitting error";
                        $this->return['data'] = $data; 
                        $this->response($this->return, $status);
                    }
                }
        }
        catch(Exception $e) 
        { 
            log_message('error', "\n Exception Caught", $e->getMessage());
            $status = parent::HTTP_OK;
            $this->return["status"]=0;
            $this->return["msg"]= $e->getMessage();
            $this->response($this->return, $status);
        }

    }

    public function bid_result_post(){
        try{
                $params = $this->post();
                $userid = $params['user_id'];
                $auctionid = $params['auction_id'];
                $bidStatus = $this->Api_model->check_bid_status($userid,$auctionid); 
               // echo $bidStatus;die;
                if(empty($bidStatus)){
                    $status = parent::HTTP_OK;                       
                    $this->return["status"]=null;
                    $this->return["msg"]="NO Bid Request Available.";           
                    $this->response($this->return, $status);

                }else{
                    if($bidStatus=='pending'){
                        $status = parent::HTTP_OK;                       
                        $this->return["status"]='0';
                        $this->return["msg"]="Your Request Application is pending.";           
                        $this->response($this->return, $status);
    
                    }

                    if($bidStatus=='winner'){
                        $status = parent::HTTP_OK;                       
                        $this->return["status"]='1';
                        $this->return["msg"]="Congratulations ! You are winner";           
                        $this->response($this->return, $status);
    
                    }

                    if($bidStatus==='looser'){
                        $status = parent::HTTP_OK;                       
                        $this->return["status"]='2';
                        $this->return["msg"]="Oops !you have lost this bid";            
                        $this->response($this->return, $status);
    
                    }

                }   
               
        }catch(Exception $e){ 
            log_message('error', "\n Exception Caught", $e->getMessage());
            $status = parent::HTTP_OK;
            $this->return["status"]=0;
            $this->return["msg"]= $e->getMessage();
            $this->response($this->return, $status);
        }
    }
	
	
	
        public function send_otp_post(){
        try {
            $config =   [
                            [
                                'field' => 'phone',
                                'rules' => 'required|trim|min_length[10]|max_length[10]|integer',
                                'errors' => [
                                                'required' => 'Phone number is required'
                                            ],
                            ],
                            
                    
                        ];

            $params = $this->post();
            $this->form_validation->set_data($params);
            $this->form_validation->set_rules($config);

            if($this->form_validation->run()==FALSE)
            {  
                $phone_error = $this->form_validation->error('phone');  // phone validation
                if (!empty($phone_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($phone_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }    
              
                
            }
            else
            {
                $phone = strip_tags($params["phone"]);  // phone for OTP
                $ret = $this->otp_send_fun($phone);
                $status = parent::HTTP_OK;

                if($ret->response->status == "success")
                {
                    $this->return["msg"]= "Otp send successfully.";
                     $this->return["status"]=1;
                }
                else
                {
                    $this->return["msg"]= $ret->response->details;
                     $this->return["status"]=0;
                }
                
               
                $this->return["data"]=$ret->response;
                $this->response($this->return, $status);
                
                
            }
        } //try
        catch(Exception $e) 
            { 
                log_message('error', "\n Exception Caught", $e->getMessage());
                $status = parent::HTTP_OK;
                $this->return["status"]=0;
                $this->return["msg"]= $e->getMessage();
                $this->response($this->return, $status);
            }  
    }


function otp_send_fun($phone="9717943954")
    {
        //$phone = "91".$phone;
        $phone = $phone;

        $url = "https://enterprise.smsgupshup.com/GatewayAPI/rest?userid=2000199273&password=K9AEgF6iA&method=TWO_FACTOR_AUTH&v=1.1&phone_no=".$phone."&msg=Your%20one%20time%20password%20is%20%25code%25%20Team%20Relia%20Advisory%20Services%20LLP&format=json&otpCodeLength=4&otpCodeType=NUMERIC";

        $ch = curl_init();

        $timeout = 5;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        $data = curl_exec($ch);

        curl_close($ch);

        $dataA = json_decode($data);
        return $dataA;

        //$status = $dataA->response->status; 
        //echo $status; die;
    }


      public function otp_verify_post(){
        try {
            $config =   [
                            [
                                'field' => 'phone',
                                'rules' => 'required|trim|min_length[10]|max_length[10]|integer',
                                'errors' => [
                                                'required' => 'Phone number is required'
                                            ],
                            ],
                            [
                                'field' => 'otp',
                                'rules' => 'required|trim|min_length[4]|max_length[4]|integer',
                                'errors' => [
                                                'required' => 'Otp is required'
                                            ],
                            ],
                            
                    
                        ];

            $params = $this->post();
            $this->form_validation->set_data($params);
            $this->form_validation->set_rules($config);

            if($this->form_validation->run()==FALSE)
            {  
                $phone_error = $this->form_validation->error('phone');  // phone validation
                if (!empty($phone_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($phone_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }    

                $otp_error = $this->form_validation->error('otp');  // otp validation
                if (!empty($otp_error)) 
                {
                $status = parent::HTTP_OK;
                $this->return["msg"]=strip_tags($otp_error);
                $this->return["status"]=0;
                $this->response($this->return, $status);
                }    
              
                
            }
            else
            {
                $phone = strip_tags($params["phone"]);  // phone for OTP
                $otp = strip_tags($params["otp"]);  // otp

                $ret = $this->otp_verify_fun($phone, $otp);

                $status = parent::HTTP_OK;

                if(trim($ret[0]) == "success")
                {

                    $this->return["msg"]= trim($ret[3]);
                    $this->return["status"]=1;
                   
                }
                else
                {
                     $this->return["msg"]= trim($ret[2]);
                     $this->return["status"]=0;   
                }
                
               
                $this->return["data"]=$ret;
                $this->response($this->return, $status);
                
                
            }
        } //try
        catch(Exception $e) 
            { 
                log_message('error', "\n Exception Caught", $e->getMessage());
                $status = parent::HTTP_OK;
                $this->return["status"]=0;
                $this->return["msg"]= $e->getMessage();
                $this->response($this->return, $status);
            }  
    }

    
function otp_verify_fun($phone="9717943954", $otp="1234")
    {
        $phone = $phone;
        $otp = $otp;

        $url = "https://enterprise.smsgupshup.com/GatewayAPI/rest?userid=2000199273&password=K9AEgF6iA&method=TWO_FACTOR_AUTH&v=1.1&phone_no=".$phone."&otp_code=".$otp."";

        $ch = curl_init();

        $timeout = 5;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        $data = curl_exec($ch);

        //print_r($data);

        curl_close($ch);

        $dataA = explode("|", $data);

        return $dataA;
    }




    
}
