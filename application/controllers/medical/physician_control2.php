<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of information_control
 *
 * @author Pubudu Nawarathna
 */
class Physician_control extends CI_Controller {

    private $logged_in;
    private $type = 'all';
    private $search = null;

    function __construct() {

        parent::__construct();
        $this->load->model('medical/medical_center_model');
        $this->load->model('disease/Disease_model');

        if ($this->session->userdata('logged_in')) {
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
        $this->type = 'all';
        $this->search = '';
        $this->offset = 0;
        $searchkey = '';

        /*
         * get center information using default literals.
         * pass them to view_all_disease method in this class
         * $result stores the data
         * 
         */
        
        $result = $this->view_physicians($this->type, $searchkey, $this->offset);
      $fields = $this->Disease_model->get_all_fields();
    
      

        /*
         * count number of rows in the result and store them in the variable $current_offset
         *          * 
         */
        $current_offset = count($result);

        /*
         * get the total count of centers in the db
         */
        $this->total_count = count($result);

        //call load_view method and send the parameters

        $this->load_view($result, $this->type, $this->search, $this->offset, $current_offset, $this->total_count);
         
    }
    

    public function select_view() {

        /*
         * when the search button of the center page is clicked this method is called
         * send the values of text fields and combo boxes and limit
         * use to filter data according to provided parameter values
         */
        $type = $this->input->post('center_type');
        
        $search_key = $this->input->post('center_search_key');
        $result = $this->view_centers($type, $search_key, 0);
        $current_offset = count($result);
        $this->total_count = count($result);
        //total count is according to the parameter values

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
        $this->total_count = $this->count_all_centers($type, $search_key, 0);
        $result = $this->view_centers($type, $search_key, $offset);

        $this->load_view($result, $type, $search_key, $offset, $current_offset, $this->total_count);
    }

    public function count_all_centers($type, $search_key, $offset) {
        /*
         * count the number of results for specific parameters
         */
        return count($this->medical_center_model->count_all_centers($type, $search_key, $offset));
    }

    public function view_physicians($type, $searchkey, $offset) {

        return $this->medical_center_model->view_physicians($type, $searchkey, $offset);
    }

    public function load_view($result, $type, $search, $offset, $current_offset, $total_count) {
        
       
        $data['title'] = ucfirst('View Physicians');
        $data['result'] = $result;
        $data['current_offset'] = $current_offset;
        $data['total_count'] = $total_count;
        $data['offset'] = $offset;
        $data['search'] = $search;
        $data['fields'] = $fields;
        $data['type'] = $type;
        $data['role'] = $this->session->userdata('role');
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('medical/physician', $data);
        $this->load->view('templates/footer', $data);
    }

}

?>
 