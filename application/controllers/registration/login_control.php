<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_control extends CI_Controller {

    private $logged_in;

    function __construct() {

        parent::__construct();
        $this->load->model('registration/login_model', '', TRUE);
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    /**
     * @param page $page accept page names and show coresponding view file
     * @return void no return value 
     * @author Pubudu Nawarathna
     */
    public function index($page = 'login') {
        $this->load_view();
    }

    function userlogin() {
        //This method will have the credentials validation
        $this->load->library('form_validation');
//valid_email danna

        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');



        if ($this->form_validation->run() == FALSE) {
            //Field validation failed.&nbsp; User redirected to login page
            $this->load_view();
        } else {

            //Go to home page
            redirect('', 'refresh');
        }
    }

    function check_database($password) {
        //Field validation succeeded.&nbsp; Validate against database
        $username = $this->input->post('email');
        //query the database
        $result = $this->login_model->login($username, $password);

        if ($result) {
            $session_data = array();
            foreach ($result as $row) {
                $session_data = array(
                    'email' => $row->email,
                    'pword' => $row->pword,
                    'fname' => $row->fname,
                    'lname' => $row->lname,
                    'role' => $row->role,
                    'logged_in' => 1
                );
                $this->session->set_userdata($session_data);
            }

            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('', 'refresh');
    }

    /**
     * @return void no return value 
     */
    public function load_view() {

        $data['logged_in'] = $this->logged_in;
        $data['title'] = ucfirst('login');
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $this->load->view('templates/header', $data);
        $this->load->view('registration/login', $data);
        $this->load->view('templates/footer', $data);
    }

}

?>
