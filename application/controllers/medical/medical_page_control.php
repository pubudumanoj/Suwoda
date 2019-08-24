<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of information__page_control
 *
 * @author Pubudu Nawarathna
 */
class Medical_page_control extends CI_Controller {

    /**
     * @access private
     * Use to verfiy user is logged in or not.
     */
    private $logged_in;

    function __construct() {

        parent::__construct();
        $this->load->model('medical/medical_center_model');
         $this->load->model("Autocomplete_model");
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

//    public function view_Information($type) {
//
//        $type = $this->type;
//
//        return $this->disease_model->view_info($type);
//    }

    public function load_view($result, $treatments) {
    //public function load_view($result, $plant, $disease_id, $comments,$sub_comments, $user_like_unlike) {


        $data['title'] = ucfirst('Center Page');
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
        $this->load->view('medical/center_page', $data);
        $this->load->view('templates/footer', $data);
    }

    public function delete($id) {

        $result = $this->medical_center_model->delete_center_page($id);

        if ($result) {
            ?>
            <script type="text/javascript">

                alert("Successfully Deleted");


            </script>
            <?php

            redirect('medical/', 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Medical Centre not found");


            </script>
            <?php

            redirect('medical/', 'refresh');
        }
    }

   


}
?>
