<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disease_diagnosis_search_control extends CI_Controller {

     public function __construct()  {
        parent:: __construct();
 

    }

      public function add_search() {

        /**
         * @param null
         * @return null
         * 
         * Description: add_search_information
         * create variables and send these varibales to model class to insert to database
         * 
         */
        $name = $this->input->post('disease_name');
        
      $date = date('Y-m-d H:i:s');
        $data = array(
         
            'disease_name' => $name,
            'search_date' => $date
        );
         $this->db->insert('disease_diagnosis_search', $data);
       
    }
  

}

?>