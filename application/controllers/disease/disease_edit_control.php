<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Disease_edit_control
 *
 * @author Pubudu Nawarathna
 */
class Disease_edit_control extends CI_Controller {

    private $logged_in;
    private $id;

    function __construct() {

        parent::__construct();
        $this->load->model('disease/disease_model'); // load the model class
        if ($this->session->userdata('logged_in')) {
            /* check whether user is logged in or not */
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index($id) {

        /* id is coming from the disease page */
        $this->id = $id;

        // get all the information regarding the desease from the db
        $res = $this->disease_model->get_disease_edit_info($id);

        $plant = $this->disease_model->get_plant_name_for_disease($id);
        // create the result array to send the disease data to the view page
        $result = array($res[0]->disease_name, $res[0]->disease_symptoms, $res[0]->disease_treatments, $res[0]->field_name, $res[0]->disease_avoid_guide, $res[0]->disease_review, $id);

        $result_disease_type = $this->disease_model->get_all_fields();  // get all the disease type information from the db

        $this->load_view($result, $result_disease_type, $plant); // send the retreived information to the view page and load it
    }

    public function validate_Information() {
        $this->load->library('form_validation');

        // validate information // check whether they have following errors
        $this->form_validation->set_rules('disease_name', 'Disease Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('disease_type', 'Disease Type', 'trim|xss_clean');
        $this->form_validation->set_rules('disease_plant', 'Treatment plants', 'trim|required|xss_clean');
        $this->form_validation->set_rules('disease_symptoms', 'Symptoms', 'trim|xss_clean');
        $this->form_validation->set_rules('disease_treatments', 'Treatment', 'trim|xss_clean');
        $this->form_validation->set_rules('disease_avoid', 'Avoid Instructions', 'trim|xss_clean');
        /*
         * 
         * If there is no validation erros call add_information function
         * Otherwise call load view method and automatically pass the errors
         */
        $id = $this->input->post('disease_id');
        if ($this->form_validation->run() == FALSE) {


            $res = $this->disease_model->get_disease_edit_info($id);
            $plant = $this->disease_model->get_plant_name_for_disease($id);
            // create the result array to send the disease data to the view page
            $result = array($res[0]->disease_name, $res[0]->disease_symptoms, $res[0]->disease_treatments, $res[0]->field_name, $res[0]->disease_avoid_guide, $res[0]->disease_review, $id);

            $result_disease_type = $this->disease_model->get_all_fields();  // get all the disease type information from the db

            $this->load_view($result, $result_disease_type, $plant); // send the retrieved information to the view page and load it
        } else {

            $this->update_information($id);
        }
    }

    public function update_information($id) {


        $name = $this->input->post('disease_name');
        $type = $this->input->post('disease_type');
        $symptoms = $this->input->post('disease_symptoms');
        $treatments = $this->input->post('disease_treatments');
        $avoid = $this->input->post('disease_avoid');
        $submitter = $this->session->userdata('email');
        $review = $this->input->post('review');

        $dbRet;
        if ($this->role === 3 && $this->logged_in) {
            /*
             * role ==3 normal user not an admin or staff member
             * check the user is an admin or staff member. reviwing only allow to those two profile types
             * if admin needs to unreview information he can do it.
             * 
             */

            $review = 'unr';
            $reviewer = NULL;
        } else {

            if ($review === "unr") {

                $review = 'unr';
                $reviewer = NULL;
            } else {
                $review = 'rev';
                $reviewer = $this->session->userdata('email');
            }
        }
        //send data to model class to edit disease information
        $dbRet = $this->disease_model->edit_disease($id, $name, $symptoms, $treatments, $submitter, $review, $reviewer, $type, $avoid);

        /*
         * a disease can have multiple number of related plants
         * when editing a disease all the plants related to that specific disease id 
         * is deleted and reinsert with the new edited values
         */
        $this->disease_model->delete_disease_plant($id);
        //add related plants for the disease
        //create and array using plants name
        //explode method creates the array
        $plnts_row = explode("\n", $_POST['disease_plant']);

        //add plants once at a time
        foreach ($plnts_row as $v1) {
            $id2 = $this->disease_model->get_id(trim($v1));
            foreach ($id2 as $v2) {
                $this->disease_model->add_plants($id, $v2->plant_id);
            }
        }

        if ($dbRet) {
            /*
         * if process is success redirect to the corresponding page and if not show a error
         */
            ?>

            <script type="text/javascript">
                alert("Succsefully Edited Disease Information");
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

    public function load_view($result = '', $result__disease_type = '', $result3_plant = '') {

        $data['title'] = ucfirst('Edit Disease Information');
        $data['result'] = $result;
        $data['result2'] = $result__disease_type;
        $data['result3'] = $result3_plant;
        //  $data['type'] = $type;
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('disease/edit_disease', $data);
        $this->load->view('templates/footer', $data);
    }

}
?>
