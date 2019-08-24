<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_control extends CI_Controller {

    private $logged_in;
    private $role;

    public function __construct() {
        parent::__construct();
        $this->load->model('registration/register_model');

        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index() {
 
        $this->loadview();
    }

    public function validate_registration() {
        $this->load->library('form_validation');
         
        // field name, error message, validation rules
        //personal details
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'required|xss_clean');
        $this->form_validation->set_rules('salutation', 'Salutation', 'required|xss_clean');
        $this->form_validation->set_rules('bdate', 'Birth day', 'trim|required|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
        $this->form_validation->set_rules('addline1', 'Address line 1', 'trim|xss_clean');
        $this->form_validation->set_rules('addline2', 'Address line 2', 'trim|xss_clean');
        $this->form_validation->set_rules('addline3', 'Address line 3', 'trim|xss_clean');
        //login details
        $this->form_validation->set_rules('email', 'Your Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('pword', 'Password', 'trim|required|min_length[3]|max_length[32]');
        $this->form_validation->set_rules('con_pword', 'Password Confirmation', 'trim|required|matches[pword]');

        if ($this->form_validation->run() == FALSE) {

$fields = $this->register_model->get_all_fields(); // get Type/Area of the Disease information to the page from db
            $this->loadview();
        } else {
            $this->add_user();

            //   $this->thank();
            // log karala redirect karanna code eka liyanna
        }
    }

    public function add_user() {

$field;
$dbRet;
        $email = $this->input->post('email');
        $pword = $this->input->post('pword');
        $fname = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $country = $this->input->post('country');
        $gender = $this->input->post('gender');
        $bdate = $this->input->post('bdate');
        $addline1 = $this->input->post('addline1');
        $addline2 = $this->input->post('addline2');
        $addline3 = $this->input->post('addline3');
        $salutation = $this->input->post('salutation');
        if ($this->input->post('role')!=3) {
            $role = $this->input->post('role');
       
                $field[0] = $this->input->post('field1');
                if ($this->input->post('field2')!="optional") {
                     $field[1] = $this->input->post('field2');
               
                }
                if ($this->input->post('field3')!="optional") {
                     $field[2] = $this->input->post('field3');
               
                }
           
        } else {
            $role = 3;
            $field = array('1');
        }
        
         
$fields = $this->register_model->get_all_fields(); // get Type/Area of the Disease information to the page from db
        if ($this->register_model->isExist($email)) {
            
            $this->loadview();
        } else {
       $dbRet=     $this->register_model->add_user($email, $pword, $fname, $lname, $country, $gender, $bdate, $addline1, $addline2, $addline3, $role, $field, $salutation);
        }
        
         
              
              if ($dbRet) {
            ?>
            <script type="text/javascript">
                alert("Succsefully Added New Disease");
            </script>
            <?php

             if ($this->logged_in) {
                    redirect('', 'refresh');
              }
              else{
            redirect('login', 'refresh');
              }
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");

            </script>  
            <?php

            redirect('settings', 'refresh');
        }
    }

   

    public function loadview() {

        $data['logged_in'] = $this->logged_in;
        $data['role'] = $this->role;
        $data['title'] = ucfirst('Change your email Address');
        $this->load->helper(array('form'));
        $this->load->view('templates/header', $data);
        $this->load->view('registration/change_email', $data);
        $this->load->view('templates/footer', $data);
    }

}

?>