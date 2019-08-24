<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of settings_control
 *
 * @author Pubudu Nawarathna
 */
class Settings_control extends CI_Controller{
 
    private $logged_in;
    private $role;

 
    function __construct() {

        parent::__construct();
        $this->load->model('registration/login_model', '', TRUE);
         if ($this-> session->userdata('logged_in')) {
            $this->logged_in =TRUE;
            $this->role=  $this->session->userdata('role');
            
        }
        else{
          
             $this->logged_in =FALSE;
           
        }
    }

    /**
     * @param page $page accept page names and show coresponding view file
     * @return void no return value 
     * @author Pubudu Nawarathna
     */
    public function add_admin() {
        
             
        
        $this->loadview('add_admin');
    }
    
    public function loadview($page='add_admin') {

         $data['logged_in'] = $this->logged_in;
          $data['role'] = $this->role;
      $data['title'] = ucfirst($page);
      $data['userexist'] = false;
        $this->load->helper(array('form'));
        $this->load->view('templates/header', $data);
        $this->load->view('registration/'.$page, $data);
        $this->load->view('templates/footer', $data);
    }
}

?>
