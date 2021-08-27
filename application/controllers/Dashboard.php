<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public $viewData = array();
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("basic_helper");
        $this->load->model("Common_model");
        $this->loggedInId = trim(getSessionUserData("id"));
        if (getSessionUserData("logged_in") == FALSE && getSessionUserData("id") == "" && empty(getSessionUserData("id"))) 
        {
            // if user is not login then it will rediret to the login page of panel
            redirect(base_url(''));  
        }
    }

    public function index()
    {
        //log_message('info', 'The purpose of some variable is to provide some value.');
        isLoggedIn();
        $TotalStaff = $this->Common_model->total_count('admins', 'id', array("role_type"=>2));
        $TotalUsers = $this->Common_model->total_count('users', 'id', array());

        $TotalEntries = $this->Common_model->total_count('staff_entery', 'id', array());
        
        $this->viewData['title'] = 'Admin Panel | Dashboard';
        $this->viewData['TotalStaff'] = $TotalStaff;
        $this->viewData['TotalUsers'] = $TotalUsers;

        $this->viewData['TotalEntries'] = $TotalEntries;

        $this->viewData['title'] = 'Dashboard';
        $this->viewData['roleId'] = $this->loggedInId;
        $this->viewData['data'] = array();
        $this->load->view('Dashboard', $this->viewData);
    }
}
