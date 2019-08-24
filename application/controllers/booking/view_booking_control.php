<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * Short Description: class Disease_control- Controll functions in medical information reslut showing
 * 
 * Long Description:
 * Show the view file information when call the class.
 * Send search data to Information model class.
 * link with view Information and model Information model
 * 
 * @author Pubudu Nawarathna <pubudumanoj@gmail.com>
 * @category Information
 * @since File available since Release 1.0.0
 * @access public
 * 
 */
class View_booking_control extends CI_Controller {

    /**
     * @access private
     * Use to verfiy user is logged in or not.
     */
    private $logged_in;

    /**
     * @access private
     * variable store the user requested information review
     * values : all, rev, unr
     */
    private $review = 'all';

    /**
     * @access private
     * store the disease type
     */
    private $type = 'all';

    /**
     * @access private
     * store the reviewer email
     * 
     */
    private $reviewer = null;

    /**
     * @access private
     * store the user search key word
     * 
     */
    private $search = null;

    /**
     * @access private
     * store the first start line of the data in the table
     * 
     */
    private $offset = 0;
    
    /**
     * @access private
     * store the total hits for that specific search
     * this total number will change with each query
     * 
     */
    private $total_count = 0;

    function __construct() {

        parent::__construct();
        $this->load->model('booking/Booking_model');
        /*
         * create a variable logged_in with value true if the user is logged in
         */
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
        } else {
            $this->logged_in = FALSE;
        }
    }

    public function index() {

        /*
         * get the total booking available in the db
         */
       $this->get_active_booking();
        
        //call load_view method and send the parameters
       
    }

    public function get_active_booking() {
        /*
         * get all booking information
         * 
         */
        if ($this->logged_in AND ($this->session->userdata('role')==1 || $this->session->userdata('role')==2)) {
            $result = $this->Booking_model->get_active_booking();
              $this->load_view($result);
        }
        else{
            ?>
<script>
                        alert("Please log as a admin or physician"); </script>
<?php
        }
        
    }

  
    public function load_view($result) {

      

        $data['title'] = ucfirst('View Booking');
        $data['result'] = $result;
       $data['fname'] =  $this->session->userdata('fname'); //get signed in user's first name
        $data['lname'] =  $this->session->userdata('lname'); //get signed in user's last name
          $data['role'] = $this->session->userdata('role');
        
        $data['logged_in'] = $this->logged_in;

        $this->load->view('templates/header', $data);
        $this->load->view('booking/view_booking', $data);
        $this->load->view('templates/footer', $data);
    }
    

}

?>
