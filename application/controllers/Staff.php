<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller
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
        $this->viewData['data'] = array();
        $this->load->helper("basic_helper");
         $this->loggedInId = trim(getSessionUserData("id"));  //output=0/1
        if (getSessionUserData("logged_in") == FALSE && getSessionUserData("id") == "" && empty(getSessionUserData("id"))) 
        {
            // if user is not login then it will rediret to the login page of panel
            redirect(base_url(''));  
        }
        $role_type = trim(getSessionUserData("role_type"));
        $this->roleTypeForCheck = $role_type;
        $rolename = getAdminRoleInfo($role_type, $table = "roles");  // geting the user role
        
    }


    function index(){        
        isLoggedIn();
        customPagination();
        $this->checkUserLevel($this->roleTypeForCheck);        
        $isAll = getStringSegment(3) ? getStringSegment(3) : false;
        if ($isAll && $isAll == 'all') {
            $this->session->unset_userdata('StaffList');
        }
        $prevSessData = getSessionUserData('StaffList');
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

        $contactDataCount = $this->admin_model->record_count('admins', $conditionArray);
        $contactData = $this->admin_model->get_records('admins', $start, $this->perPage, $conditionArray);
        $pagination = createPagination('staff/index', $contactDataCount, $this->perPage, $this->segment, $getField);

        $this->viewData['pagination'] = $pagination;
        $this->viewData['dbdata'] = $contactData;
        $this->viewData['getData'] = $getData;
        $this->viewData['pageNum'] = $page_num;
        $this->viewData['field'] = $sortField;
        $this->viewData['order'] = $order_seg;
        $this->viewData['FormData'] =$prevSessData;
        $this->viewData["adminid"] = $this->loggedInId;
        $this->viewData['dataQuery'] = $this->db->last_query();
        $this->viewData['title'] = 'Staff';
        //print_r($this->viewData);die;
        $this->load->view('staff/list', $this->viewData); 
    }


    function add()
    {   
        $this->checkUserLevel($this->roleTypeForCheck);
        isLoggedIn();
        if($_POST)
           {
             $username = $this->admin_model->exists("username", trim(_inputPost("username")));
             $array = array(

                "name" => trim(_inputPost("name")),
                "email" => trim(_inputPost("email")),
                "phone" => trim(_inputPost("phone")),
                "address" => trim(_inputPost("address")),
                "username" => trim(_inputPost("username")),
                "password" => md5(trim(_inputPost("password"))),
                "status" => trim(_inputPost("status")),
                "role_type " => trim(_inputPost("role")),
             );

             if($username == 1)
             {
                    setSessionFlashData('error', 'Whoops! username exist allready.');
                        
                    redirect(base_url('add-staff'));
             }
             else
             {
                if($this->db->insert("admins", $array))
                {
                    setSessionFlashData('success', 'Great! You have successfully create new staff.');
                        
                    redirect(base_url('add-staff'));
                }
                else
                {
                     setSessionFlashData('error', 'Whoops! some error occured.');
                     redirect(base_url('add-staff')); 
                }
             }

           }

        $this->viewData['roles'] = getAllTableData("roles");
        $this->viewData['title'] = 'Add New Staff';
        $this->viewData['data'] = array();
        $this->load->view('staff/add', $this->viewData);
    }

    function edit($id)
        {
            $this->checkUserLevel($this->roleTypeForCheck);
            isLoggedIn();
                if($_POST)
                   {
                     $array = array(

                        "name" => trim(_inputPost("name")),
                        "email" => trim(_inputPost("email")),
                        "phone" => trim(_inputPost("phone")),
                        "address" => trim(_inputPost("address")),
                        "status" => trim(_inputPost("status")),
                        "role_type " => trim(_inputPost("role")),
                     );

                    
                        if($this->admin_model->_update("admins", $array, $condition = array("id" => $id)))
                        {
                            setSessionFlashData('success', 'Great! You have successfully update the staff.');
                                
                            redirect(base_url('edit-staff/'.$id));
                        }
                        else
                        {
                             setSessionFlashData('error', 'Whoops! some error occured.');
                             redirect(base_url('edit-staff/'.$id)); 
                        }
                    

                   }
                $this->viewData['userDetails'] = $this->admin_model->_profile($id);
                //print_r($userDetails); die;
                $this->viewData['roles'] = getAllTableData("roles");
                $this->viewData['id']= $id;
                $this->viewData['title'] = 'Update Staff';
                $this->viewData['data'] = array();
                $this->load->view('staff/edit', $this->viewData);

        }


    function view($id)
    {
        isLoggedIn();
        $this->viewData['title'] = 'Users View';
        // get admin user from database
        if(!empty($this->loggedInId))
        {
            $this->viewData['adminusers'] = $this->admin_model->_profile($id); 
        }
        $this->viewData["adminid"] = $this->loggedInId;
        $this->viewData['data'] = array();
        $this->load->view('staff/view', $this->viewData);
    }
    
    function delete()
    {
        $id = explode(",",$this->input->post('id'));     
        $this->db->where_in("id", $id);
        if($this->db->delete("admins"))
        {
            echo setSessionFlashData('success', 'Data has been Deleted successfully.');                    
            
        }        
        else
        {
        echo setSessionFlashData('error', 'Staff User not found in our database.');            
       
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
        $table_columns = array("", "NAME", "EMAIL ID", "PHONE NO.", "ADDRESS", "USERNAME", "ROLE", "ADDED_ON","ACCOUNT STATUS");
        $column = 0;
        
        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $queries = $this->admin_model->getExcel();

        //echo count($queries);die;

        if(count($queries) == 0)
        {
            setSessionFlashData('error', 'No Data Found.');
            redirect($_SERVER['HTTP_REFERER']); 
        }
     
        $excel_row = 2;
        $row1 = 1;
        foreach ($queries as $row) {

            if($row["role_type"]==2){
                $role_type = 'Staff';
            }

                        
           

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row1);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row["name"]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row["email"]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row["phone"]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row["address"]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row["username"]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $role_type);
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row["created_at"]);      
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row["status"]);
        $excel_row++;
        $row1++;
    }

    

        $filename="staffList".date('ymdhis').".xls";
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        $object_writer->save('php://output');
    }


    

}