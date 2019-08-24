<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of disease_report_model
 *
 * @author Pubudu Nawarathna
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_report_model extends CI_Model {

    private $logged_in;  //Create a variable for store whether logged in or not | values : logged in = true, not logged in = false
    private $role; // Create variables to store the role that currently logged in
    private $reviewer;

    public function __construct() {
        parent::__construct();
        /*
         * 
         * 
         */
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function view_user_registration_by_year() {

        $query = $this->db->query("SELECT YEAR(logindate) as 'year', COUNT(*) as 'count' FROM user where role=3 GROUP BY YEAR(logindate)");
       return $query->result();
     
    }
    public function view_physician_registration_by_year() {

        $query = $this->db->query("SELECT YEAR(logindate) as 'year', COUNT(*) as 'count' FROM user where role=2 GROUP BY YEAR(logindate)");
       return $query->result();
     
    }
   
}
?>
