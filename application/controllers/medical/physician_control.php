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
class Physician_control extends CI_Controller {

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
        $this->load->model('medical/medical_center_model');
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
         * default main method
         * call when normally request the class
         * initialize all the varaibles to default values
         */
        $this->type = 'all';
        $this->search = '';
        $this->offset = 0;
        $searchkey = '';

        /*
         * get disease information using default laterals.
         * pass them to view_all_disease method in this class
         * $result stores the data
         * 
         */
        $result = $this->view_physicians($this->type, $searchkey, $this->offset);
        //  $result = $this->view_all_disease($this->review, $this->type, $searchkey, $this->offset);
        /*
         * count number of rows in the result and store them in the variable $current_offset
         *          * 
         */
        $current_offset = count($result);
        $this->total_count = count($result);

        /*
         * get the total count of diseases available in the db
         */


        //call load_view method and send the parameters
        $this->load_view($result, $this->type, $this->search, $this->offset, $current_offset, $this->total_count);
    }

    public function view_physicians($type, $searchkey, $offset) {
        /*
         * get all physician information using parameters of the method
         * offset, search key, type and review will be provided
         */
        return $this->medical_center_model->view_physicians($type, $searchkey, $offset);
    }

    public function select_view() {
       
        /*
         * when the search button of the disease page is clicked this method is called
         * send the values of text fields and combo boxes and limit
         * use to filter data according to provided parameter values
         */
        
        $type = $this->input->post('field_type');
        $search_key = $this->input->post('physician_search_key');

        $result = $this->medical_center_model->view_physicians($type, $search_key, 0);
        $current_offset = count($result);
        //total count is according to the parameter values
        $this->total_count = count($result);
        $this->load_view($result, $type, $search_key, 0, $current_offset, $this->total_count);
    }

    public function select_view_next($type, $search_key, $offset, $current_offset) {
        /*
         * when user clicks on next button on the page this method gives the next offset data rows from the db.
         * if search key is null then it is assigned to ''
         */
        if ($search_key === 'none') {
            $search_key = '';
        }
        $this->total_count = count($this->view_physicians($type, $search_key, 0));
        $result = $this->medical_center_model->view_physicians($type, $search_key, $offset);
        $this->load_view($result, $type, $search_key, $offset, $current_offset, $this->total_count);
    }

    public function load_view($result,  $type, $search, $offset, $current_offset, $total_count) {

        $field_result = $this->medical_center_model->get_all_fields();

        $data['title'] = ucfirst('View Physicians');
        $data['result'] = $result;
        $data['field_result'] = $field_result;
        $data['current_offset'] = $current_offset;
        $data['total_count'] = $total_count;
        $data['role'] = $this->session->userdata('role');
     
        $data['type'] = $type;
        $data['offset'] = $offset;
        $data['search'] = $search;
        $data['logged_in'] = $this->logged_in;

        $this->load->view('templates/header', $data);
        $this->load->view('medical/physician', $data);
        $this->load->view('templates/footer', $data);
    }

}

?>
