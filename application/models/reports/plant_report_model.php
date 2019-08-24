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

class Plant_report_model extends CI_Model {

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

    public function view_plant_region() {

          $query = $this->db->query(' SELECT plant_region as "region", COUNT(*) as "count" FROM plant GROUP BY plant_region');
         
        return $query->result();
     
    }
    public function view_plant_status() {

          $query = $this->db->query(' SELECT plant_review as "status", COUNT(*) as "count" FROM plant GROUP BY plant_review');
        return $query->result();
     
    }
    public function view_plant_amount_by_year() {

        $query = $this->db->query("SELECT YEAR(plant_add_date) as 'year', COUNT(*) as 'count' FROM plant GROUP BY YEAR(plant_add_date)");
       return $query->result();
     
    }
   
}
?>
