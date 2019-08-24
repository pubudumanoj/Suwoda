<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of information__page_control
 *
 * @author Pubudu Nawarathna
 */
class Information_page_control extends CI_Controller {

    private $logged_in;
    private $type = 'all';
   

    function __construct() {

        parent::__construct();
        $this->load->model('information/information_model');
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index($id,$del='show') {
       
        $this->id = $id;
        
        if ($del=='del') {
          
            $this->delete($id);
        }else{
      $result =   $this->information_model->view_page($this->id);
      
      $this->load_view($result);
        }
    }



   

    public function view_Information($type) {

        $type = $this->type;

        return $this->information_model->view_info($type);
    }

    public function load_view($result) {

        $data['title'] = ucfirst('Information Page');
       // $data['error'] = $error;
        $data['result'] = $result;
      //  $data['type'] = $type;
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('information/information_page', $data);
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
