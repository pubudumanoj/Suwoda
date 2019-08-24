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
class Voucher_control extends CI_Controller {

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

    public function index($physician, $date) {


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
        $custom_booking_details = $this->booking_model->get_custom_booking_details($email_decoded, $date); // check custom booking details if available
        $booking_count = $this->booking_model->get_booking_count_only($email_decoded, $date); // check custom booking details if available

        

        $this->load_view($physician_default_setup, $custom_booking_details, $booking_count, $date); //send the information to the load view method
    }

    public function add_information() {
        
    }

    public function add_default_booking_schedule() {
        
    }

    public function load_view($physician_default_setup, $custom_booking_details, $booking_count, $date) {

        $data['title'] = ucfirst('Setup Booking Schedule');
        $data['physician_default_setup'] = $physician_default_setup;
        $data['custom_booking_details'] = $custom_booking_details;
        $data['booking_count'] = $booking_count;
        $data['booking_date'] = $date;
        $data['physician_mail'] = $this->session->userdata('email');
        $data['role'] = $this->session->userdata('role');
//        $data['lname'] = $this->session->userdata('lname');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('booking/booking_voucher', $data);
        $this->load->view('templates/footer', $data);
    }

}

?>