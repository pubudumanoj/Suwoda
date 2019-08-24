<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('user_model','',TRUE);
 }

 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
//valid_email danna
   $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database2');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.&nbsp; User redirected to login page
     $this->load->view('login');
   }
   else
   {
     //Go to private area
     redirect('', 'refresh');
   }

 }

 function check_database2($password)
 {
   //Field validation succeeded.&nbsp; Validate against database
   $username = $this->input->post('username');

   //query the database
   $result = $this->user_model->login($username, $password);

   if($result)
   {
     $sess_array = array();
     foreach($result as $row)
     {
       $sess_array = array(
         'email' => $row->email,
         'pword' => $row->pword
       );
       $this->session->set_userdata('logged_in', $sess_array);
     }
     
     return ;
   }
   else
   {
     $this->form_validation->set_message('check_database2', 'Invalid username or password');
     return false;
   }
 }
}
?>
