<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of information_model
 *
 * @author Pubudu Nawarathna
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class information_model extends CI_Model {

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

    public function get_all_information($review, $type, $search_key, $offset) {

        if ($review === 'all' && $type === 'all') {
            $this->db->select('*');
            $this->db->from('information');
            $this->db->like('title', trim($search_key));
            $this->db->or_like('desc', trim($search_key));
            $this->db->order_by('title');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } elseif ($review === 'all' && $type != 'all') {

            $this->db->select('*');
            $this->db->from('information');
            $this->db->where('type', $type);
            $this->db->query("and where (information.title like '%trim($search_key)%' or information.desc like '%trim($search_key)%')");
            $this->db->order_by('title');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } elseif ($review != 'all' && $type === 'all') {
            $this->db->select('*');
            $this->db->from('information');
            $this->db->where('review', $review);
            $this->db->query("and where (information.title like '%trim($search_key)%' or information.desc like '%trim($search_key)%')");
            $this->db->order_by('title');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } elseif ($review != 'all' && $type != 'all') {

            $this->db->select('*');
            $this->db->from('disease');
            $this->db->where('type', $type);
            $this->db->where('disease_review', $review);
            $this->db->where('review', $review);
            $this->db->query("and where (information.title like '%trim($search_key)%' or information.desc like '%trim($search_key)%')");
            $this->db->order_by('title');
            $this->db->offset($offset);
            $this->db->limit(10);
            $query = $this->db->get();
        } else {
            echo 'Hello';
            // $query = $this->db->get_where('disease', array('re' => $id), $limit, $offset);
        }


        return $query->result();
        //return $query;
    }
    
      public function count_all_information($review, $type, $search_key, $offset) {
if ($review === 'all' && $type === 'all') {
            $this->db->select('*');
            $this->db->from('information');
            $this->db->like('title', trim($search_key));
            $this->db->or_like('desc', trim($search_key));
            $this->db->order_by('title');
            $this->db->offset($offset);
          $query = $this->db->count_all_results();
        } elseif ($review === 'all' && $type != 'all') {

            $this->db->select('*');
            $this->db->from('information');
            $this->db->where('type', $type);
            $this->db->query("and where (information.title like '%trim($search_key)%' or information.desc like '%trim($search_key)%')");
            $this->db->order_by('title');
            $this->db->offset($offset);
             $query = $this->db->count_all_results();
        } elseif ($review != 'all' && $type === 'all') {
            $this->db->select('*');
            $this->db->from('information');
            $this->db->where('review', $review);
            $this->db->query("and where (information.title like '%trim($search_key)%' or information.desc like '%trim($search_key)%')");
            $this->db->order_by('title');
            $this->db->offset($offset);
             $query = $this->db->count_all_results();
        } elseif ($review != 'all' && $type != 'all') {

            $this->db->select('*');
            $this->db->from('disease');
            $this->db->where('type', $type);
            $this->db->where('disease_review', $review);
            $this->db->where('review', $review);
            $this->db->query("and where (information.title like '%trim($search_key)%' or information.desc like '%trim($search_key)%')");
            $this->db->order_by('title');
            $this->db->offset($offset);
             $query = $this->db->count_all_results();
        } else {
            echo 'Hello';
            // $query = $this->db->get_where('disease', array('re' => $id), $limit, $offset);
        }


        return $query;
    }

    public function add_information($title, $type, $desc, $review, $submitter, $reviewer) {
        $date = date('Y-m-d H:i:s');
        $data = array(
            'submitter' => $submitter,
            'title' => $title,
            'type' => $type,
            'desc' => $desc,
            'review' => $review,
            'date' => $date,
            'reviewer' => $reviewer,
        );

        $dbRet = $this->db->insert('information', $data);
        if ($dbRet) {
            ?>
            <script type="text/javascript">

                alert("Succsefuuly Added New Information");
            </script>
            <?php

            redirect('information', 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");

            </script>  
            <?php

            redirect('information', 'refresh');
        }
    }

    public function view_info($type) {
        //  $query = $this->db->get_where('information', array('id' => $id), $limit, $offset);

        if ($type == 'all') {
            $query = $this->db->get('information');
        } elseif ($type == 'unr') {
            $query = $this->db->get_where('information', array('review' => FALSE));
        } elseif ($type == 'rev') {
            $query = $this->db->get_where('information', array('review' => TRUE));
        }
        return $query->result();
    }

    public function get_info($id) {

        $query = $this->db->get_where('information', array('id' => $id));
        return $query->result();
    }

    public function view_page($id) {

        //  $query = $this->db->get("SELECT * FROM information INNER JOIN `user` ON information.reviewer=user.email WHERE id=15");
//        $this->db->select('*');
//        $this->db->from('information');
//        $this->db->join('user', 'information.reviewer = user.email');
//        $query = $this->db->where(array('id' => $id));
//        $query = $this->db->get();
//  
        $review = $this->is_reviewed($id);
      
        if ($review[0]->review === "rev") {

            $query = $this->db->query('select u.fname "rfname", u.lname "rlname",uu.lname "slname",uu.fname "sfname", i.desc, i.id,i.review,i.reviewer,i.submitter,i.title,i.submitter,i.type
from user u, user uu, information i where i.reviewer= u.email and i.submitter = uu.email and id=' . $id);
        } else {

            $query = $this->db->query('select u.fname "sfname", u.lname "slname", i.desc, i.id,i.review,i.reviewer,i.submitter,i.title,i.submitter,i.type
from user u,  information i where i.submitter= u.email and id=' . $id);
        }

        // $query = $this->db->query("SELECT * FROM information WHERE id=15");

        return $query->result();
    }

    public function is_reviewed($id) {

        $this->db->select('review');
        $this->db->from('information');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->result();
    }

    public function delete_page($id) {

        if ($this->db->get_where('information', array('id' => $id))->num_rows() > 0) {

            $this->db->delete('information', array('id' => $id));
            return TRUE;
        } else {
            return FALSE;
        }
        //   
    }

    public function update($res) {

        if ($res[3] == "rev") {
            $this->reviewer = $this->session->userdata('email');
        } else {
            $this->reviewer = '';
        }
        $data = array(
            'title' => $res[0],
            'type' => $res[1],
            'desc' => $res[2],
            'review' => $res[3],
            'reviewer' => $this->reviewer
        );

        $this->db->where('id', $res[4]);
      return  $this->db->update('information', $data);
    }

}
?>
