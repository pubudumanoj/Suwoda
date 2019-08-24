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

class Disease_report_model extends CI_Model {

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

    public function view_disease_types() {

          $query = $this->db->query(' SELECT f.name, COUNT(*) as "count" FROM disease d, field_info f WHERE f.field_id=d.disease_type GROUP BY d.disease_type');
         
        return $query->result();
     
    }
    public function view_disease_status() {

          $query = $this->db->query(' SELECT disease_review as "status", COUNT(*) as "count" FROM disease GROUP BY disease_review');
        return $query->result();
     
    }
    public function view_disease_amount_by_year() {

        $query = $this->db->query("SELECT YEAR(disease_date) as 'year', COUNT(*) as 'count' FROM disease GROUP BY YEAR(disease_date)");
       return $query->result();
     
    }
   
}
?>
