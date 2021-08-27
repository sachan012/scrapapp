<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Error_404 extends CI_Controller
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


    function index()
    {
        isLoggedIn();
        $this->viewData['title'] = '404 Error Page';
        $this->viewData['data'] = array();
        $this->load->view('error_404', $this->viewData);
    }


}