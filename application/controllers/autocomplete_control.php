<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete_control extends CI_Controller {

     public function __construct()  {
        parent:: __construct();
  $this->load->model("Autocomplete_model");

    }

    function suggestions()
{
	  
	$term = $this->input->post('term',TRUE);

	if (strlen($term) < 2) break;

	$rows = $this->Autocomplete_model->get_field(array('keyword' => $term));

	$json_array = array();
	foreach ($rows as $row)
		 array_push($json_array, $row->name);

	echo json_encode($json_array);
}
    function plant_sugession()
{
	
	$term = $this->input->post('term',TRUE);

	if (strlen($term) < 2) break;

	$rows = $this->Autocomplete_model->get_plant(array('keyword' => $term));

	$json_array = array();
	foreach ($rows as $row)
		 array_push($json_array, $row->e_name);

	echo json_encode($json_array);
}
  function disease_sugession()
{
     
	$term = $this->input->post('term',TRUE);

	if (strlen($term) < 2) break;

	$rows = $this->Autocomplete_model->get_disease(array('keyword' => $term));

	$json_array = array();
	foreach ($rows as $row)
		 array_push($json_array, $row->disease_name);

	echo json_encode($json_array);
}

function comment_like(){
    $like = $this->input->post('like',TRUE);
    $unlike = $this->input->post('unlike',TRUE);
    $comment_id = $this->input->post('comm_id',TRUE);
   
       $this->Autocomplete_model->comment_like($like, $unlike, $comment_id);
}

function user_non_like(){
     $comment_id = $this->input->post('comm_id',TRUE);
   $user = $this->session->userdata('email');
       $this->Autocomplete_model->user_non_like( $comment_id,$user);
}
function user_like_decision(){
     $comment_id = $this->input->post('comm_id',TRUE);
     $decision = $this->input->post('decision',TRUE);
   $user = $this->session->userdata('email', TRUE);
       $this->Autocomplete_model->user_like_decision( $comment_id, $user,  $decision);
}

  

}

?>