<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Staffentery extends CI_Controller
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
        $this->load->model('Entery_model');  // load the admin model
        $this->load->model("Api_model");
        $this->load->model("Auction_model");
        $this->viewData['data'] = array();
        $this->loggedInId = trim(getSessionUserData("id"));
        if (getSessionUserData("logged_in") == FALSE && getSessionUserData("id") == "" && empty(getSessionUserData("id"))) 
        {
            // if user is not login then it will rediret to the login page of panel
            redirect(base_url(''));  
        }
        $this->load->helper("basic_helper");
       
    }

public function index(){    
    isLoggedIn();
    customPagination();      
    //$vehicleEntries = $this->Entery_model->get_all_vehiche_entries();
    //echo "<pre>";print_r($vehicleEntries);die;
    
    // $this->viewData['dbdata'] = $vehicleEntries;
    // $this->viewData['adminid'] = $this->loggedInId;
    // $this->viewData['dataQuery'] = $this->db->last_query();
    // $this->viewData['title'] = 'Entery List';
    // $this->load->view('staffentery/list', $this->viewData); 


          
        $conditionArray=[];
       
        $getField= $this->input->get();
        
        //echo "<pre>";print_r($this->uri->segment(3));die;
        $page_num = (int)$this->uri->segment(3);
        
        if($page_num==0) $page_num=1;
        if($order == "asc") $order_seg = "desc"; else $order_seg = "asc";
        if(!empty($getField)){
            if(isset($getField['auction'])){
                 $conditionArray['auction_id'] = $getField['auction'];
            }
        }
        //print_r($conditionArray);die;

        $contactDataCount = $this->Entery_model->record_count('staff_entery', $conditionArray);
        //echo $contactDataCount;die;
        $contactData = $this->Entery_model->get_records('staff_entery', $start, $this->perPage, $conditionArray);
        $pagination = createPagination('Staffentery/index', $contactDataCount, $this->perPage, $this->segment, $getField);

        $auctionList = $this->Auction_model->get_auctionList();
        $this->viewData['auctionList'] = $auctionList;
        $this->viewData['pagination'] = $pagination;
        $this->viewData['dbdata'] = $contactData;
        $this->viewData['getData'] = $getData;
        $this->viewData['pageNum'] = $page_num;
        $this->viewData['field'] = $sortField;
        $this->viewData['order'] = $order_seg;
        $this->viewData['FormData'] =$prevSessData;
        $this->viewData['adminid'] = $this->loggedInId;
        $this->viewData['dataQuery'] = $this->db->last_query();
        $this->viewData['title'] = 'Entery List';
        $this->load->view('staffentery/list', $this->viewData);
}

public function ajax_filter_select(){   
    $id = $this->input->post('auction_id');    
    $this->viewData['dbdata'] = $this->Entery_model->get_all_vehiche_entries($id);
    echo $this->load->view('staffentery/entry_ajax_listing', $this->viewData,true); 
   
    
}

  

function index_old()
    {
       isLoggedIn();
       customPagination();      
       $isAll = getStringSegment(3) ? getStringSegment(3) : false;
       if ($isAll && $isAll == 'all') {
            $this->session->unset_userdata('EnteryList');
        }
        $prevSessData = getSessionUserData('EnteryList');        
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

        //print_r($conditionArray);die;

        $contactDataCount = $this->Entery_model->record_count('staff_entery', $conditionArray);
        //echo $contactDataCount;die;
        $contactData = $this->Entery_model->get_records('staff_entery', $start, $this->perPage, $conditionArray);
        $pagination = createPagination('Staffentery/index', $contactDataCount, $this->perPage, $this->segment, $getField);
        $this->viewData['pagination'] = $pagination;
        $this->viewData['dbdata'] = $contactData;
        $this->viewData['getData'] = $getData;
        $this->viewData['pageNum'] = $page_num;
        $this->viewData['field'] = $sortField;
        $this->viewData['order'] = $order_seg;
        $this->viewData['FormData'] =$prevSessData;
        $this->viewData['adminid'] = $this->loggedInId;
        $this->viewData['dataQuery'] = $this->db->last_query();
        $this->viewData['title'] = 'Entery List';
        $this->load->view('staffentery/list', $this->viewData); 

    }

   



 function add()
    {
        isLoggedIn();
        if($_POST)
           {
             $array = array(
                "auction_id" => trim(_inputPost("auction")),
                "vehicle_registration" => trim(_inputPost("vehicle_rgistration")),
                "weight" => trim(_inputPost("Weight")),
                "weight_after" => trim(_inputPost("Weight_after")),
                "time_of_entry" => trim(_inputPost("entry_time")),
                "time_of_exit" => trim(_inputPost("exit_time")),
                "driver" => trim(_inputPost("Driver")),
                "scrape_dealer" => trim(_inputPost("scrap_dealer")),
                "created_by" => $this->loggedInId,
                "unique_code"=>$this->uniqidReal(16)
             );

            if($this->db->insert("staff_entery", $array))
                {
                    setSessionFlashData('success', 'Great! You have successfully create new entry.');
                        
                    redirect(base_url('staffentery/index/all'));
                }
                else
                {
                     setSessionFlashData('error', 'Whoops! some error occured.');
                     redirect(base_url('add-entery')); 
                }
            

           }

        $auctionList = $this->Auction_model->get_auctionList();
        
        $this->viewData['auctionList'] = $auctionList;
        $this->viewData['roles'] = getAllTableData("roles");
        $this->viewData['title'] = 'Add New Entery';
        $this->viewData['data'] = array();
        $this->load->view('staffentery/add', $this->viewData);
    }

    function edit($id)
        {       
            isLoggedIn();
                if($_POST)
                   {
                     $array = array(
                        "auction_id" => trim(_inputPost("auction")),
                        "vehicle_registration" => trim(_inputPost("vehicle_rgistration")),
                        "weight" => trim(_inputPost("Weight")),
                        "weight_after" => trim(_inputPost("Weight_after")),
                        "time_of_entry" => trim(_inputPost("entry_time")),
                        "time_of_exit" => trim(_inputPost("exit_time")),
                        "driver" => trim(_inputPost("Driver")),
                        "scrape_dealer" => trim(_inputPost("scrap_dealer")),
                        "updated_at" => date("Y-m-d H:i:s"),
                     );

                     $this->db->where("id", $id);

                    
                        if($this->db->update("staff_entery", $array))
                        {
                            
                            //echo $this->db->last_query();die;
                            setSessionFlashData('success', 'Great! You have successfully update the entry.');
                                
                            redirect(base_url('edit-entry/'.$id));
                        }
                        else
                        {
                             setSessionFlashData('error', 'Whoops! some error occured.');
                             redirect(base_url('edit-entry/'.$id)); 
                        }
                    

                   }
                   $auctionList = $this->Auction_model->get_auctionList();
        
                   $this->viewData['auctionList'] = $auctionList;
                $this->viewData['entery_details'] = getWhereWithId("staff_entery", array("id"=>$id));
                //print_r($userDetails); die;
                
               
                $this->viewData['id']= $id;
                $this->viewData['title'] = 'Update Entry';
                $this->viewData['data'] = array();
                $this->load->view('staffentery/edit', $this->viewData);

        }


 function view($id){
        isLoggedIn();
        $this->viewData['title'] = 'Vehicle Entry Details';       
        $this->viewData['entery_details'] = getWhereWithId("staff_entery", array("id"=>$id));
        $this->viewData['data'] = array();
        $this->viewData['adminid'] = $this->loggedInId;        
        $this->load->view('staffentery/view', $this->viewData);
    } 
    
    function delete()
    {
        $id = explode(",",$this->input->post('id'));
        //var_dump($id);die;
        $this->db->where_in("id",$id);
        if($this->db->delete("staff_entery"))
        {            
            echo setSessionFlashData('success', 'You have successfully delete the Auction.');
            
        }        
        else
        {
        echo setSessionFlashData('error', 'Data not found in our database.');       
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




function entryExcel()
    {
        $this->load->library("excel");
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);
        $table_columns = array("Sr no", "Vehicle Rgistration", "Weight Before Load","Weight After Load","Net Weight", "Entry Time", "Exit Time", "Driver Name", "Scrap Dealer", "Created At", "Updated At");
        $column = 0;
        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
            $column++;
        }

        $queries = $this->Entery_model->getExcel();

        if(count($queries) == 0)
        {
            setSessionFlashData('error', 'No Entry Is Found.');
            redirect(base_url('staffentery/index/all')); 
        }
     
        $excel_row = 2;
        $row1 = 1;
        foreach ($queries as $row) {

            if ($row["status"] == 0) {
                $status = "Pending";
            } else if ($row["status"] == 1) {
                $status = "Completed";
            } else {
                $status = "Rejected";
            }

            if($row["time_of_entry"] == "0000-00-00 00:00:00")
            {
                $row["time_of_entry"] = "";
            }

            if($row["time_of_exit"] == "0000-00-00 00:00:00")
            {
                $row["time_of_exit"] = "";
            }

            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row1);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row["vehicle_registration"]);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row["weight"]);
            $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row["weight_after"]);
            $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, ($row["weight_after"]-$row["weight"].'Kg'));
            $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row["time_of_entry"]);

            $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row["time_of_exit"]);

            $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row["driver"]);

            $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row["scrape_dealer"]);

           /* $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row["status"]);*/

            $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row["created_on"]);
            $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row["updated_at"]);
            $excel_row++;
            $row1++;
        }

        $filename="vehicleEntry".date('ymdhis').".xls";
        $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$filename);
        $object_writer->save('php://output');
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
            //CI->load->library('email');
            $account="help.cs@maadima.com";
            $password="Nah02427";
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = "smtp.office365.com";
            $mail->SMTPAuth= true;
            $mail->Port = 587;
            $mail->Username= $account;
            $mail->Password= $password;
            $mail->SMTPSecure = 'tls';
            $mail->From = $mailFrom;
            $mail->FromName= $mailFromName;
            $mail->isHTML(true);
            $mail->Subject = $msg_subject;
            $mail->Body = $full_msg_body;
            $mail->addAddress($mailTo);
            if(!$mail->send()){
             return true;
            }else{
              return false;
            }
        }
    }


}// class