<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of information_control
 *
 * @author Pubudu Nawarathna
 */
class Add_medical_center_control extends CI_Controller {

    private $logged_in;
    private $reviewer = null;

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
        $this->load_view();
    }

    public function validate_Information() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('center_name', 'Centre Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('center_tel', 'Contact Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('center_mail', 'e-mail Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('center_web', 'Web Address', 'trim|xss_clean');
        $this->form_validation->set_rules('center_fields', 'Treatment areas', 'trim|xss_clean');
        $this->form_validation->set_rules('center_desc', 'Description', 'trim|xss_clean');



        if ($this->form_validation->run() == FALSE) {


            $this->load_view();
        } else {
            $this->add_Information();

            //   $this->thank();
            // log karala redirect karanna code eka liyanna
        }
    }

    public function add_Information() {
        $dbRet;
        $name = $this->input->post('center_name');
        $tel = $this->input->post('center_tel');
        $mail = $this->input->post('center_mail');
        $web = $this->input->post('center_web');
        $desc = $this->input->post('center_desc');
        $region = $this->input->post('center_region');
        $type = $this->input->post('center_type');


        $dbRet = $this->medical_center_model->add_center($name, $tel, $mail, $web, $desc, $region, $type);
        $max = $this->medical_center_model->get_Max();
        $fields_row = explode("\n", $_POST['center_fields']);
        foreach ($fields_row as $v1) {
            $f_id = $this->medical_center_model->get_Id(trim($v1));

            $this->medical_center_model->add_fields($max[0]->center_id, $f_id[0]->field_id);
        }
        if ($this->session->userdata('role')===2) {
             $this->medical_center_model->add_center_of_physician($this->session->userdata('email'), $max[0]->center_id);
        }
       
        if ($dbRet) {
            ?>
            <script type="text/javascript">

                alert("Succsefully Added New Medical Centre");
            </script>
            <?php

            redirect('medical', 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");

            </script>  
            <?php

            redirect('add_center', 'refresh');
        }
    }

    public function load_view() {

        $data['title'] = ucfirst('Add new Medical Center');
        $data['role'] = $this->session->userdata('role');
//        $data['fname'] = $this->session->userdata('fname');
//        $data['lname'] = $this->session->userdata('lname');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('medical/add_center', $data);
        $this->load->view('templates/footer', $data);
    }
    public function allocate_to_center(){
        echo 'hi';
    }

}
?>
