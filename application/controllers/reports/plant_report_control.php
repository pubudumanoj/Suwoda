<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Disease_report_control
 *
 * @author Pubudu Nawarathna
 */
class Plant_report_control extends CI_Controller {

    private $logged_in;
    private $type = 'all';
   

    function __construct() {

        parent::__construct();
        $this->load->model('reports/plant_report_model');
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index() {
       
        $result_plant_region = $this->view_plant_region();
        $result_plant_status = $this->view_plant_status();
        $result_plant_amount_by_year = $this->view_plant_amount_by_year();
        
      //  echo json_encode($result_plant_amount_by_year);
     
 
       
       
      $this->load_view($result_plant_region, $result_plant_status, $result_plant_amount_by_year);
      
    }
    
    
    public function view_plant_region() {

        

        $result = $this->plant_report_model->view_plant_region();
        
      $table = array();
$table['cols'] = array(
	/* define your DataTable columns here
	 * each column gets its own array
	 * syntax of the arrays is:
	 * label => column label
	 * type => data type of column (string, number, date, datetime, boolean)
	 */
    array('label' => 'region', 'type' => 'string'),
	array('label' => 'count', 'type' => 'number')
	// etc...
);

$rows = array();
foreach ($result as $r) {
    $temp = array();
	// each column needs to have data inserted via the $temp array
	$temp[] = array('v' => $r->region);
	$temp[] = array('v' => intval($r->count));
	// etc...
	
	// insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

return $table;
       
    }
    public function view_plant_status() {
// view how many diseases are reviewed and how many are not
        

        $result = $this->plant_report_model->view_plant_status();
        
      $table = array();
$table['cols'] = array(
	/* define your DataTable columns here
	 * each column gets its own array
	 * syntax of the arrays is:
	 * label => column label
	 * type => data type of column (string, number, date, datetime, boolean)
	 */
    array('label' => 'status', 'type' => 'string'),
	array('label' => 'count', 'type' => 'number')
	// etc...
);

$rows = array();
foreach ($result as $r) {
    $temp = array();
	// each column needs to have data inserted via the $temp array
	$temp[] = array('v' => $r->status);
	$temp[] = array('v' => intval($r->count));
	// etc...
	
	// insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

return $table;
       
    }
    public function view_plant_amount_by_year() {
        
        $result = $this->plant_report_model->view_plant_amount_by_year();
        
      $table = array();
$table['cols'] = array(
	/* define your DataTable columns here
	 * each column gets its own array
	 * syntax of the arrays is:
	 * label => column label
	 * type => data type of column (string, number, date, datetime, boolean)
	 */
    array('label' => 'year', 'type' => 'string'),
	array('label' => 'count', 'type' => 'number')
	// etc...
);

$rows = array();
foreach ($result as $r) {
    $temp = array();
	// each column needs to have data inserted via the $temp array
	$temp[] = array('v' => $r->year);
	$temp[] = array('v' => intval($r->count));
	// etc...
	
	// insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

return $table;
       
    }

    public function load_view($result_plant_region,$result_plant_status, $plant_amount_by_year) {

        $data['title'] = ucfirst('Plant Reports Page');
       // $data['error'] = $error;
        $data['result_plant_region'] = $result_plant_region;
        $data['result_plant_status'] = $result_plant_status;
        $data['result_plant_amount_by_year'] = $plant_amount_by_year;
      //  $data['type'] = $type;
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('reports/plant', $data);
        $this->load->view('templates/footer', $data);
    }
   

}

?>
