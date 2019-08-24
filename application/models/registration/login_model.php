
<?php
Class Login_model extends CI_Model
{
      public function __construct() {
        parent::__construct();
    }
 function login($email, $password)
 {
   $this -> db -> select('email, pword, role, fname, lname');
   $this -> db -> from('user');
   $this -> db -> where('email', $email);
   $this -> db -> where('pword', MD5($password));
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
}
?>

