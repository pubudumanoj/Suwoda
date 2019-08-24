<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_plant_model extends CI_Model {

    function get_record($record_id) {
        $this->db->where('plant_id', $record_id);

        //we want the row whose ID matches the value were passing in
        $query = $this->db->get('plant');
        //get the table and put it into an object named $query
        $row = $query->row();
        //gets the first row of the resulting dataset.  In this case, only 1 row will ever be returned

        $results = $row->b_name;
        echo $results;
        //here, we create a multi-dimensional array holding the returned values
        //based on the key.
        return $results;

        //send the record back to the controller
    }

    public function add_plant($ename, $bname, $sname, $oname, $region, $charac, $review, $reviewer, $submitter, $image, $parts, $similar_plants) {
        $date = date('Y-m-d H:i:s');
        
        $data = array(
            'submitter_id' => $submitter,
            'e_name' => $ename,
            'b_name' => $bname,
            's_name' => $sname,
            'plant_review' => $review,
            'plant_reviewer' => $reviewer,
            'other_names' => $oname,
            'plant_add_date' => $date,
            'charac' => $charac,
            'plant_region' => $region,
            'plant_image' => $image,
            'parts' => $parts,
            'similar_plants' => $similar_plants
            
        );

       return $this->db->insert('plant', $data);
    }
    
    public function get_max() {
        /*
         * get the id of last disease that inserted into the database
         */
        $this->db->select_max('plant_id');
        $query = $this->db->get('plant');
        return $query->result();

    }
    
      public function get_id($name) {

        /*
         * get id of a plant when English name is provided
         */
        $query = $this->db->get_where('disease', array('disease_name' => $name));
        return $query->result();
    }
    
      public function add_diseases($plant, $disease) {
        
        /*
         * add new plant related to a disease
         */
        $data = array(
            'disease_id' => $disease,
            'plant_id' => $plant
        );
        $dbRet = $this->db->insert('disease_plant', $data);
       
    }
      public function delete_stored_diseases($plant_id) {
        
        /*
         * adelete stored related diseases for the plant
         */
       $this->db->delete('disease_plant', array('plant_id' => $plant_id));
    }

}

?>
