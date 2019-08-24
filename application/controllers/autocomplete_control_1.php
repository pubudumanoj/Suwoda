<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete_control extends CI_Controller {

     public function __construct()  {
        parent:: __construct();
  $this->load->model("autocomplete_model");

    }
	function index()
	{
		$this->load->view('autocomplete');
	}

	function suggestions()
{
	
	$term = $this->input->post('term',TRUE);

	if (strlen($term) < 2) break;

	$rows = $this->autocomplete_model->GetAutocomplete(array('keyword' => $term));

	$json_array = array();
	foreach ($rows as $row)
		 array_push($json_array, $row->title);

	echo json_encode($json_array);
}
}

/* End of file autocomplete.php */
/* Location: ./application/controllers/autocomplete.php */

?>