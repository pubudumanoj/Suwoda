<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_control extends CI_Controller {

     public function __construct()  {
        parent:: __construct();
  $this->load->model("Reports_model");

    }

function disease_report_by_month(){
     $year = $this->input->post('select_year',TRUE);
     
   
     $result =  $this->Reports_model->disease_report_by_month( $year);
       
       $table = array();
$table['cols'] = array(
	/* define your DataTable columns here
	 * each column gets its own array
	 * syntax of the arrays is:
	 * label => column label
	 * type => data type of column (string, number, date, datetime, boolean)
	 */
    array('label' => 'month', 'type' => 'string'),
	array('label' => 'count', 'type' => 'number')
	// etc...
);

$rows = array();
foreach ($result as $r) {
    $temp = array();
	// each column needs to have data inserted via the $temp array
	$temp[] = array('v' => $r->month);
	$temp[] = array('v' => intval($r->count));
	// etc...
	
	// insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

echo json_encode($table);
//echo json_encode($year);
}
function plant_report_by_month(){
     $year = $this->input->post('select_year',TRUE);
     
   
     $result =  $this->Reports_model->plant_report_by_month( $year);
       
       $table = array();
$table['cols'] = array(
	/* define your DataTable columns here
	 * each column gets its own array
	 * syntax of the arrays is:
	 * label => column label
	 * type => data type of column (string, number, date, datetime, boolean)
	 */
    array('label' => 'month', 'type' => 'string'),
	array('label' => 'count', 'type' => 'number')
	// etc...
);

$rows = array();
foreach ($result as $r) {
    $temp = array();
	// each column needs to have data inserted via the $temp array
	$temp[] = array('v' => $r->month);
	$temp[] = array('v' => intval($r->count));
	// etc...
	
	// insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

echo json_encode($table);
//echo json_encode($year);
}
function user_registration_by_month(){
     $year = $this->input->post('select_year',TRUE);
     
   
     $result =  $this->Reports_model->user_registration_by_month( $year);
       
       $table = array();
$table['cols'] = array(
	/* define your DataTable columns here
	 * each column gets its own array
	 * syntax of the arrays is:
	 * label => column label
	 * type => data type of column (string, number, date, datetime, boolean)
	 */
    array('label' => 'month', 'type' => 'string'),
	array('label' => 'count', 'type' => 'number')
	// etc...
);

$rows = array();
foreach ($result as $r) {
    $temp = array();
	// each column needs to have data inserted via the $temp array
	$temp[] = array('v' => $r->month);
	$temp[] = array('v' => intval($r->count));
	// etc...
	
	// insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

echo json_encode($table);
//echo json_encode($year);
}
function physician_registration_by_month(){
     $year = $this->input->post('select_year',TRUE);
     
   
     $result =  $this->Reports_model->physician_registration_by_month( $year);
       
       $table = array();
$table['cols'] = array(
	/* define your DataTable columns here
	 * each column gets its own array
	 * syntax of the arrays is:
	 * label => column label
	 * type => data type of column (string, number, date, datetime, boolean)
	 */
    array('label' => 'month', 'type' => 'string'),
	array('label' => 'count', 'type' => 'number')
	// etc...
);

$rows = array();
foreach ($result as $r) {
    $temp = array();
	// each column needs to have data inserted via the $temp array
	$temp[] = array('v' => $r->month);
	$temp[] = array('v' => intval($r->count));
	// etc...
	
	// insert the temp array into $rows
    $rows[] = array('c' => $temp);
}

// populate the table with rows of data
$table['rows'] = $rows;

echo json_encode($table);
//echo json_encode($year);
}
  

}

?>