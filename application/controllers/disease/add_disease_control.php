<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * Short Description: class Add_disease_control
 * -Controll functions related to add new disease information
 * in to the database.
 * 
 * Long Description:
 * Show the view file Add_disease when call the class.
 * Send user input data to Add_disease model class.
 * link with view Add_disease and model Disease_model
 * 
 * @author Pubudu Nawarathna <pubudumanoj@gmail.com>
 * @category Disease
 * @since File available since Release 1.0.0
 * @access public
 * 
 */
class Add_disease_control extends CI_Controller {

    /**
     * @access private
     * Use to verfiy user is logged in or not.
     */
    private $logged_in;

    /**
     * @access private
     * store detail reviewer
     * this is only send to database if an admin insert the details
     * 
     */
    private $role = null;

    function __construct() {
        /*
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
        $this->load->model('disease/disease_model');
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
        $result = $this->disease_model->get_all_fields(); // get Type/Area of the Disease information to the page from db

        $this->load_view($result); //send the information to the load view method
    }

    public function validate_information() {

        /**
         * @param null
         * @return null
         * 
         * Description: validate_information
         * server side validation of user input details
         * xss_clean - avoid cross reference attacks and sql injections
         * required - this field cannot be empty
         * trim - trim spaces
         * method - set_rules
         * set rule parameters $field - field name, $label - field name label, $rules - validation rules followed by |
         * 
         */
        $this->load->library('form_validation');
        $this->form_validation->set_rules('disease_name', 'Disease Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('disease_type', 'Disease Type', 'trim|xss_clean');
        $this->form_validation->set_rules('disease_plant', 'Treatment plants', 'trim|xss_clean');
        $this->form_validation->set_rules('disease_symptoms', 'Symptoms', 'trim|xss_clean');
        $this->form_validation->set_rules('disease_treatments', 'Treatment', 'trim|xss_clean');
        $this->form_validation->set_rules('disease_avoid', 'Avoid Instructions', 'trim|xss_clean');

        /*
         * 
         * If there is no validation erros call add_information function
         * Otherwise call load view method and automatically pass the errors
         */
        if ($this->form_validation->run() == FALSE) {
            $result = $this->disease_model->get_all_fields();

            $this->load_view($result);
        } else {

            $this->add_information();
        }
    }

    public function add_information() {

        /**
         * @param null
         * @return null
         * 
         * Description: add_information
         * create variables and send these varibales to model class to insert to database
         * 
         */
        $name = $this->input->post('disease_name');
        $type = $this->input->post('disease_type');
        $symptoms = $this->input->post('disease_symptoms');
        $treatments = $this->input->post('disease_treatments');
        $avoid = $this->input->post('disease_avoid');
        $submitter = $this->session->userdata('email');
        $review = $this->input->post('review');

        if ($this->role === 3 &&$this->logged_in) {

            $review = 'unr';
            $reviewer = NULL;
        } else {
            if ($review === "unr") {
                $review = 'unr';
                $reviewer = NULL;
            } else {
               
                $review = 'rev';
                $reviewer = $this->session->userdata('email');
            }
        }
       
        $dbRet;
       
     $dbRet=  $this->disease_model->add_disease($name, $symptoms, $treatments, $submitter, $review, $reviewer, $type, $avoid);
        
        if ($this->input->post('disease_plant') != "") {
        $max = $this->disease_model->get_max();
        $plnts_row = explode("\n", $_POST['disease_plant']);
        foreach ($plnts_row as $v1) {
            $id = $this->disease_model->get_id(trim($v1));
            foreach ($id as $v2) {
               $this->disease_model->add_plants($max[0]->disease_id, $v2->plant_id);
            }
        }
        }
        if ($dbRet) {
            ?>
            <script type="text/javascript">
                alert("Succsefully Added New Disease");
            </script>
            <?php

            redirect('disease', 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");

            </script>  
            <?php

            redirect('disease', 'refresh');
        }
    }
    public function load_view($result) {

        $data['title'] = ucfirst('Add new Disease');
        $data['result'] = $result;
         $data['role'] = $this->session->userdata('role');
//        $data['lname'] = $this->session->userdata('lname');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('disease/add_disease', $data);
        $this->load->view('templates/footer', $data);
    }

}
?>