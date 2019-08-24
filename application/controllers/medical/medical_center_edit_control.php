<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Disease_edit_control
 *
 * @author Pubudu Nawarathna
 */
class Medical_center_edit_control extends CI_Controller {

    private $logged_in;
    private $id;

    function __construct() {

        parent::__construct();
        $this->load->model('medical/medical_center_model'); // load the model class
        if ($this->session->userdata('logged_in')) {
            /* check whether user is logged in or not */
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index($center_id) {

       /*
         * default main method
         * calls automatically when call the class
         * parameters: id
         * when id provided it is get the corresponding data for that id and send the results
         * to load method
         */

      
        $result = $this->medical_center_model->view_center_page($center_id);
        $treatments = $this->medical_center_model->view_center_treatment_fields($center_id);
        
      //  $comments=$this->get_comments($disease_id);
     //   $sub_comments=$this->get_sub_comments($disease_id);
       // $user_like_unlike =$this->get_user_like_unlike();

        //$this->load_view($result, $plant, $disease_id, $comments, $sub_comments, $user_like_unlike);
        $this->load_view($result, $treatments);   
        
    }

     public function validate_Information() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('center_name', 'Centre Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('center_tel', 'Contact Number', 'trim|required|xss_clean');
        $this->form_validation->set_rules('center_mail', 'e-mail Address', 'trim|required|xss_clean');
        $this->form_validation->set_rules('center_web', 'Web Address', 'trim|xss_clean');
        $this->form_validation->set_rules('center_fields', 'Treatment areas', 'trim|xss_clean');
        $this->form_validation->set_rules('center_desc', 'Description', 'trim|xss_clean');

 $center_id = $this->input->post('center_id');

        if ($this->form_validation->run() == FALSE) {


            $this->load_view($center_id);
        } else {
            $this->update_information($center_id);

            //   $this->thank();
            // log karala redirect karanna code eka liyanna
        }
    }

    public function update_information($center_id) {

  $dbRet;
        $name = $this->input->post('center_name');
        $tel = $this->input->post('center_tel');
        $mail = $this->input->post('center_mail');
        $web = $this->input->post('center_web');
        $desc = $this->input->post('center_desc');
        $region = $this->input->post('center_region');
        $type = $this->input->post('center_type');


        $dbRet = $this->medical_center_model->edit_center($name, $tel, $mail, $web, $desc, $region, $type, $center_id);
        
        $fields_row = explode("\n", $_POST['center_fields']);
         $this->medical_center_model->delete_fields($center_id);
        foreach ($fields_row as $v1) {
            $f_id = $this->medical_center_model->get_Id(trim($v1));

            $this->medical_center_model->add_fields($center_id, $f_id[0]->field_id);
        }
        if ($this->session->userdata('role')==2) {
             $this->medical_center_model->add_center_of_physician($this->session->userdata('email'), $max[0]->center_id);
        }
       
        if ($dbRet) {
            ?>
            <script type="text/javascript">

                alert("Succsefully Edite Medical Centre Information");
            </script>
            <?php

            redirect('medical', 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");

            </script>  
            <?php

            redirect('edit_center/'.$center_id, 'refresh');
        }
    }

   public function load_view($result, $treatments) {
  
        $data['title'] = ucfirst('Edit Medical Center Details');
        $data['result'] = $result;
        $data['treatments'] = $treatments;
      //  $data['plant_name'] = $plant;
      //  $data['disease_id'] = $disease_id;
      //  $data['comments'] = $comments;
      //  $data['comments_count'] = count($comments)+count($sub_comments);
     //   $data['sub_comments'] = $sub_comments;
     //   $data['user_like_unlike'] = $user_like_unlike;
        //  $data['type'] = $type;
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('medical/edit_center', $data);
        $this->load->view('templates/footer', $data);
    }

}
?>
