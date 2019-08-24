<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * @author Pubudu Nawarathna <pubudumanoj@gmail.com>
 * @category Booking
 * @since File available since Release 1.0.0
 * @access public
 * 
 */
class Booking_control extends CI_Controller {

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
        $this->load->model('booking/booking_model');
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {
            $this->logged_in = FALSE;
        }
    }

    public function index($physician) {


        // decode email address
        $email_decoded = base64_decode(strtr($physician, '-_', '+/'));


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
        $physician_default_setup = $this->booking_model->check_default_set_physician($email_decoded); // get default booking settings of the physician
        $booking_count = $this->booking_model->get_booking_count($email_decoded); // check booking details 
       

        $this->load_view($physician_default_setup,$booking_count ); //send the information to the load view method
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
        /*
          $name = $this->input->post('disease_name');
          $type =  $name = $this->input->post('disease_name'); $this->input->post('disease_type');
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
         * 
         */
    }

    public function add_booking_validate_information() {
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
        $this->form_validation->set_rules('start_time', 'Treatment Start time', 'trim|required|xss_clean');
        $this->form_validation->set_rules('max_patients', 'Max pateint for a day', 'trim|xss_clean');



        /*
         * 
         * If there is no validation erros call add_information function
         * Otherwise call load view method and automatically pass the errors
         */
        if ($this->form_validation->run() == FALSE) {
            $default_set = $this->booking_model->check_default_set(); // get Type/Area of the Disease information to the page from db
            $this->load_view($default_set);
        } else {

            $this->add_default_booking_schedule();
        }
    }


    public function add_default_booking_schedule() {
        $start_time = $this->input->post('start_time');
        $max_patients = $this->input->post('max_patients');
        $work_on_weekends = $this->input->post('work_on_weekends');
        if ($work_on_weekends == "on") {
            $work_on_weekends = 'y';
        } else {
            $work_on_weekends = 'n';
        }
        $dbRet = $this->booking_model->add_default_booking_schedule($start_time, $max_patients, $work_on_weekends);

        if ($dbRet) {
            ?>
            <script type="text/javascript">
                alert("Succsefully Added Default Booking Schedule");
            </script>
            <?php

            redirect('booking_setup', 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");

            </script>  
            <?php

            redirect('booking_setup', 'refresh');
        }
    }

   
    public function load_view($physician_default_setup, $booking_count) {

        $data['title'] = ucfirst('Setup Booking Schedule');
        $data['physician_default_setup'] = $physician_default_setup;
        $data['booking_count'] = $booking_count;
         $data['physician_mail'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');
//        $data['lname'] = $this->session->userdata('lname');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('booking/booking', $data);
        $this->load->view('templates/footer', $data);
    }

}
?>