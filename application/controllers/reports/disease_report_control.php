<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Disease_report_control
 *
 * @author Pubudu Nawarathna
 */
class Disease_report_control extends CI_Controller {

    private $logged_in;
    private $type = 'all';
   

    function __construct() {

        parent::__construct();
        $this->load->model('reports/disease_report_model');
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index() {
       
        $result_disease_types = $this->view_disease_types();
        $result_disease_status = $this->view_disease_status();
        $result_disease_amount_by_year = $this->view_disease_amount_by_year();
     
 
       
       
      $this->load_view($result_disease_types, $result_disease_status, $result_disease_amount_by_year);
      
    }
    
    
    public function view_disease_types() {

        

        $result = $this->disease_report_model->view_disease_types();
        
      $table = array();
$table['cols'] = array(
	/* define your DataTable columns here
	 * each column gets its own array
	 * syntax of the arrays is:
	 * label => column label
	 * type => data type of column (string, number, date, datetime, boolean)
	 */
    array('label' => 'name', 'type' => 'string'),
	array('label' => 'count', 'type' => 'number')
	// etc...
);

$rows = array();
foreach ($result as $r) {
    $temp = array();
	// each column needs to have data inserted via the $temp array
	$temp[] = array('v' => $r->name);
	$temp[] = array('v' => intval($r->count));
	// etc...
	
	// insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

return $table;
       
    }
    public function view_disease_status() {
// view how many diseases are reviewed and how many are not
        

        $result = $this->disease_report_model->view_disease_status();
        
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
    public function view_disease_amount_by_year() {
        
        $result = $this->disease_report_model->view_disease_amount_by_year();
        
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

    public function load_view($result_disease_type,$result_disease_status, $disease_amount_by_year) {

        $data['title'] = ucfirst('Disease Reports Page');
       // $data['error'] = $error;
        $data['result_disease_type'] = $result_disease_type;
        $data['result_disease_status'] = $result_disease_status;
        $data['result_disease_amount_by_year'] = $disease_amount_by_year;
      //  $data['type'] = $type;
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('reports/disease', $data);
        $this->load->view('templates/footer', $data);
    }
    
    
public function delete($id){

    $result =   $this->information_model->delete_page($id);
   
    if ($result) {
     
        ?>
<script type="text/javascript">

alert("Successfully Deleted");


</script>
<?php
   redirect( 'information/', 'refresh'); 
    }
    else{
    ?>
<script type="text/javascript">

alert("Information not found");


</script>
<?php
   redirect( 'information/', 'refresh'); 
    
    }
}

}

?>
