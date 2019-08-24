<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class site extends CI_Controller {
    
    private $logged_in;
    private $role;

    function __construct() {

        parent::__construct(); // calling constructor of the super class
        
        //cheking whether user is signed in or not. if not logged in assigned as false;
        if ($this-> session->userdata('logged_in')) {
            $this->logged_in =TRUE;
            $this->role = $this->session->userdata('role');         
        }
        else{
          
             $this->logged_in =FALSE;
           
        }
    }

    /**
     * @param page $page accept page names and show coresponding view file
     * @return void no return value 
     * @author Pubudu Nawarathna
     */
    function index($page = 'home') {

        
         $this->load->model('home_model');
         $latest_plant= $this->home_model->get_latest_plant();
         $latest_disease= $this->home_model->get_latest_disease();
         $latest_medical_information= $this->home_model->get_latest_medical_information();
        if (!file_exists('application/views/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            
            show_404();
        }
       

        $data['title'] = ucfirst($page); // Capitalize the first letter
        $data['logged_in'] = $this->logged_in;
        $data['role'] = $this->role; //get signed in user's role
        $data['fname'] =  $this->session->userdata('fname'); //get signed in user's first name
        $data['lname'] =  $this->session->userdata('lname'); //get signed in user's last name
        $data['latest_plant'] =  $latest_plant; //get latest plant information
        $data['latest_disease'] =  $latest_disease; //get latest plant disease
        $data['latest_medical_information'] =  $latest_medical_information; //get latest medical information
        // $data is the data array to be send to the view file
        
        $this->load->view('templates/header', $data); //load header before the body
        if ($page=='home') {
            $this->load->view('templates/slideshow', $data); //load the slideshow
        }
        
        $this->load->view($page, $data); // body file load
        $this->load->view('templates/footer', $data); // load the footer
        // $this->load->view('home');
    }

   

    /**
     * @return void no return value 
     */
}

?>
