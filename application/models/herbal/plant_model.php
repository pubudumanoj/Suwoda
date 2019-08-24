<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plant_model extends CI_Model {

    public function view_plant_page($plant_id) {

        /*
         * check page is reviewed or not
         * if reviewed need to get the reviwers name
         */

        $review = $this->is_reviewed($plant_id);

        if ($review[0]->plant_review === 'rev') {


            $query = $this->db->query('select u.fname "rfname", u.lname "rlname",uu.lname "slname",uu.fname "sfname", p.e_name,p.s_name,p.b_name, p.other_names,p.plant_image, p.plant_region, p.charac,p.plant_review,p.plant_reviewer, p.submitter_id, p.plant_id
from user u, user uu, plant p where p.plant_reviewer= u.email and p.submitter_id = uu.email and  p.plant_id=' . $plant_id);
        } else {

            $query = $this->db->query('select uu.lname "slname",uu.fname "sfname", p.e_name, p.s_name, p.b_name, p.other_names, p.plant_image, p.plant_region, p.charac ,p.plant_review, p.submitter_id,  p.plant_id
from user uu, plant p where p.submitter_id = uu.email and  p.plant_id=' . $plant_id);
        }

        return $query->result();
    }

    public function get_disease_name_for_plant($plant_id) {

        /*
         * find the related diseases for a plant
         */
        $query = $this->db->query(' select d.disease_name
from  disease_plant dp, disease d where d.disease_id= dp.disease_id and  dp.plant_id=' . $plant_id);
        return $query->result();
    }

    public function get_id($name) {

        /*
         * get id of a plant when English name is provided
         */
        $query = $this->db->get_where('disease', array('disease_name' => $name));
        return $query->result();
    }

    public function is_reviewed($plant_id) {
        /*
         * check the plant is reviewed or not
         */

        $this->db->select('plant_review');
        $this->db->from('plant');
        $this->db->where('plant_id', $plant_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function delete_plant_page($id) {

        if ($this->db->get_where('plant', array('plant_id' => $id))->num_rows() > 0) {

            $this->db->delete('plant', array('plant_id' => $id));
            $this->delete_plant_disease($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_image_file_name($plant_id) {
        $this->db->select('plant_image');
        $this->db->from('plant');
        $this->db->where('plant_id', $plant_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function delete_plant_disease($id) {
        $this->db->delete('disease_plant', array('plant_id' => $id));
    }

    public function get_all_plants($review, $region, $search_key, $offset) {

        /*
         * four possibilities possible
         * when user filters four different possibilities retrieve data from four different ways
         */
        //select * from field_info ORDER BY `name` ASC LIMIT 5 OFFSET 1
        if ($review === 'all' && $region === 'all') {
            $this->db->select('*');
            $this->db->from('plant');
            $this->db->like('e_name', trim($search_key));
            $this->db->or_like('b_name', trim($search_key));
            $this->db->or_like('s_name', trim($search_key));
            $this->db->or_like('other_names', trim($search_key));
            $this->db->or_like('plant_region', trim($search_key));
            $this->db->or_like('charac', trim($search_key));
            $this->db->order_by('b_name');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } elseif ($review === 'all' && $region != 'all') {


            $this->db->select('*');
            $this->db->from('plant');
            $this->db->where('plant_region', $region);
            $this->db->query("and where (plant.e_name like '%trim($search_key)%' or plant.b_name like '%trim($search_key)%' or plant.charac like '%trim($search_key)%' or plant.plant_region like '%trim($search_key)%' or plant.other_names like '%trim($search_key)%' or plant.s_name like '%trim($search_key)%')");
            $this->db->order_by('b_name');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } elseif ($review != 'all' && $region === 'all') {

            $this->db->select('*');
            $this->db->from('plant');
            $this->db->where('plant_review', $review);
            $this->db->query("and where (plant.e_name like '%trim($search_key)%' or plant.b_name like '%trim($search_key)%' or plant.charac like '%trim($search_key)%' or plant.plant_region like '%trim($search_key)%' or plant.other_names like '%trim($search_key)%' or plant.s_name like '%trim($search_key)%')");
            $this->db->order_by('b_name');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } elseif ($review != 'all' && $region != 'all') {


            $this->db->select('*');
            $this->db->from('plant');
            $this->db->where('plant_region', $region);
            $this->db->where('plant_review', $review);
            $this->db->query("and where (plant.e_name like '%trim($search_key)%' or plant.b_name like '%trim($search_key)%' or plant.charac like '%trim($search_key)%' or plant.plant_region like '%trim($search_key)%' or plant.other_names like '%trim($search_key)%' or plant.s_name like '%trim($search_key)%')");
            $this->db->order_by('b_name');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } else {

            // $query = $this->db->get_where('disease', array('re' => $id), $limit, $offset);
        }


        return $query->result();
        //return $query;
    }

    public function count_all_plants($review, $region, $search_key, $offset) {
        /*
         * same as the get_all_disease method but count the resulted rows by this method
         */
        //select * from field_info ORDER BY `name` ASC LIMIT 5 OFFSET 1
        if ($review === 'all' && $region === 'all') {
            $this->db->select('*');
            $this->db->from('plant');
            $this->db->like('e_name', trim($search_key));
            $this->db->or_like('b_name', trim($search_key));
            $this->db->or_like('s_name', trim($search_key));
            $this->db->or_like('other_names', trim($search_key));
            $this->db->or_like('plant_region', trim($search_key));
            $this->db->or_like('charac', trim($search_key));
            $this->db->order_by('b_name');
            $this->db->offset($offset);
            $query = $this->db->count_all_results();
        } elseif ($review === 'all' && $region != 'all') {


            $this->db->select('*');
            $this->db->from('plant');
            $this->db->where('plant_region', $region);
            $this->db->query("and where (plant.e_name like '%trim($search_key)%' or plant.b_name like '%trim($search_key)%' or plant.charac like '%trim($search_key)%' or plant.plant_region like '%trim($search_key)%' or plant.other_names like '%trim($search_key)%' or plant.s_name like '%trim($search_key)%')");
            $this->db->order_by('b_name');
            $this->db->offset($offset);
            $query = $this->db->count_all_results();
        } elseif ($review != 'all' && $region === 'all') {

            $this->db->select('*');
            $this->db->from('plant');
            $this->db->where('plant_review', $review);
            $this->db->query("and where (plant.e_name like '%trim($search_key)%' or plant.b_name like '%trim($search_key)%' or plant.charac like '%trim($search_key)%' or plant.plant_region like '%trim($search_key)%' or plant.other_names like '%trim($search_key)%' or plant.s_name like '%trim($search_key)%')");
            $this->db->order_by('b_name');
            $this->db->offset($offset);
            $query = $this->db->count_all_results();
        } elseif ($review != 'all' && $region != 'all') {

            $this->db->select('*');
            $this->db->from('plant');
            $this->db->where('plant_region', $region);
            $this->db->where('plant_review', $review);
            $this->db->query("and where (plant.e_name like '%trim($search_key)%' or plant.b_name like '%trim($search_key)%' or plant.charac like '%trim($search_key)%' or plant.plant_region like '%trim($search_key)%' or plant.other_names like '%trim($search_key)%' or plant.s_name like '%trim($search_key)%')");
            $this->db->order_by('b_name');
            $this->db->offset($offset);
            $query = $this->db->count_all_results();
        } else {

            // $query = $this->db->get_where('disease', array('re' => $id), $limit, $offset);
        }
        return $query;
    }

    public function get_all_regions() {
        /*
         * get all the name of disease catogaries available in the db
         */
        $this->db->distinct();
        $this->db->select('plant_region');
        $this->db->order_by("plant_region", "asc");
        $query = $this->db->get('plant');

        return $query->result();
    }

    public function get_plant_edit_info($plant_id) {
        /*
         * get plant information when id is provided
         * join tables and get information to one result
         */

        $this->db->select('*');
        $this->db->from('plant');
        $this->db->where('plant_id', $plant_id);
        $query = $this->db->get();


        return $query->result();
    }
    
    public function edit_plant($id, $ename, $bname, $sname, $oname, $region, $charac, $review, $reviewer, $submitter, $image, $parts, $similar_plants) {
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

       $this->db->where('plant_id', $id);
        return $this->db->update('plant', $data);
    }
    
      public function add_diseases( $plant, $disease) {

        /*
         * add new plant related to a disease
         */
        $data = array(
            'disease_id' => $disease,
            'plant_id' => $plant
        );
        $dbRet = $this->db->insert('disease_plant', $data);
    }
    
    

}

?>
