<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of information_control
 *
 * @author Pubudu Nawarathna
 */
class Allocate_center_control extends CI_Controller {

    private $logged_in;
   

    function __construct() {

        parent::__construct();
        $this->load->model('medical/medical_center_model');
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {
            $this->logged_in = FALSE;
        }
    }

    public function index() {
           $centers = $this->get_all_centers();
           $physicians = $this->get_all_physicians();
        $this->load_view($centers,$physicians);
        
    }
    public function get_all_centers(){
      
         return $this->medical_center_model->get_all_centers();
    }
    public function get_all_physicians(){
      
         return $this->medical_center_model->get_all_physicians();
    }

    public function load_view($centers, $physicians) {

        $data['title'] = ucfirst('Allocate physician to medical center');
        $data['role'] = $this->session->userdata('role');
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['email'] = $this->session->userdata('email');
        $data['physicians'] = $physicians;
        $data['centers'] = $centers;
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('medical/allocate', $data);
        $this->load->view('templates/footer', $data);
    }
    public function allocate_me(){
        $dbRet;
        $physician = $this->input->post('physician');
          $center = $this->input->post('center');
       $dbRet = $this->medical_center_model->allocate_me($center, $physician);
       
        if ($dbRet) {
            ?>
            <script type="text/javascript">

                alert("Centre Allocation Complete");
            </script>
            <?php

            redirect('', 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");

            </script>  
            <?php

            redirect('allocate_me', 'refresh');
        }
    }

}
?>
