<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function get_latest_plant(){
         $query = $this->db->query('select * from plant where plant_id=(select MAX(plant_id) from plant)');
        return $query->result();
       
    }
    public function get_latest_disease(){
         $query = $this->db->query('select * from disease where disease_id=(select MAX(disease_id) from disease)');
        return $query->result();
       
    }
    public function get_latest_medical_information(){
         $query = $this->db->query('select * from information where id=(select MAX(id) from information)');
        return $query->result();
       
    }
    

}

?>
