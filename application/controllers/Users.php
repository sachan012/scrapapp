<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller
{
    var $perPage = '10';
    var $segment = '3';
    public $viewData = array();
    public $loggedInAdmin = array();
    private $upload_data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin_model');  // load the admin model
        $this->load->model('role_model');  // load the admin model
        $this->load->model('Users_model');  // load the admin model
        $this->load->model("Api_model");
        $this->viewData['data'] = array();
         $this->loggedInId = trim(getSessionUserData("id"));  //output=0/1
        if (getSessionUserData("logged_in") == FALSE && getSessionUserData("id") == "" && empty(getSessionUserData("id"))) 
        {
            // if user is not login then it will rediret to the login page of panel
            redirect(base_url(''));  
        }
        $role_type = trim(getSessionUserData("role_type"));
        $this->roleTypeForCheck = $role_type;
        $rolename = getAdminRoleInfo($role_type, $table = "roles");  // geting the user role
        $this->load->helper("basic_helper");
       
    }

function index()
    {
       
       isLoggedIn();
       customPagination();
       $this->checkUserLevel($this->roleTypeForCheck);
       $isAll = getStringSegment(3) ? getStringSegment(3) : false;
       if ($isAll && $isAll == 'all') {
            $this->session->unset_userdata('UserList');
        }
        $prevSessData = getSessionUserData('UserList');
        $conditionArray=$prevSessData;
       /* $conditionArray['equal']['template_type'] = 'email';*/
        if($isAll!='all')
        {
            $start =validateURI(3) != '' ? validateURI(3) : '0';
            $getData['page']=$start;
        }
        else{
            $start='0';
            $getData['page']='';
        }
        $getField= $this->input->get();
        $sortField= isset($prevSessData['sort']['field'])?$prevSessData['sort']['field']:'id';
        $order= isset($prevSessData['sort']['order'])?$prevSessData['sort']['order']:'desc';
        $page_num = (int)$this->uri->segment(3);
        if($page_num==0) $page_num=1;
        if($order == "asc") $order_seg = "desc"; else $order_seg = "asc";

        $contactDataCount = $this->Users_model->record_count('users', $conditionArray);
        $contactData = $this->Users_model->get_records('users', $start, $this->perPage, $conditionArray);

        $pagination = createPagination('Users/index', $contactDataCount, $this->perPage, $this->segment, $getField);

        $this->viewData['pagination'] = $pagination;
        $this->viewData['dbdata'] = $contactData;
        $this->viewData['getData'] = $getData;
        $this->viewData['pageNum'] = $page_num;
        $this->viewData['field'] = $sortField;
        $this->viewData['order'] = $order_seg;
        $this->viewData['FormData'] =$prevSessData;
        $this->viewData['adminid'] = $this->loggedInId;
        $this->viewData['dataQuery'] = $this->db->last_query();
        $this->viewData['title'] = 'User List';
        //echo "<pre>";print_r($this->viewData);die;
        $this->load->view('customer/list', $this->viewData); 

    }


    function view($id)
    {
        isLoggedIn();
        $this->viewData['title'] = 'Customer View';
        // get admin user from database
        $this->viewData['customerdetails'] = getWhereWithId("users", array("id"=>$id));
        $this->viewData['data'] = array();
        $this->viewData['adminid'] = $this->loggedInId;
        //print_r($this->viewData['customerdetails']); die;
        $this->load->view('customer/view', $this->viewData);
    }  // view


   // approve


	function approve($id, $status)
	{ 
		$customerdetails = getWhereWithId("users", array("id"=>$id));
		$email = trim($customerdetails["email"]);
		$fullname =  $customerdetails["fullname"];
		$keywords = array('NAME' => $fullname, 'EMAIL' => $email);
		$array=array("status"=>$status, "approved_by"=>$this->loggedInId, "approval_date"=>set_local_to_gmt());	
		$deviceIds = $this->db->select('*')->where('id',$id)->get('users')->row_array();	
		$approved_msg = 'Your Request has been Approved. Now You can Login now.';
		$reject_msg = 'Your Request has been Reject.';
		if($this->db->set($array)->where("id", $id)->update("users")) { 
			if($status == 0)
			{
			  echo 0; die;
			}
			else if($status == 1)
			{ 
			   if ($keywords != '') 
				{
				 $this->SendEmailByTemplate(17, $keywords, $email, ADMIN_NOTIFICATION_EMAIL, ADMIN_NOTIFICATION_TITLE);
				sendPush($deviceIds,$approved_msg);			  
				}

			  echo 1; die;
			}
        else
        {

          if ($keywords != '') 
          {
               $this->SendEmailByTemplate(18, $keywords, $email, ADMIN_NOTIFICATION_EMAIL, ADMIN_NOTIFICATION_TITLE);
              sendPush($deviceIds,$reject_msg);
          }
         
          echo 2; die;
        }
   }
}      // approve     // approve

    // -------------------Delete user ------------------------------------
    public function delete(){
        $id = explode(",",$this->input->post('id'));       
        $this->db->where_in("id", $id);
        if($this->db->delete("users")){
            echo setSessionFlashData('success', 'You have successfully delete the User.');
        }else{
        echo setSessionFlashData('error', 'User not found in our database.');               
        }             
    }

    


function uniqidReal($lenght = 16) 
    {
        // uniqid gives 16 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }


  function SendEmailByTemplate($template_id, $email_keywords = array(), $mailTo, $mailFrom, $mailFromName)
    {
        $CI =& get_instance();
        $strSQL = "SELECT * FROM b_email_templates WHERE id =" . $template_id;
        $resSQL = $CI->db->query($strSQL);
        if ($resSQL->num_rows() > 0) {
            $result = $resSQL->result_array();
            $msg_body = $result[0]['email_content'];
            $msg_subject = $result[0]['email_subject'];
            if (is_array($email_keywords)) {
                foreach ($email_keywords as $key => $value) {
                    $msg_subject = str_replace("[" . $key . "]", $value, $msg_subject);

                    if (strstr($msg_body, "/[" . $key . "]")) {
                        $msg_body = str_replace("/[" . $key . "]", $value, $msg_body);
                        $msg_body = str_replace("[" . $key . "]", $value, $msg_body);
                    } else {
                        $msg_body = str_replace("[" . $key . "]", $value, $msg_body);
                    }
                }
            }
            if (preg_match_all('@<img.*src="([^"]*)"[^>/]*/?>@Ui', $msg_body, $image)) {
                if (isset($image[1]) && !empty($image[1])) {
                    foreach ($image[1] as $src) {
                        //$msg_body = str_replace($src,$siteUrl.$src,$msg_body);
                    }
                }

            }
            if (preg_match("/[SITE_URL]/", $msg_body)) {
                $msg_body = str_replace('/[SITE_URL]', base_url(), $msg_body);
            }

            //$msg_body = replaceImgSrc( $msg_body);
            $siteUrl = sprintf("%s://%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']);


            $msg_body = replaceImgSrc($msg_body);
            $msg_subject = html_entity_decode(htmlentities($msg_subject));
            $msg_body = html_entity_decode(htmlentities($msg_body));
            $CI->viewData['msg_body'] = $msg_body;
            $msg_header = $CI->load->view('email/header', $CI->viewData, true);
            $full_msg_body = $msg_header;			
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
			$this->email->from(EMAIL,$mailFromName);		
			$this->email->to($mailTo);		
			$this->email->set_mailtype('html');
			$this->email->subject($msg_subject);
			$this->email->message($full_msg_body);
			if($this->email->send()){
             return true;
            }else{
              return false;
            }
        }
    }

    function checkUserLevel($role)
     {

        if($role != 1)
        {
            redirect("dashboard");
        }
     }
     
     
      function download_report(){       
        $this->load->library("excel");
        $object = new PHPExcel();        
        $object->setActiveSheetIndex(0);
        $table_columns = array("SN", "NAME", "COMPANY NAME", "EMAIL ID", "PHONE NO.", "ADDRESS", "PAN NO.", "GST NO.","ACCOUNT STATUS","CREATED");
        $column = 0;
        
        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $queries = $this->Users_model->getExcel();

        //echo count($queries);die;

        if(count($queries) == 0)
        {
            setSessionFlashData('error', 'No Data Found.');
            redirect($_SERVER['HTTP_REFERER']); 
        }
     
        $excel_row = 2;
        $row1 = 1;
        foreach ($queries as $row) 
        {

            if($row["status"]==0){
                $status = 'Pending';
            }
            if($row["status"]==1){
                $status = 'Active';
            }
            if($row["status"]==2){
                $status = 'Rejected';
            }

            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row1);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row["fullname"]);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row["company_name"]);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row["email"]);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row["phone"]);
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row["address"]);
            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row["pan_no"]);
            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row["gst_no"]);           
            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $status);
             $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row["created_on"]);
            $excel_row++;
            $row1++;
        }

        $filename="appusersList".date('ymdhis').".xls";
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        $object_writer->save('php://output');
    }



}// class