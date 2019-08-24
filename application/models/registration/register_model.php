<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register_model extends CI_Model {

    private $logged_in;  //Create a variable for store whether logged in or not | values : logged in = true, not logged in = false
    private $role; // Create variables to store the role that currently logged in

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

    public function add_user($email, $pword, $fname, $lname, $country, $gender, $bdate, $addline1, $addline2, $addline3, $role,$field, $salutation) {
        $date = date('Y-m-d H:i:s');
        $data = array(
            'email' => $email,
            'pword' => md5($pword),
            'role' => $role,
            'fname' => $fname,
            'lname' => $lname,
            'country' => $country,
            'gender' => $gender,
            'bdate' => $bdate,
            'logindate' => $date,
            'addline1' => $addline1,
            'addline2' => $addline2,
            'addline3' => $addline3,
            'salutation'=>$salutation
        );

        if ($role!=3) {
              foreach($field as $val) {
            $sql = "INSERT INTO field_physician (email,field) VALUES ('$email',$val)";
         $this->db->query($sql);
        }
      
    
}
return  $this->db->insert('user', $data);
            

    }

    public function isExist($email) {

        $query = $this->db->get_where('user', array('email' => $email));

        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }
    
    public function get_all_fields(){
      $this->db->order_by("name", "asc");
        $query = $this->db->get('field_info');

        return $query->result();
    }

}

?>