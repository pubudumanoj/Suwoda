<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 
 * Short Description: class Information_control- Controll functions in medical information reslut showing
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
class Information_control extends CI_Controller {

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
     * store the reviewer email
     */
    private $type = 'all';

    /**
     * @access private
     * store the reviewer email
     */
    private $reviewer = null;

    /**
     * @access private
     * store the user search key word
     */
    private $search = null;

    /**
     * @access private
     * store the first start line of the data in the table
     */
    private $offset = 0;

    /**
     * @access private
     * store the total hits for that specific search
     * this total number will change with each query
     */
    private $total_count = 0;

    function __construct() {

        parent::__construct();
        $this->load->model('information/information_model');
        if ($this->session->userdata('logged_in')) {
            /*
             * create a variable logged_in with value true if the user is logged in
             */
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
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
        $this->review = 'all';
        $this->type = 'all';
        $this->search = '';
        $this->offset = 0;
        $searchkey = '';


        /*
         * get information data using default laterals.
         * pass them to view_all_information method in this class
         * $result stores the data
         */

        $result = $this->view_all_information($this->review, $this->type, $searchkey, $this->offset);
        /*
         * count number of rows in the result and store them in the variable $current_offset
         *          * 
         */
        $current_offset = count($result);
        /*
         * get the total count of information available in the db
         */
        $this->total_count = $this->count_all_information($this->review, $this->type, $searchkey, $this->offset);
        //call load_view method and send the parameters
        $this->load_view($result, $this->review, $this->type, $this->search, $this->offset, $current_offset, $this->total_count);
    }

    public function view_all_information($review, $type, $search_key, $offset) {
        /*
         * get all  information data using parameters of the method
         * offset, search key, type and review will be provided
         */
        return $this->information_model->get_all_information($review, $type, $search_key, $offset);
    }

    public function count_all_information($review, $type, $search_key, $offset) {
        /*
         * count the number of results for specific parameters
         */
        return $this->information_model->count_all_information($review, $type, $search_key, $offset);
    }

    public function select_view() {
        /*
         * when the search button of the disease page is clicked this method is called
         * send the values of text fields and combo boxes and limit
         * use to filter data according to provided parameter values
         */
        $review = $this->input->post('information_status');
        $type = $this->input->post('information_type');
        $search_key = $this->input->post('info_search_key');

        $result = $this->information_model->get_all_information($review, $type, $search_key, 0);
        $current_offset = count($result);
        //total count is according to the parameter values
        $this->total_count = $this->count_all_information($review, $type, $search_key, 0);

        $this->load_view($result, $review, $type, $search_key, 0, $current_offset, $this->total_count);
    }

    public function select_view_next($review, $type, $search_key, $offset, $current_offset) {
        /*
         * when user clicks on next button on the page this method gives the next offset data rows from the db.
         * if search key is null then it is assigned to ''
         */
        if ($search_key === 'none') {
            $search_key = '';
        }

        $result = $this->information_model->get_all_information($review, $type, $search_key, $offset);
        $this->total_count = $this->count_all_information($review, $type, $search_key, 0);
        $this->load_view($result, $review, $type, $search_key, $offset, $current_offset, $this->total_count);
    }

    public function load_view($result, $review, $type, $search, $offset, $current_offset, $total_count) {



        $data['title'] = ucfirst('View Information');
        $data['result'] = $result;
        $data['role'] = $this->session->userdata('role');
        $data['current_offset'] = $current_offset;
        $data['total_count'] = $total_count;
        $data['review'] = $review;
        $data['type'] = $type;
        $data['offset'] = $offset;
        $data['search'] = $search;
        $data['logged_in'] = $this->logged_in;

        $this->load->view('templates/header', $data);
        $this->load->view('information/information', $data);
        $this->load->view('templates/footer', $data);
    }

    public function validate_information() {

        $this->load->library('form_validation');
        $result = $this->view_information($this->type);
        // field name, error message, validation rules
        //personal details
        $this->form_validation->set_rules('title', 'Information title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('type', 'Information type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('desc', 'Description', 'required|xss_clean');


        if ($this->form_validation->run() == FALSE) {


            $this->load_view($result, $this->type, $this->search);
        } else {
            $this->add_information();

            //   $this->thank();
            // log karala redirect karanna code eka liyanna
        }
    }

    public function add_information() {

        $title = $this->input->post('title');
        $type = $this->input->post('type');
        $desc = $this->input->post('desc');
        $review = $this->input->post('review');



        if ($this->role === 3 && $this->logged_in) {

            $review = 'unr';
            $reviewer = NULL;
        } else {

            if ($review === "unr") {
                echo $review . "as";
                $review = 'unr';
                $reviewer = NULL;
            } else {

                $review = 'rev';
                $reviewer = $this->session->userdata('email');
            }
        }

        $submitter = $this->session->userdata('email');


        $this->information_model->add_information($title, $type, $desc, $review, $submitter, $reviewer);
    }

    public function view_information($type) {

        $type = $this->type;

        return $this->information_model->view_info($type);
    }

}

?>
