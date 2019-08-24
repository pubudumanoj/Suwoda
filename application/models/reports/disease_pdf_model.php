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

class disease_pdf_model extends CI_Model {

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

 
    function count_all_disease() {
        /*
         * count all diseases for each year and pass to the controller method count_all_disease in disease_pdf_control
         */
          $query = $this->db->query('SELECT YEAR(disease_date) as "year", COUNT(*) as "count" FROM disease GROUP BY YEAR(disease_date)');
   
          return $query->result();
    }
    function disease_by_month($year) {
        /*
         * count diseases by month for given year and pass to the controller method count_all_disease in disease_pdf_control
         */
             $query = $this->db->query('SELECT MONTHNAME(disease_date) as "month", COUNT(*) as "count" FROM disease where YEAR(disease_date)='. $year.' GROUP BY MONTH(disease_date)');
   
          return $query->result();
    }
    function disease_cat_by_year($year) {
        /*
         * count diseases for each category for given year and pass to the controller method count_all_disease in disease_pdf_control
         */
             $query = $this->db->query('SELECT  (select name from field_info WHERE field_id=disease_type) as "category", COUNT(*) as "count" FROM disease where YEAR(disease_date)='. $year.' GROUP BY disease_type');
   
          return $query->result();
    }
    function disease_by_range($date1, $date2) {
        /*
         * count diseases for each category for given range and pass to the controller method count_all_disease in disease_pdf_control
        */
          
             $query = $this->db->query("SELECT (select name from field_info WHERE field_id=disease_type) as category, COUNT(*) as count FROM disease where disease_date BETWEEN '$date1' AND '$date2' GROUP BY disease_type");
   
          return $query->result();
    }


}

?>
