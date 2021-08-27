<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendmail extends CI_Controller {

	    public function __construct(){
        parent::__construct();
        $this->load->model('auction_model');  // load the Auction model
     
    }

	public function index()
	{
		$this->load->library('email');	
		$config = Array(
            'protocol' => 'tls',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 587,
            'smtp_user' => 'info@ubuyexpress.com',
            'smtp_pass' => 'SDe@ubuyexp@123',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
          );
		$this->email->initialize($config);		
		$this->email->set_newline("\r\n");
        $this->email->from(EMAIL, 'Scrap Dealer');		
		$this->email->to('sachanprashant223@gmail.com');	
		$this->email->cc('rahulr@triazinesoft.com');
		$this->email->set_mailtype('html');
		$this->email->subject("msg check");
        $this->email->message("This is test message for check");
		if(!$this->email->send()){
		        echo $this->email->print_debugger();die;
             
		}else{
		echo "Email Snt";
		}
	}



function sendBackgroundEmail()
    {
         if (!empty($_REQUEST)) {

            $auctionId = $_REQUEST['1'];

            
            $this->db->select("fullname, email, phone")->from("users");
            $query = $this->db->get();
            $allEmails = $query->result_array();

            $fp = fopen('perameterRequest.txt', 'w+');
            fwrite($fp, print_r($allEmails, 1));

	        $auction_details = $this->auction_model->get_auction_details($auctionId); 
	        //print_r($auction_details); die;

	        $html = "

	        <p>New Auction is created now please BID for thes auction.</p>

	        <p>Auction Details Below:</p>

	        <p>Material Code : ".$auction_details["material_code"]."</p>
	        <p>Plant Code : ".$auction_details["plant_code"]."</p>
	        <p>Material Type : ".$auction_details["material_type"]."</p>
	        <p>Material Weight : ".$auction_details["material_weight"]."</p>
	        <p>Material Description : ".$auction_details["material_description"]."</p>
            <p>Auction Start Date : ".$auction_details["auction_start_date"]."</p>
            <p>Auction Close Date : ".$auction_details["auction_close_date"]."</p>
	        
	        ";

	        $subject = "New Auction Creation";

            foreach($allEmails as $row)
            {
            	$backEmailId = $row["email"];

            	$namE = $row["fullname"];

            	$phoneNumber = "91".$row["phone"];

            	if(!empty($namE) && !empty($phoneNumber))
            	{
            		$this->sendAuctionMessage($namE, $phoneNumber);
            	}


            	$this->send_mail($backEmailId, $subject, $html);

            }


            $this->db->select("phone, email, name")->from("admins");
            $this->db->where_in("role_type", array(3,4,5,6));
            $query = $this->db->get();
            $allApproverEmails = $query->result_array();


            $htmlForApprover = "

	        <p>Dear sir,  <br>
			New Auction has been open  kindly check and approve 
	        <p>Auction Details Below:</p>

	        <p>Material Code : ".$auction_details["material_code"]."</p>
	        <p>Plant Code : ".$auction_details["plant_code"]."</p>
	        <p>Material Type : ".$auction_details["material_type"]."</p>
	        <p>Material Weight : ".$auction_details["material_weight"]."</p>
	        <p>Material Description : ".$auction_details["material_description"]."</p>
            <p>Auction Start Date : ".$auction_details["auction_start_date"]."</p>
            <p>Auction Close Date : ".$auction_details["auction_close_date"]."</p>
	        
	        ";

	        foreach($allApproverEmails as $row1)
            {
            	$backEmailIdApp = $row1["email"];


            	$namE = $row1["name"];

            	$phoneNumber = "91".$row1["phone"];

            	if(!empty($namE) && !empty($phoneNumber))
            	{
            		$this->sendAuctionMessage($namE, $phoneNumber);
            	}

            	$this->send_mail($backEmailIdApp, $subject, $htmlForApprover);

            }

            //$this->send_mail($allApproverEmails, $subject, $htmlForApprover);

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


    function sendAuctionMessage($name = "monu", $phone = "919717943954")
    {
    	$phoneNumber = $phone;
    	$message = "Dear ".trim($name)." New auction has been uploaded kindly check Ras E Tendor Mobile AppTeam Relia Advisory Services LLP";
    	$messageEncoded = str_replace(" ","%20", $message);

		$url = "https://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&send_to=".$phoneNumber."&msg=".$messageEncoded."&msg_type=TEXT&userid=2000199273&auth_scheme=plain&password=K9AEgF6iA&v=1.1&format=text";
		$ch = curl_init();
		$timeout = 5;

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

		$data = curl_exec($ch);

		curl_close($ch);

		return true;
    }
   



}
