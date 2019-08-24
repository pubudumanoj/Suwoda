<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Edit_model extends CI_Model {

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

    public function update_user($email, $pword, $fname, $lname, $country, $gender, $bdate, $addline1, $addline2, $addline3, $role, $field) {
        if (is_null($pword)) {
            $data = array(
                'email' => $email,
                'fname' => $fname,
                'lname' => $lname,
                'country' => $country,
                'gender' => $gender,
                'bdate' => $bdate,
                'addline1' => $addline1,
                'addline2' => $addline2,
                'addline3' => $addline3,
            );
        } else {
            $data = array(
                'email' => $email,
                'pword' => md5($pword),
                'fname' => $fname,
                'lname' => $lname,
                'country' => $country,
                'gender' => $gender,
                'bdate' => $bdate,
                'addline1' => $addline1,
                'addline2' => $addline2,
                'addline3' => $addline3,
            );
        }


        if ($role != 3) {
            $this->db->where('email', $email);
            $this->db->delete('field');
            foreach ($field as $val) {
                $sql = "INSERT INTO field (email,field) VALUES ('$email',$val)";
                $this->db->query($sql);
            }
        }
        $this->db->where('email', $email);
        $this->db->update('user', $data);

         redirect('', 'refresh');
    }

    public function get_profile($email) {
        $query = $this->db->get_where('user', array('email' => $email));
        if ($query->num_rows() == 1) {

            return $query->result();
        } else {
            return false;
        }
    }

    public function get_field($email) {

        $query = $this->db->get_where('field_physician', array('email' => $email));

        if ($query->num_rows() > 0) {

            return $query->result();
        } else {
            return false;
        }
    }

}

?>