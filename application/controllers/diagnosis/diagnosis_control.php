<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * Short Description: class Diagnosis_control- Controll all disease diagnosis functions
 * 
 * Long Description:
 * Show the view file disease_diagnosis when call the class.
 * Send search data to disease_diagnosis model class.
 * link with view disease_dagnosis and model disease_diagnosis model
 * 
 * @author Pubudu Nawarathna <pubudumanoj@gmail.com>
 * @category Diagnosis
 * @since File available since Release 1.0.0
 * @access public
 * 
 */
class Diagnosis_control extends CI_Controller {

    /**
     * @access private
     * Use to verfiy user is logged in or not.
     */
    private $logged_in;

    function __construct() {
        /**
         * Short description: call super class constructor.
         * 
         */
        parent::__construct();

        /*
         * When user is logging in to system
         * SESSIONS are declared.
         * from anywhere these sessions can access using
         * $this->session->userdata('SESSION_NAME');
         * If user is logged in @varibale $logged_in set to True
         * otherwise it is set to False.
         * 
         */

        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {
            $this->logged_in = FALSE;
        }
    }

    public function index() {
        /**
         * Short description: default function in the class
         * when user is not specify a function this method will invoke
         * 
         * @param null
         * @return null
         * 
         * Call to load_view function in this class
         * 
         */
        $this->load_view();
    }

    public function load_view() {

        /**
         * @return null Nothing return
         * 
         * Description: create $data array
         * Push variables into $data array
         * Call logged_in view file and pass the data array to the view.
         */
        /*
         * Capitalise the first letter and set $title varibale for view file title
         */
        $data['title'] = ucfirst('disease Diagnosis System');
        /*
         * set the first name of the logged user into $fname
         */
        $data['fname'] = $this->session->userdata('fname');
        /*
         * set the first name of the logged user into $fname
         */
        $data['lname'] = $this->session->userdata('lname');
        /*
         * set the $logged_in variable value in to logged_in varibale in $data array
         */
        $data['logged_in'] = $this->logged_in;

        /*
         * Call header view file.
         */
        $this->load->view('templates/header', $data);

        /*
         * Call the disease_diagnosis view file
         */
        $this->load->view('diagnosis/disease_diagnosis', $data);

        /*
         * Call the footer view file
         */
        $this->load->view('templates/footer', $data);
    }

}

?>