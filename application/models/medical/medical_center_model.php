<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of medical_center_model
 *
 * @author Pubudu Nawarathna
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class medical_center_model extends CI_Model {

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

    public function get_Id($name) {

        $query = $this->db->get_where('field_info', array('name' => $name));
        return $query->result();
    }

    public function get_Max() {

        $this->db->select_max('center_id');
        $query = $this->db->get('medical_center');
        return $query->result();
        //  return $query;
    }

    public function add_center($name, $tel, $mail, $web, $desc, $region, $type) {
        $submitter = $this->session->userdata('email');
        $data = array(
            'submitter' => $submitter,
            'name' => $name,
            'tel' => $tel,
            'desc' => $desc,
            'mail' => $mail,
            'web' => $web,
            'region' => $region,
            'type' => $type
        );

        return $this->db->insert('medical_center', $data);
    }

    public function edit_center($name, $tel, $mail, $web, $desc, $region, $type, $center_id) {

        $data = array(
            'name' => $name,
            'tel' => $tel,
            'desc' => $desc,
            'mail' => $mail,
            'web' => $web,
            'region' => $region,
            'type' => $type
        );

        $this->db->where('center_id', $center_id);
        return $this->db->update('medical_center', $data);
    }

    public function add_fields($center, $field) {
        $data = array(
            'center_id' => $center,
            'field_id' => $field
        );
        $this->db->insert('field_center', $data);
    }

    public function delete_fields($center) {
        $this->db->delete('field_center', array('center_id' => $center));
    }

    public function add_center_of_physician($physician, $center) {
        $data = array(
            'center_id' => $center,
            'physician_id' => $physician
        );
        return $this->db->insert('medical_center_of_physician', $data);
    }

    public function get_all_centers() {
        $query = $this->db->get('medical_center');
        return $query->result();
    }

    public function get_all_physicians() {
        $query = $this->db->get_where('user', array('role' => 2));
        return $query->result();
    }

    public function allocate_me($center, $physician) {

        $this->db->delete('medical_center_of_physician', array('physician_id' => $physician));
        $data = array(
            'physician_id' => $physician,
            'center_id' => $center
        );

        return $this->db->insert('medical_center_of_physician', $data);
    }

    public function view_centers($type, $search_key, $offset) {
        /*
         * four possibilities possible
         * when user filters four different possibilities retrieve data from two different ways
         */
        //select * from field_info ORDER BY `name` ASC LIMIT 5 OFFSET 1

        if ($type == 'all') {
            $this->db->select('*');
            $this->db->from('medical_center');
            $this->db->like('name', trim($search_key));
            $this->db->or_like('region', trim($search_key));
            $this->db->order_by('desc');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } else {

            $this->db->select('*');
            $this->db->from('medical_center');
            $this->db->where('type', $type);
            $this->db->like('name', trim($search_key));
            $this->db->like('region', trim($search_key));
            $this->db->order_by('name');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        }

        return $query->result();
    }

    public function view_physicians($type, $search_key, $offset) {
        /*
         * four possibilities possible
         * when user filters four different possibilities retrieve data from two different ways
         */
        //select * from field_info ORDER BY `name` ASC LIMIT 5 OFFSET 1

        if ($type == 'all') {
            $query = $this->db->query("select u.fname ,u.lname , GROUP_CONCAT(f.name) as 'fields', u.email, mc.name 'center', u.salutation, bd.physician_id 
from (user u LEFT JOIN booking_default bd on u.email=bd.physician_id) JOIN field_info f, field_physician fp, medical_center_of_physician m, medical_center mc where u.email= fp.email and fp.field = f.field_id and m.physician_id= u.email and mc.center_id =m.center_id or (u.lname like '%trim($search_key)%' or u.fname like '%trim($search_key)%') GROUP BY u.email ORDER BY u.fname ASC LIMIT  10 OFFSET ".$offset);  
         
           
        
        } else {
           
             $query = $this->db->query("select u.fname ,u.lname , GROUP_CONCAT(f.name) as 'fields', u.email, mc.name 'center', u.salutation, bd.physician_id 
from (user u LEFT JOIN booking_default bd on u.email=bd.physician_id) JOIN  field_info f, field_physician fp, medical_center_of_physician m, medical_center mc where u.email= fp.email and fp.field = f.field_id and m.physician_id= u.email and mc.center_id =m.center_id and f.field_id=' $type' or (u.lname like '%trim($search_key)%' or u.fname like '%trim($search_key)%') GROUP BY u.email ORDER BY u.fname ASC LIMIT  10 OFFSET ".$offset);  
         
        }

        return $query->result();
    }

    public function count_all_centers($type, $search_key, $offset) {
        $query = $this->db->get('medical_center');
        return $query->result();
    }

    public function view_center_page($center_id) {
        /*
         * get the center details
         * 
         */
        echo $center_id;
        $query = $this->db->query('select *
from user u, medical_center m where m.submitter= u.email and  m.center_id=' . $center_id);
        return $query->result();
    }

    public function view_center_treatment_fields($center_id) {
        /*
         * get the center details
         * 
         */
        $query = $this->db->query('select f.name
from field_info f, field_center fc where f.field_id= fc.field_id and  fc.center_id=' . $center_id);

        return $query->result();
    }

    public function delete_center_page($id) {

        if ($this->db->get_where('medical_center', array('center_id' => $id))->num_rows() > 0) {

            $this->db->delete('medical_center', array('center_id' => $id));
            $this->db->delete('field_center', array('center_id' => $id));

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_all_fields() {
        /*
         * get all the name of disease catogaries available in the db
         */

        $this->db->order_by("name", "asc");
        $query = $this->db->get('field_info');

        return $query->result();
    }

}

?>
