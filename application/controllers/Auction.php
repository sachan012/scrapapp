<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auction extends CI_Controller
{
    var $perPage = '10';
    var $segment = '3';
    public $viewData = array();
    public $loggedInAdmin = array();
    private $upload_data = array();

    public function __construct(){
        parent::__construct();
        $this->load->model('admin_model');  // load the admin model
        $this->load->model('role_model');  // load the admin model
        $this->load->model('auction_model');  // load the Auction model
        $this->viewData['data'] = array();
        $this->load->helper("basic_helper");
		$this->load->helper("push_notification");
        $this->load->library('form_validation');
        $this->loggedInId = trim(getSessionUserData("id"));
        if (getSessionUserData("logged_in") == FALSE && getSessionUserData("id") == "" && empty(getSessionUserData("id"))) 
        {
            // if user is not login then it will rediret to the login page of panel
            redirect(base_url(''));  
        }
        $role_type = trim(getSessionUserData("role_type")); //output=1/2/3 /4/5/6     
        $this->roleTypeForCheck = $role_type;
        $rolename = getAdminRoleInfo($role_type, $table = "roles");  // geting the user role
        /*if($rolename["role_id"] != 1)
        {
            redirect(base_url("dashboard"));
        }*/
    }


    function index(){
        $this->checkUserLevel($this->roleTypeForCheck);
        isLoggedIn();
        customPagination();


        $isAll = getStringSegment(3) ? getStringSegment(3) : false;
        if ($isAll && $isAll == 'all') {
            $this->session->unset_userdata('AuctionList');
        }
        $prevSessData = getSessionUserData('AuctionList');
        $conditionArray=$prevSessData;
       /* $conditionArray['equal']['template_type'] = 'email';*/
        if($isAll!='all'){
            $start =validateURI(3) != '' ? validateURI(3) : '0';
            $getData['page']=$start;
        }
        else{
            $start='0';
            $getData['page']='';
        }
        $getField = $this->input->get();  
       
        $sortField= isset($prevSessData['sort']['field'])?$prevSessData['sort']['field']:'auction_id';
        $order= isset($prevSessData['sort']['order'])?$prevSessData['sort']['order']:'desc';
        $page_num = (int)$this->uri->segment(3);
        if($page_num==0) $page_num=1;
        if($order == "asc") $order_seg = "desc"; else $order_seg = "asc";

        $contactDataCount = $this->auction_model->record_count('auction', $conditionArray);
        $contactData = $this->auction_model->get_records('auction', $start, $this->perPage, $conditionArray);
        $pagination = createPagination('Auction/index', $contactDataCount, $this->perPage, $this->segment, $getField);

        $this->viewData['pagination'] = $pagination;
        $this->viewData['dbdata'] = $contactData;
        $this->viewData['getData'] = $getData;
        $this->viewData['pageNum'] = $page_num;
        $this->viewData['field'] = $sortField;
        $this->viewData['order'] = $order_seg;
        $this->viewData['FormData'] =$prevSessData;
        $this->viewData["adminid"] = $this->loggedInId;       
        $this->viewData['title'] = 'Auctions List';

        $this->viewData['roleDes'] = $this->roleTypeForCheck;


        //print_r($this->viewData);die;
        $this->load->view('auction/list', $this->viewData); 
    }
	
	function checkUserLevel($role)
    {

        if($role == 2)
        {
            redirect("dashboard");
        }
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
    }


    function create(){

        $this->checkUserLevel($this->roleTypeForCheck);
        isLoggedIn();       
        $this->viewData['roles'] = getAllTableData("roles");
        $this->viewData['title'] = 'Create Auction';
        $this->viewData['data'] = array();
        $this->load->view('auction/create', $this->viewData);
    }


    public function insert(){  
       $this->form_validation->set_rules('material_code', 'Material Code', 'required|trim');         
        $this->form_validation->set_rules('plant_code', 'Plant Code', 'required|trim');         
        $this->form_validation->set_rules('amount_measure', 'Quantity in Measurement', 'required');         
        $this->form_validation->set_rules('material_type', 'Material Type', 'required');         
        // basic required field with minimum length
        $this->form_validation->set_rules('material_description', 'Auction Description', 'required|min_length[8]');         
        // basic required field with maximum length
        $this->form_validation->set_rules('auction_start', 'auction_start', 'required');         
        // basic required field with exact length
        $this->form_validation->set_rules('auction_start_time', 'auction_start_time', 'required');       
        $this->form_validation->set_rules('auction_end', 'auction_end', 'required');       
        $this->form_validation->set_rules('auction_finish_time', 'auction_finish_time', 'required');       
        $this->form_validation->set_rules('auction_validity_from_date', 'auction_validity_from_date', 'required');       
        $this->form_validation->set_rules('auction_validity_to_date', 'auction_validity_to_date', 'required');       
         
        if ($this->form_validation->run() == FALSE)
        {
            $this->viewData['roles'] = getAllTableData("roles");
            $this->viewData['title'] = 'Create Auction';
            $this->viewData['data'] = array();
            $this->load->view('auction/create', $this->viewData);
        }
        else
        {
            $files = $_FILES;
            $count = count($_FILES['userfile']['name']);
            for($i=0; $i<$count; $i++){
                $abd = time().$i;
                $_FILES['userfile']['name']= time().$files['userfile']['name'][$i];
                $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                $config['upload_path'] = './uploads/scraps/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $config['max_width'] = '';
                $config['max_height'] = '';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
				if($this->upload->do_upload('userfile')){
					$fileName = $abd.'.'.pathinfo($_FILES['userfile']['name'],PATHINFO_EXTENSION);
					$images[] = $fileName;
					$fileName = implode(',',$images);  
				}else{
					$fileName = "noimage.jpg";
				}              
            }
            $auctionins = $this->auction_model->insert_auction_data($fileName);
            $insert_id = $this->db->insert_id();
            //background email sending for all users
            $url = base_url('Sendmail/sendBackgroundEmail');
            $auctionId =  $insert_id;
            $cmd = FCPATH . 'send_request.php';
            $command = "/usr/bin/php $cmd $auctionId $url > /dev/null 2>&1 &";
            exec($command);



            foreach ($images as $img) {                      
                $data = array(
                    'auction_id' => $insert_id, 
                    'image'=> $img);                    
                $this->db->insert('image_gallery',$data);
               
            }
            if($auctionins==true){
                $this->session->set_flashdata('success','Auction Created');
                redirect('auction/index');
            }else{
                $this->session->set_flashdata('error','Something Went Wrong. Please Try again');
                redirect($_SERVER['HTTP_REFERER']); 
            }
            //echo "All Good";
        } 
            
        
    }



    function edit($id){        
            $this->checkUserLevel($this->roleTypeForCheck);
            isLoggedIn();
            $auction_details = $this->auction_model->get_auction_details($id);   
            $images = $this->auction_model->get_auction_images($id);     
           // print_r($images)  ;die; 
            if($_POST){
                $files = $_FILES;               
                // print_r($files['userfile']['name'][0]);die;
                if(!empty($files['userfile']['name'][0])){
                  $count = count($_FILES['userfile']['name']);
                  // $user_id = $this->input->post('user_id');
                  for($i=0; $i<$count; $i++)
                    {
                        $abd = time().$i;
                        $_FILES['userfile']['name']= time().$files['userfile']['name'][$i];
                        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                        $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                        $config['upload_path'] = './uploads/scraps/';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['max_size'] = '2000000';
                        $config['remove_spaces'] = true;
                        $config['overwrite'] = false;
                        $config['max_width'] = '';
                        $config['max_height'] = '';
                        $config['file_name'] = $abd;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $this->upload->do_upload();
                        $fileName = $abd.'.'.pathinfo($_FILES['userfile']['name'],PATHINFO_EXTENSION);
                        $image_arr[] = $fileName; 
                        $fileName = implode(',',$images);
                    }

                    foreach ($image_arr as $img) {
                        $data = array(
                            'auction_id' => $id, 
                            'image'=> $img);                    
                        $this->db->insert('image_gallery',$data);
                    }

                    $asd = trim($this->input->post('auction_start'));   
                    $ast = trim($this->input->post('auction_start_time'));
                    $asdt = $asd.' '.$ast;
        
                    $aed = trim($this->input->post('auction_end'));   
                    $aet = trim($this->input->post('auction_finish_time'));            
                    $aedt = $aed.' '.$aet;  

                    $avs = trim($this->input->post('auction_validity_from_date'));   
                    $ave = trim($this->input->post('auction_validity_to_date'));

                     
                    $dataarray = array(
                        'material_code' =>trim($this->input->post('material_code')),
                        'plant_code' =>trim($this->input->post('plant_code')),
                        'material_description' =>trim($this->input->post('material_description')),
                        'base_url' => base_url('uploads/scraps/'),  
                        'material_image' =>$fileName,
                        'material_type' =>trim($this->input->post('material_type')),
                        'material_weight' =>trim($this->input->post('amount_measure')),
                        'auction_start_date' => $asdt,
                        'auction_close_date' => $aedt,                      	
                        'auction_validity_start_date' =>$avs,
                        'auction_validity_end_date' =>$ave,	             
                    );

                    


                    }else
                    {

                        $asd = trim($this->input->post('auction_start'));   
                        $ast = trim($this->input->post('auction_start_time'));
                        $asdt = $asd.' '.$ast;
            
                        $aed = trim($this->input->post('auction_end'));   
                        $aet = trim($this->input->post('auction_finish_time'));            
                        $aedt = $aed.' '.$aet;          
                        
            
                        $avs = trim($this->input->post('auction_validity_from_date'));   
                        $ave = trim($this->input->post('auction_validity_to_date')); 

                      $dataarray = array(
                            'material_code' =>trim($this->input->post('material_code')),
                            'plant_code' =>trim($this->input->post('plant_code')),
                            'material_description' =>trim($this->input->post('material_description')),
                            'material_type' =>trim($this->input->post('material_type')),
                            'material_weight' =>trim($this->input->post('amount_measure')),
                            'auction_start_date' => $asdt,
                            'auction_close_date' => $aedt,                            	
                            'auction_validity_start_date' =>$avs,
                            'auction_validity_end_date' =>$ave,	             
                        );
                    }

					//echo "<pre>";print_r($dataarray);die;
				
              
               if($this->auction_model->update_auction_info($dataarray,$id)){
                   setSessionFlashData('success', 'Great! You have successfully update the Auction.');
                   redirect(base_url('edit-auction/'.$id));
               }
               else{
                    setSessionFlashData('error', 'Whoops! some error occured.');
                    redirect(base_url('edit-auction/'.$id)); 
               }
            } 
            // print_r($auction_details); die;
            $this->viewData['auction_details'] = $auction_details;
            $this->viewData['roles'] = getAllTableData("roles");
            $this->viewData['id']= $id;
            $this->viewData['title'] = 'Update uction details';
            $this->viewData['images'] = $images;
            $this->viewData['data'] = array();
            $this->load->view('auction/edit', $this->viewData);

    }


    function view($id)
    {
        isLoggedIn();
        $this->viewData['title'] = 'Auction Details';
        // get admin user from database
        if(!empty($this->loggedInId))
        {
            $this->viewData['bids_details'] = $this->auction_model->get_auction_bids($id);
            $this->viewData['auction_details'] = $this->auction_model->get_auction_details($id); 
            $images = $this->auction_model->get_auction_images($id); 
        }       
        $this->viewData["adminid"] = $this->loggedInId;
        $this->viewData['images'] = $images;
        //echo "<pre>";print_r($images);die;
        $this->viewData['data'] = array();
        $this->load->view('auction/view', $this->viewData);
    }
    
    
    public function bids($id){
        isLoggedIn();
        $this->viewData['title'] = 'Auction Details';
        // get admin user from database
        if(!empty($this->loggedInId))
        {
            $this->viewData['bids_details'] = $this->auction_model->get_auction_bids($id);
            $this->viewData['auction_details'] = $this->auction_model->get_auction_details($id); 
            $images = $this->auction_model->get_auction_images($id); 
        }  

        $bidOne = $this->db->select("id")->from("bids")->where(array("approver_one_status"=> 1, "auction_id"=>$id))->get();
        $bidOne = $bidOne->row_array();

        $this->viewData["approvedBid"] = $bidOne;

        $this->viewData['roleType'] =  $this->roleTypeForCheck;

        //print_r($this->viewData['bids_details']); die;  
        $this->viewData["adminid"] = $this->loggedInId;
        $this->viewData['images'] = $images;
        //echo "<pre>";print_r($images);die;
        $this->viewData['data'] = array();
        $this->load->view('auction/bids', $this->viewData);

    }


    function delete()
    {
        $id = explode(",",$this->input->post('id'));       
        $this->db->where_in("id", $id);
        if($this->db->delete("auction"))
        {
            $this->db->where_in('auction_id',$id)->delete('image_gallery');
            $this->db->where_in('auction_id',$id)->delete('bids');
            $this->db->where_in('auction_id',$id)->delete('staff_entery');
            echo setSessionFlashData('success', 'You have successfully delete the Auction.');
        }        
        else
        {
        echo setSessionFlashData('error', 'Auction not found in our database.');
        }
         
    }


    public function image_upload_ajax(){
            $files = $_FILES;
            $count = count($_FILES['userfile']['name']);
            for($i=0; $i<$count; $i++){
                $abd = time().$i;
                $_FILES['userfile']['name']= time().$files['userfile']['name'][$i];
                $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                $config['upload_path'] = './uploads/scraps/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '2000000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $config['max_width'] = '';
                $config['max_height'] = '';
                $config['file_name'] = $abd;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->do_upload();
                $fileName = $abd.'.'.pathinfo($_FILES['userfile']['name'],PATHINFO_EXTENSION);
                $images[] = $fileName;
                $fileName = implode(',',$images);              
            }

            foreach ($images as $img) {
                    $data = array(
                        'auction_id' => $this->input->post('auction_id'), 
                        'image'=> $img);                    
                    $this->db->insert('image_gallery',$data);
            }
            echo $this->db->last_query();
    }

    public function removeAuctionImage(){
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('image_gallery');
        echo 1;
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


    
	
	function auctionStatus(){             
        $status = $this->input->post('status');        
        $id = $this->input->post('id');       
        $this->db->set('publish_status',$status)->where('id',$id)->update('auction');
        echo 1;
    }
	 
	function change_bid_status(){
        $bid_status = $this->input->post('bid_status');
        $bid_id = $this->input->post('bid_id');   
        $auction_id = $this->input->post('auction_id');
        $user_id = $this->input->post('user_id');
        //echo $auction_id;die;              
		$this->db->set('bid_status',$bid_status)->where('id',$bid_id)->update('bids');
        if($bid_status==2){
            $string = "UPDATE bids SET bid_status=3 WHERE auction_id='$auction_id' AND bid_status !=2";
            $this->db->query($string);
        }
				
		$data2 = $this->auction_model->get_bid_details($auction_id);
        foreach($data2 as $val){
            $deviceIds = $val['device_token'];
            $fullname =	$val['fullname'];
            $company_name =	$val ['company_name'] ;
            $email = $val['email'];
            $phone = $val['phone'];  
			
            $material_code = $val['material_code'];
            $plant_code = $val['plant_code'];
            $material_description = $val['material_description'];
            $material_type =$val['material_type'];
            $material_weight =$val['material_weight'];
            $bid_status =$val['bid_status'];
			$auction_start_date = $val['auction_start_date'];
			$auction_close_date = $val['auction_close_date'];
			$auction_validity_start_date = $val['auction_validity_start_date'];
			$auction_validity_end_date = $val['auction_validity_end_date'];			
			
			$data['auction_start_date'] = $auction_start_date;
			$data['auction_close_date'] = $auction_close_date;
			$data['auction_validity_start_date'] = $auction_validity_start_date;
			$data['auction_validity_end_date'] = $auction_validity_end_date;
            
            $data['fullname'] = $fullname;
            $data['auction_id'] = $auction_id;
            $data['auction_date'] = $auction_start_date;
            $dt = date("Y-m-d", strtotime($val['last_updated']));
           
            $data['from_date'] = $dt;
            $newdate = strtotime($dt);
            $todate =  date("Y-m-d", strtotime("+1 month", $newdate))."\n";
            $data['to_date'] = $todate;
            $data['company_name'] = $company_name;
            $data['email'] = $email;
            $data['phone'] = $phone;
            $data['material_code'] = $material_code;
            $data['material_type'] = $material_type;
            $data['material_weight'] = $material_weight;
            if($bid_status==1){
                echo 1;
            }
            if($bid_status==2){
               $msg =  $this->load->view('auction/mailer',$data,TRUE);
               sendPush(array($deviceIds),$msg);
                $this->send_mail($email,'Auction Status',$msg);
            }if($bid_status==3){
                //$msg = "You Lost Action for Material Code:'$material_code',Material type:'$material_type'";
				$msg = "<p>Dear ".$fullname.", </p>
                <p>You have lost bid.</p>
				<p><strong>Auction Details Below:</strong>   
                <br><strong>Material Code : </strong>".$material_code."
                <br><strong>Plant Code : </strong>".$plant_code."
                <br><strong>Material Type : </strong>".$material_type."
                <br><strong>Material Weight : </strong>".$material_weight."
                <br><strong>Material Description : </strong>".$material_description."
                <br><strong>Auction Start Date : </strong>".date("F j, Y, g:i a",strtotime($auction_start_date))."
				<br><strong>Auction End Date : </strong>".date("F j, Y, g:i a",strtotime($auction_close_date))."</p>                               
				<p></p><p></p>
				<p>With warm regards<br></p>
                ";
                sendPush(array($deviceIds),$msg);
                $this->send_mail($email,'Auction Status',$msg);
            }
        }

		    
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
        $this->email->from(EMAIL, 'RaS E-Tender');		
		$this->email->to($to);		
		//$this->email->to('sachan012@gmail.com');
		//$this->email->cc('rahulr@triazinesoft.com');
		
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
    
     function download_report($id)
    {
       
        $this->load->library("excel");
        $object = new PHPExcel();        
        $object->setActiveSheetIndex(0);
        $table_columns = array("Sr No.", "NAME", "COMPANY NAME", "BID AMOUNT(Rate/Kg)", "EMAIL", "PHONE", "ADDRESS", "GST NO", "PAN NO","RESULT STATUS");
        $column = 0;

        // echo "<pre>";print_r($table_columns);die;
        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $queries = $this->auction_model->getExcel($id);

        //echo count($queries);die;

        if(count($queries) == 0)
        {
            setSessionFlashData('error', 'No Entry Is Found.');
            redirect($_SERVER['HTTP_REFERER']); 
        }
     
        $excel_row = 2;
        $row1 = 1;
        foreach ($queries as $row) {

             if ($row["bid_status"] == 1) {
                $status = "Pending";
            } else if ($row["bid_status"] == 2) {
                $status = "Winner";
            } else {
                $status = "Looser";
            }
           

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row1);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row["fullname"]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row["company_name"]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row["bid_amount"]);

        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row["email"]);

        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row["phone"]);

        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row["address"]);

        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row["gst_no"]);

        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row["pan_no"]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $status);
        $excel_row++;
        $row1++;
    }

    //echo "<pre>";print_r( $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row["bid_status"]));die;

        $filename="bidResult".date('ymdhis').".xls";
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        $object_writer->save('php://output');
    }
    
    public function mailer(){
        $this->load->view('auction/mailer');
    }


    function approval($bidid)
    {
        isLoggedIn();
        $this->viewData['title'] = 'Auction Details';
        // get admin user from database

        $this->db->select("auction_id")->from("bids");
        $this->db->where("id", $bidid);
        $query = $this->db->get();
        $result = $query->result_array();
        $auctionId = $result[0]["auction_id"];

        $this->db->select("*")->from("bids as b");
      /*  $this->db->join("auction as a", "a.id = b.auction_id");*/
        $this->db->where("b.id", $bidid);
        $query = $this->db->get();
        $result = $query->row_array();
        //print_r($result); die;


        $this->db->select("*")->from("roles as r");
        $query = $this->db->get();
        $resultRoles = $query->result_array();

        $this->viewData['auction_details'] = $this->auction_model->get_auction_details($auctionId);

        $this->viewData['roleNames'] = $resultRoles;
           
        $this->viewData['roleType'] =  $this->roleTypeForCheck;
        $this->viewData['bids_details'] = $result;
        $this->load->view('auction/approver', $this->viewData);
    }


   /* function approver()
    {
        $bidId = $this->input->post("bidid");
        $auctionId = $this->input->post("auctionid");
        $remarks = trim($this->input->post("remark"));
        $type = $this->input->post("type");
        $logId = $this->loggedInId;
        $email = array();

        $bidData=  $this->getBidDataById($bidId);
        $firstApproverId = $bidData["approver_one_id"];
        $secondApproverId = $bidData["approver_two_id"];
        $thirdApproverId = $bidData["approver_three_id"];
        $fourthApproverId = $bidData["approver_four_id"];


        if($type == 1)
        {

            $approverDe = $this->getApproverDataById($firstApproverId);
            //print_r($approverDe); die;
            $subject = "Auction Is Approved By The Approver Level 1";
            $ms = "Auction is approved by the approver level 1  (".$approverDe["email"]." and ".$approverDe["name"]." )  , please approved this auction at your end.";
        }
        else if($type == 2)
        {
            $approverDe = $this->getApproverDataById($secondApproverId);
           $subject = "Auction Is Approved By The Approver Level 2";
           $ms = "This auction is approved by the approver level 2  (".$approverDe["email"]." and ".$approverDe["name"]." ) , please approved this auction at your end.";
        }
        else
        {
            $approverDe = $this->getApproverDataById($thirdApproverId);
            $subject = "Auction Is Approved By The Approver Level 3";
            $ms = "This auction is approved by the approver level 3  (".$approverDe["email"]." and ".$approverDe["name"]." ), please approved this auction at your end.";
        }
        


        $auction_details = $this->auction_model->get_auction_details($auctionId); 
        //print_r($auction_details); die;

        $html = "

        <p>".$ms."</p>
        <p>Auction Details Below:</p>

        <p>Material Code : ".$auction_details["material_code"]."</p>
        <p>Plant Code : ".$auction_details["plant_code"]."</p>
        <p>Material Type : ".$auction_details["material_type"]."</p>
        <p>Tentative Quantity : ".$auction_details["material_weight"]."</p>

        ";

        //echo $html; die;

       

        $approved_date = date("Y-m-d H:i:s");
      

        if($type == 1)   // first approver
        {

            $approver1 = $this->getDataById(3);
            foreach($approver1 as $row)
            {
                $email[] = $row["email"];
            }
            $data = array("approver_one_status"=>1, "approver_one_id"=>$logId, "approver_remark_one"=>$remarks, "approver_remark_one_date"=>$approved_date);

            $this->send_mail($email, $subject, $html);

        }
        else if($type == 2)  // second approver
        {
            $approver2 = $this->getDataById(4);
            foreach($approver2 as $row)
            {
                $email[] = $row["email"];
            }
           
            $data = array("approver_two_status"=>1, "approver_two_id"=>$logId, "approver_remark_two"=>$remarks, "approver_remark_two_date"=>$approved_date);
            $this->send_mail($email, $subject, $html);
        }
        else if($type == 3) // third approver
        {
            $approver3 = $this->getDataById(5);

            foreach($approver3 as $row)
            {
                $email[] = $row["email"];
            }

            $data = array("approver_three_status"=>1, "approver_three_id"=>$logId, "approver_remark_three"=>$remarks, "approver_remark_three_date"=>$approved_date);
            $this->send_mail($email, $subject, $html);
        }
        else // fourth approver
        {
            $approver4 = $this->getDataById(6);

            foreach($approver4 as $row)
            {
                $email[] = $row["email"];
            }


            $data = array("approver_four_status"=>1, "approver_four_id"=>$logId, "approver_remark_four"=>$remarks, "approver_remark_four_date"=>$approved_date);
            $this->send_mail($email, $subject, $html);
        }
         
        $this->db->where("id",$bidId);
        if($this->db->update("bids", $data))
        {

           
             //$this->send_mail($email, $subject, $html);
             setSessionFlashData('success', 'Great! You have successfully approved this bid.');
             redirect(base_url('view-approval/'.$bidId));
        }
        else
        {
              setSessionFlashData('error', 'Whoops! some error occured.');
             redirect(base_url('edit-approval/'.$bidId)); 
        }
    }*/



function approver()
    {
        $bidId = $this->input->post("bidid");
        $auctionId = $this->input->post("auctionid");
        $remarks = trim($this->input->post("remark"));
        $type = $this->input->post("type");
        $logId = $this->loggedInId;
        $email = array();

        $approved_date = date("Y-m-d H:i:s");

        $auction_details = $this->auction_model->get_auction_details($auctionId); 
       
        if($type == 1) 
        {

            $approver1 = $this->getDataById(4);
            foreach($approver1 as $row)
            {
                $email[] = $row["email"];
            }
            $data = array("approver_one_status"=>1, "approver_one_id"=>$logId, "approver_remark_one"=>$remarks, "approver_remark_one_date"=>$approved_date);

        }
        

        else if($type == 2)
        {
            $approver2 = $this->getDataById(5);
            foreach($approver2 as $row)
            {
                $email[] = $row["email"];
            }
           
            $data = array("approver_two_status"=>1, "approver_two_id"=>$logId, "approver_remark_two"=>$remarks, "approver_remark_two_date"=>$approved_date);
        }
        else if($type == 3)
        {
            $approver3 = $this->getDataById(6);

            foreach($approver3 as $row)
            {
                $email[] = $row["email"];
            }

            $data = array("approver_three_status"=>1, "approver_three_id"=>$logId, "approver_remark_three"=>$remarks, "approver_remark_three_date"=>$approved_date);
        }
         else 
        {
            $data = array("approver_four_status"=>1, "approver_four_id"=>$logId, "approver_remark_four"=>$remarks, "approver_remark_four_date"=>$approved_date);
        }

        /*echo $bidId; 
        print_r($data); die;*/
       
        $this->db->where("id",$bidId);
        if($this->db->update("bids", $data))
        {

            $bidData=  $this->getBidDataById($bidId);
            $firstApproverId = $bidData["approver_one_id"];
            $secondApproverId = $bidData["approver_two_id"];
            $thirdApproverId = $bidData["approver_three_id"];
            $fourthApproverId = $bidData["approver_four_id"];


            if($type == 1)
            {

                $approverDe = $this->getApproverDataById($firstApproverId);
                $subject = "Auction Is Approved By The Approver Level 1";
                $ms = "Auction is approved by the approver level 1  (".$approverDe["email"]." and ".$approverDe["name"]." )  , please approved this auction at your end.";
            }
            else if($type == 2)
            {
               $approverDe = $this->getApproverDataById($secondApproverId);
               $subject = "Auction Is Approved By The Approver Level 2";
               $ms = "This auction is approved by the approver level 2  (".$approverDe["email"]." and ".$approverDe["name"]." ) , please approved this auction at your end.";
            }
            else if($type == 3)
            {
                $approverDe = $this->getApproverDataById($thirdApproverId);
                $subject = "Auction Is Approved By The Approver Level 3";
                $ms = "This auction is approved by the approver level 3  (".$approverDe["email"]." and ".$approverDe["name"]." ), please approved this auction at your end.";
            }
            else
            {
            }
            
            
            $html = "
            <p>".$ms."</p>
            <p>Auction Details Below:</p>

            <p>Material Code : ".$auction_details["material_code"]."</p>
            <p>Plant Code : ".$auction_details["plant_code"]."</p>
            <p>Material Type : ".$auction_details["material_type"]."</p>
            <p>Tentative Quantity : ".$auction_details["material_weight"]."</p>

            <p>Material Description : ".$auction_details["material_description"]."</p>
            <p>Auction Start Date : ".$auction_details["auction_start_date"]."</p>
            <p>Auction Close Date : ".$auction_details["auction_close_date"]."</p>

            ";

            if($type != 4)
            {
                $this->send_mail($email, $subject, $html);
            }

             setSessionFlashData('success', 'Great! You have successfully approved this bid.');
             redirect(base_url('view-approval/'.$bidId));
        }
        else
        {
              setSessionFlashData('error', 'Whoops! some error occured.');
             redirect(base_url('edit-approval/'.$bidId)); 
        }
    }




    function getDataById($roleId){
        $this->db->select("email");
        $this->db->from("admins");
        $this->db->where("role_type", $roleId);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }


    function getBidDataById($id){
        $this->db->select("*");
        $this->db->from("bids");
        $this->db->where("id", $id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    function getApproverDataById($id){
        $this->db->select("name, email");
        $this->db->from("admins");
        $this->db->where("id", $id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }






function clearremarks($auction_id)
{
    //echo $auction_id; die;
    /*$this->db->select("id")->from("bids")->where("approver_one_status",1);
    $query = $this->db->get();
    $result = $query->row_array();
    $bidId = $result["id"];*/
    $array = array("bid_status"=>1, "approver_one_status"=>0, "approver_one_id"=>0, "approver_remark_one"=>null, "approver_remark_one_date"=>null, "approver_two_status"=>0, "approver_two_id"=>0, "approver_remark_two"=>null, "approver_remark_two_date"=>null, "approver_three_status"=>0, "approver_three_id"=>0, "approver_remark_three"=>null, "approver_remark_three_date"=>null,"approver_four_status"=>0, "approver_four_id"=>0, "approver_remark_four"=>null, "approver_remark_four_date"=>null);
    $this->db->where("auction_id", $auction_id);
    if($this->db->update("bids", $array))
    {
        setSessionFlashData('success', 'Great! You have successfully cancel this auction or bid remarks.');
        redirect(base_url('view-bids/'.$auction_id));
    }
}


    

}