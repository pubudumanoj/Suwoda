<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Disease_report_control
 *
 * @author Pubudu Nawarathna
 */
class User_report_control extends CI_Controller {

    private $logged_in;
    private $type = 'all';

    function __construct() {

        parent::__construct();
$this->load->model('reports/user_report_model');
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index() {

          $user_registration_by_year = $this->view_user_registration_by_year();
          $physician_registration_by_year = $this->view_physician_registration_by_year();
        $this->load_view($user_registration_by_year, $physician_registration_by_year);
    }
    
     public function view_user_registration_by_year() {
        
        $result = $this->user_report_model->view_user_registration_by_year();
        
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
     public function view_physician_registration_by_year() {
        
        $result = $this->user_report_model->view_physician_registration_by_year();
        
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

    public function load_view($user_registration_by_year, $physician_registration_by_year) {

        $data['title'] = ucfirst('User Reports Page');
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['user_registration_by_year'] = $user_registration_by_year;
        $data['physician_registration_by_year'] = $physician_registration_by_year;
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('reports/user', $data);
        $this->load->view('templates/footer', $data);
    }

}

?>
