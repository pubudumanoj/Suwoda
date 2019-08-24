<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of information__page_control
 *
 * @author Pubudu Nawarathna
 */
class Disease_page_control extends CI_Controller {

    /**
     * @access private
     * Use to verfiy user is logged in or not.
     */
    private $logged_in;

    function __construct() {

        parent::__construct();
        $this->load->model('disease/disease_model');
         $this->load->model("Autocomplete_model");
        if ($this->session->userdata('logged_in')) {
            /* check whether user is logged in or not */
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index($disease_id) {

        /*
         * default main method
         * calls automatically when call the class
         * parameters: id
         * when id provided it is get the corresponding data for that id and send the results
         * to load method
         */

        $plant = $this->disease_model->get_plant_name_for_disease($disease_id);
        $result = $this->disease_model->view_disease_page($disease_id);
        $comments=$this->get_comments($disease_id);
        $sub_comments=$this->get_sub_comments($disease_id);
        $user_like_unlike =$this->get_user_like_unlike();

        $this->load_view($result, $plant, $disease_id, $comments, $sub_comments, $user_like_unlike);
    }

//    public function view_Information($type) {
//
//        $type = $this->type;
//
//        return $this->disease_model->view_info($type);
//    }

    public function load_view($result, $plant, $disease_id, $comments,$sub_comments, $user_like_unlike) {


        $data['title'] = ucfirst('Disease Page');
        $data['result'] = $result;
        $data['plant_name'] = $plant;
        $data['disease_id'] = $disease_id;
        $data['comments'] = $comments;
        $data['comments_count'] = count($comments)+count($sub_comments);
        $data['sub_comments'] = $sub_comments;
        $data['user_like_unlike'] = $user_like_unlike;
        //  $data['type'] = $type;
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('disease/disease_page', $data);
        $this->load->view('templates/footer', $data);
    }

    public function delete($id) {

        $result = $this->disease_model->delete_disease_page($id);

        if ($result) {
            ?>
            <script type="text/javascript">

                alert("Successfully Deleted");


            </script>
            <?php

            redirect('disease/', 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Information not found");


            </script>
            <?php

            redirect('information/', 'refresh');
        }
    }

    /*
     * Comment system codes
     */

    public function add_new_comment() {

        /*
         * add new comments for the disease
         * comment content coming from the text field
         * hidden field is added for getting disease id
         * comment parent is null because this is the superior comment type
         * id is the disease id
         * disease is the type of information
         */
        $dbRet;
        $comment_content = $this->input->post('new_comment_content');
        $id = $this->input->post('disease_id');
        $commenter = $this->session->userdata('email');

        $dbRet = $this->disease_model->add_new_comment($comment_content, $id, "disease", null, $commenter);
        if ($dbRet) {
            ?>
            <script type="text/javascript">
            </script>
            <?php

            redirect('disease/' . $id, 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");


            </script>
            <?php

            redirect('disease/' . $id, 'refresh');
        }
    }

    public function get_comments($disease_id) {
         $comments_result = $this->disease_model->get_comments($disease_id, "disease");
         return $comments_result;
    }
    public function get_sub_comments($disease_id) {
         $sub_comments_result = $this->disease_model->get_sub_comments($disease_id, "disease");
         return $sub_comments_result;
    }
    
    public function get_user_like_unlike(){
       // return "hellp";
        return $this->disease_model->get_user_like_unlike("disease", $this->session->userdata('email'));
        
    }
    
    public function comment_like(){
    if($_POST) {
            print_r($_POST);
            die();
        }
        
         $this->Autocomplete_model->comment_like("1");
       // $this->Disease_model->comment_like("1");
        
     //   $this->disease_model->add_new_comment("$comment_content", 20, "disease", null, "p");
    }

}
?>
