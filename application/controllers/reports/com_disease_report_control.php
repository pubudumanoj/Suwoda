<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Disease_report_control
 *
 * @author Pubudu Nawarathna
 */
class Com_disease_report_control extends CI_Controller {

    private $logged_in;
    private $type = 'all';

    function __construct() {

        parent::__construct();
$this->load->model('reports/user_report_model');
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
    
    

    public function load_view() {

        $data['title'] = ucfirst('Common Disease Search Reports Page');
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('reports/disease_search', $data);
        $this->load->view('templates/footer', $data);
    }

}

?>
