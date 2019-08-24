<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Disease_model
 *
 * @author Pubudu Nawarathna
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class disease_search_pdf_model extends CI_Model {

    private $logged_in;
    private $role;

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

 
  
    function disease_by_month($year) {
        /*
         * count diseases by month for given year and pass to the controller method count_all_disease in disease_pdf_control
         */
             $query = $this->db->query('SELECT MONTHNAME(search_date) as "month", COUNT(*) as "count" FROM disease_diagnosis_search where YEAR(search_date)='. $year.' GROUP BY MONTH(search_date)');
   
          return $query->result();
    }
    function disease_cat_by_year($year) {
        /*
         * count diseases for each category for given year and pass to the controller method count_all_disease in disease_pdf_control
         */
             $query = $this->db->query('SELECT  disease_name, COUNT(*) as "count" FROM disease_diagnosis_search where YEAR(search_date)='. $year.' GROUP BY disease_name');
   
          return $query->result();
    }
    function disease_by_range($date1, $date2) {
        /*
         * count diseases for each category for given range and pass to the controller method count_all_disease in disease_pdf_control
        */
          
             $query = $this->db->query("SELECT disease_name, COUNT(*) as count FROM disease_diagnosis_search where search_date BETWEEN '$date1' AND '$date2' GROUP BY disease_name");
   
          return $query->result();
    }


}

?>
