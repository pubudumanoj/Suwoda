<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Edit_control extends CI_Controller {

    private $prof_data = array();
    private $field_data = array();
    private $logged_in;
    private $role;
    private $email;
    private $pword;

    public function __construct() {
        parent::__construct();
        $this->load->model('registration/edit_model');

        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
            $this->email = $this->session->userdata('email');
            $this->pword = $this->session->userdata('pword');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index() {

        $this->get_profile();
        $this->get_field();
        $this->loadview();
    }

    public function get_profile() {
        $prof_result = $this->edit_model->get_profile($this->email);
        if ($prof_result) {
            foreach ($prof_result as $row) {
                $this->prof_data = array(
                    'email' => $row->email,
                    'pword' => $row->pword,
                    'fname' => $row->fname,
                    'lname' => $row->lname,
                    'role' => $row->role,
                    'gender' => $row->gender,
                    'bdate' => $row->bdate,
                    'addline1' => $row->addline1,
                    'addline2' => $row->addline2,
                    'addline3' => $row->addline3,
                );
            }
        }
    }

    public function get_field() {


        $this->field_data = $this->edit_model->get_field($this->email);
    }

    public function registration() {
        $this->load->library('form_validation');

        //personal details
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('gender', 'Gender', 'required|xss_clean');
        $this->form_validation->set_rules('bdate', 'Birth day', 'trim|required|xss_clean');
        $this->form_validation->set_rules('country', 'Country', 'trim|required|xss_clean');
        $this->form_validation->set_rules('addline1', 'Address line 1', 'trim|xss_clean');
        $this->form_validation->set_rules('addline2', 'Address line 2', 'trim|xss_clean');
        $this->form_validation->set_rules('addline3', 'Address line 3', 'trim|xss_clean');
        //login details

        $this->form_validation->set_rules('cur_pword', 'Current Password', 'trim|min_length[3]|max_length[32]');
        $this->form_validation->set_rules('pword', 'Password', 'trim|min_length[3]|max_length[32]|matches[con_pword]');
        $this->form_validation->set_rules('con_pword', 'Password Confirmation', 'trim|matches[pword]');

        if ($this->input->post('role') == 2) {
            $this->form_validation->set_rules('field', 'Field', 'required|xss_clean');
        } elseif ($this->input->post('role') == 1) {
            $this->form_validation->set_rules('field', 'Field', 'xss_clean');
        }


        if ($this->form_validation->run() == FALSE) {

            $this->get_profile();
            $this->get_field();
            $this->loadview();
        } else {

            $this->update_user();

            //   $this->thank();
            // log karala redirect karanna code eka liyanna
        }
    }

    public function update_user() {


        
        $email = $this->email;
        if ($this->input->post('pword')) {
          
            $pword = $this->input->post('pword');
         $session_data['pword']=md5($pword);
             $this->session->set_userdata($session_data);
             $this->pword = $this->session->userdata('pword');
          
        }
 else {
          
    $pword = NULL;
 
 }
        $fname = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $country = $this->input->post('country');
        $gender = $this->input->post('gender');
        $bdate = $this->input->post('bdate');
        $addline1 = $this->input->post('addline1');
        $addline2 = $this->input->post('addline2');
        $addline3 = $this->input->post('addline3');
      
        if ($this->role != 3) {

            if ($this->input->post('field')) {
                $field = $this->input->post('field');
            } else {
                $field = array('1');
            }
        } else {
          
            $field = array('1');
        }

           $this->edit_model->update_user($email, $pword, $fname, $lname, $country, $gender, $bdate, $addline1, $addline2, $addline3, $this->role, $field);
        
    }

    public function loadview($exist = FALSE) {

        $data['logged_in'] = $this->logged_in;
        $data['role'] = $this->role;
        $data['field_data'] = $this->field_data;
        $data['prof_data'] = $this->prof_data;
        $data['title'] = ucfirst('sign Up');
        $data['userexist'] = $exist;
        $this->load->helper(array('form'));
        $this->load->view('templates/header', $data);
        $this->load->view('registration/edit', $data);
        $this->load->view('templates/footer', $data);
    }

}

?>