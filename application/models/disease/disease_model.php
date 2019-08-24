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

class disease_model extends CI_Model {

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

    public function get_id($name) {

        /*
         * get id of a plant when English name is provided
         */
        $query = $this->db->get_where('plant', array('e_name' => $name));
        return $query->result();
    }

    public function get_all_fields() {
        /*
         * get all the name of disease catogaries available in the db
         */
        $this->db->order_by("name", "asc");
        $query = $this->db->get('field_info');

        return $query->result();
    }

    public function get_max() {
        /*
         * get the id of last disease that inserted into the database
         */
        $this->db->select_max('disease_id');
        $query = $this->db->get('disease');
        return $query->result();
    }

    public function edit_disease($id, $name, $symptoms, $treatments, $submitter, $review, $reviewer, $type, $avoid) {

        /*
         * create and array and send data to the database to be updated
         */
        $data = array(
            'disease_submitter' => $submitter,
            'disease_name' => $name,
            'disease_symptoms' => $symptoms,
            'disease_treatments' => $treatments,
            'disease_review' => $review,
            'disease_reviewer' => $reviewer,
            'disease_type' => $type,
            'disease_avoid_guide' => $avoid
        );

        $this->db->where('disease_id', $id);
        return $dbRet = $this->db->update('disease', $data);
    }

    public function get_plant_name_for_disease($disease_id) {

        /*
         * find the related plant names for a disease
         */
        $query = $this->db->query(' select p.e_name as "plant_name"
from  disease_plant d, plant p where p.plant_id= d.plant_id and  d.disease_id=' . $disease_id);
        return $query->result();
    }

    public function add_disease($name, $symptoms, $treatments, $submitter, $review, $reviewer, $type, $avoid) {
        /*
         * add new disease into the db
         */
        $date = date('Y-m-d H:i:s');
        $data = array(
            'disease_submitter' => $submitter,
            'disease_name' => $name,
            'disease_symptoms' => $symptoms,
            'disease_treatments' => $treatments,
            'disease_review' => $review,
            'disease_reviewer' => $reviewer,
            'disease_type' => $type,
            'disease_avoid_guide' => $avoid,
            'disease_date' => $date
        );

        return $this->db->insert('disease', $data);
    }

    public function add_plants($disease, $plant) {

        /*
         * add new plant related to a disease
         */
        $data = array(
            'disease_id' => $disease,
            'plant_id' => $plant
        );
        $dbRet = $this->db->insert('disease_plant', $data);
    }

    public function get_all_disease($review, $type, $search_key, $offset) {

        /*
         * four possibilities possible
         * when user filters four different possibilities retrieve data from four different ways
         */
        //select * from field_info ORDER BY `name` ASC LIMIT 5 OFFSET 1
        if ($review === 'all' && $type === 'all') {
            $this->db->select('*');
            $this->db->from('disease');
            $this->db->join('field_info', 'disease.disease_type = field_info.field_id');
            $this->db->like('disease_name', trim($search_key));
            $this->db->or_like('disease_symptoms', trim($search_key));
            $this->db->order_by('disease_name');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } elseif ($review === 'all' && $type != 'all') {

            $this->db->select('*');
            $this->db->from('disease');
            $this->db->join('field_info', 'disease.disease_type = field_info.field_id');
            //  $this->db->query(' SELECT * FROM disease
//JOIN field_info ON field_info.field_id = disease.disease_type where disease_type='.$type.' and (disease_name like %'.$search_key.'% or disease_symptoms like %'.$search_key.'%)');
            $this->db->where('disease_type', $type);
            $this->db->query("and where (disease.disease_name like '%trim($search_key)%' or disease.disease_symptoms like '%trim($search_key)%')");
            //    $this->db->where("(disease_name like %'$search_key'% or disease_symptoms like %'$search_key'%)");
            //      $this->db->like('disease_type', '$type', 'none');
            //   $this->db->like('disease_name', trim($search_key));
//            $this->db->or_like('disease_symptoms', trim($search_key));
            $this->db->order_by('disease_name');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } elseif ($review != 'all' && $type === 'all') {
            $this->db->select('*');
            $this->db->from('disease');
            $this->db->join('field_info', 'disease.disease_type = field_info.field_id');
            $this->db->where('disease_review', $review);
            $this->db->query("and where (disease.disease_name like '%trim($search_key)%' or disease.disease_symptoms like '%trim($search_key)%')");
            $this->db->order_by('disease_name');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } elseif ($review != 'all' && $type != 'all') {

            $this->db->select('*');
            $this->db->from('disease');
            $this->db->join('field_info', 'disease.disease_type = field_info.field_id');
            $this->db->where('disease_type', $type);
            $this->db->where('disease_review', $review);
            $this->db->query("and where (disease.disease_name like '%trim($search_key)%' or disease.disease_symptoms like '%trim($search_key)%')");
            $this->db->or_like('disease_symptoms', trim($search_key));
            $this->db->order_by('disease_name');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } else {

            // $query = $this->db->get_where('disease', array('re' => $id), $limit, $offset);
        }


        return $query->result();
        //return $query;
    }

    public function count_all_disease($review, $type, $search_key, $offset) {
        /*
         * same as the get_all_disease method but count the resulted rows by this method
         */
        //select * from field_info ORDER BY `name` ASC LIMIT 5 OFFSET 1
        if ($review === 'all' && $type === 'all') {
            $this->db->select('*');
            $this->db->from('disease');
            $this->db->join('field_info', 'disease.disease_type = field_info.field_id');
            $this->db->like('disease_name', trim($search_key));
            $this->db->or_like('disease_symptoms', trim($search_key));
            $this->db->order_by('disease_name');
            $this->db->offset($offset);
            $query = $this->db->count_all_results();
        } elseif ($review === 'all' && $type != 'all') {

            $this->db->select('*');
            $this->db->from('disease');
            $this->db->join('field_info', 'disease.disease_type = field_info.field_id');
            //  $this->db->query(' SELECT * FROM disease
//JOIN field_info ON field_info.field_id = disease.disease_type where disease_type='.$type.' and (disease_name like %'.$search_key.'% or disease_symptoms like %'.$search_key.'%)');
            $this->db->where('disease_type', $type);
            $this->db->query("and where (disease.disease_name like '%trim($search_key)%' or disease.disease_symptoms like '%trim($search_key)%')");
            //    $this->db->where("(disease_name like %'$search_key'% or disease_symptoms like %'$search_key'%)");
            //      $this->db->like('disease_type', '$type', 'none');
            //   $this->db->like('disease_name', trim($search_key));
//            $this->db->or_like('disease_symptoms', trim($search_key));
            $this->db->order_by('disease_name');
            $this->db->offset($offset);
            $query = $this->db->count_all_results();
        } elseif ($review != 'all' && $type === 'all') {
            $this->db->select('*');
            $this->db->from('disease');
            $this->db->join('field_info', 'disease.disease_type = field_info.field_id');
            $this->db->where('disease_review', $review);
            $this->db->query("and where (disease.disease_name like '%trim($search_key)%' or disease.disease_symptoms like '%trim($search_key)%')");
            $this->db->order_by('disease_name');
            $this->db->offset($offset);
            $query = $this->db->count_all_results();
        } elseif ($review != 'all' && $type != 'all') {

            $this->db->select('*');
            $this->db->from('disease');
            $this->db->join('field_info', 'disease.disease_type = field_info.field_id');
            $this->db->where('disease_type', $type);
            $this->db->where('disease_review', $review);
            $this->db->query("and where (disease.disease_name like '%trim($search_key)%' or disease.disease_symptoms like '%trim($search_key)%')");
            $this->db->or_like('disease_symptoms', trim($search_key));
            $this->db->order_by('disease_name');
            $this->db->offset($offset);
            $query = $this->db->count_all_results();
        } else {

            // $query = $this->db->get_where('disease', array('re' => $id), $limit, $offset);
        }


        return $query;
    }

    public function view_disease_page($disease_id) {

        /*
         * check page is reviewed or not
         * if reviewed need to get the reviwers name
         */
        $review = $this->is_reviewed($disease_id);
        if ($review[0]->disease_review === 'rev') {

            $query = $this->db->query('select u.fname "rfname", u.lname "rlname",uu.lname "slname",uu.fname "sfname", d.disease_name,d.disease_type,d.disease_id, d.disease_symptoms,d.disease_review,d.disease_treatments,d.disease_reviewer,d.disease_submitter,d.disease_avoid_guide,f.field_id,f.name as "field_name"
from user u, user uu, disease d, field_info f where d.disease_reviewer= u.email and d.disease_submitter = uu.email and d.disease_type=f.field_id and  d.disease_id=' . $disease_id);
        } else {

            $query = $this->db->query('select uu.lname "slname",uu.fname "sfname", d.disease_name,d.disease_type,d.disease_id, d.disease_symptoms,d.disease_review,d.disease_treatments,d.disease_submitter,d.disease_avoid_guide,f.field_id,f.name as "field_name"
from user uu, disease d, field_info f where d.disease_submitter = uu.email and d.disease_type=f.field_id and  d.disease_id=' . $disease_id);
        }

        return $query->result();
    }

    public function get_disease_edit_info($disease_id) {
        /*
         * get disease information when id is provided
         * join tables and get information to one result
         */
        $query = $this->db->query('select d.disease_name,d.disease_type,d.disease_id, d.disease_symptoms,d.disease_review,d.disease_treatments,d.disease_avoid_guide,f.name as "field_name"
from user u, user uu, disease d, field_info f where  d.disease_type=f.field_id and  d.disease_id=' . $disease_id);


        return $query->result();
    }

    public function is_reviewed($disease_id) {
        /*
         * check the disease is reviewed or not
         */

        $this->db->select('disease_review');
        $this->db->from('disease');
        $this->db->where('disease_id', $disease_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_disease_info($id) {

        $query = $this->db->get_where('disease', array('disease_id' => $id));
        return $query->result();
    }

    public function delete_disease_page($id) {

        if ($this->db->get_where('disease', array('disease_id' => $id))->num_rows() > 0) {

            $this->db->delete('disease', array('disease_id' => $id));
            $this->delete_disease_plant($id);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_disease_plant($id) {
        $this->db->delete('disease_plant', array('disease_id' => $id));
    }

    public function add_new_comment($comment, $id, $type, $parent, $commenter) {

        /*
         * add new disease comment into the db
         */
        $date = date('Y-m-d H:i:s');
        $data = array(
            'comment_content' => $comment,
            'comment_type' => $type,
            'commenter' => $commenter,
            'parent_comment' => $parent,
            'type_id' => $id,
            'comment_date' => $date
        );


        return $this->db->insert('comment', $data);
    }

    public function get_comments($id, $type) {
        //  $query = $this->db->get_where('comment', array('type_id' => $id, 'comment_type' => $type, 'parent_comment'=>NULL));

        $this->db->select('*');
        $this->db->from('comment');
        $this->db->join('user', 'user.email = comment.commenter');
        $this->db->where('parent_comment', NULL);
        $this->db->where('type_id', $id);
        $this->db->where('comment_type', $type);
        $this->db->order_by('comment_date', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_sub_comments($id, $type) {
        $this->db->select('*');
        $this->db->from('comment');
        $this->db->join('user', 'user.email = comment.commenter');
        $this->db->where('parent_comment IS NOT NULL', NULL, FALSE);
        $this->db->where('type_id', $id);
        $this->db->where('comment_type', $type);
        $this->db->order_by('comment_date', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_user_like_unlike($type, $user) {
        $this->db->select('*');
        $this->db->from('user_like_comment');
        $this->db->join('comment', 'user_like_comment.comment_id = comment.id');
        $this->db->where('comment.comment_type', $type);
        $this->db->where('user_like_comment.user', $user);
        $this->db->order_by('comment_date', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function comment_like($value){
       $data = array(
            'value' => $value
               );

         $this->db->insert('abc', $data);
    }
     public function add_new_field($name){
         $data = array(
            'name' => $name
               );

         $this->db->insert('field_info', $data);
     }

}

?>
