<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Disease_edit_control
 *
 * @author Pubudu Nawarathna
 */
class Plant_edit_control extends CI_Controller {

    private $logged_in;
    private $id;
      private $dbRet;
      var $gallary_path;

    function __construct() {

        parent::__construct();
        $this->load->model('herbal/plant_model'); // load the model class
        $this->load->library('upload');
         $this->load->helper('file');
        $this->gallary_path = './assests/images/plants/';
        if ($this->session->userdata('logged_in')) {
            /* check whether user is logged in or not */
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index($id) {

        /* id is coming from the plant page */
        $this->id = $id;

        // get all the information regarding the plant from the db
        $res = $this->plant_model->get_plant_edit_info($id);

        $disease = $this->plant_model->get_disease_name_for_plant($id);
        // create the result array to send the plant data to the view page
        $result = array($res[0]->e_name, $res[0]->b_name, $res[0]->s_name, $res[0]->other_names, $res[0]->plant_image, $res[0]->plant_region, $res[0]->similar_plants, $res[0]->charac, $res[0]->parts, $res[0]->plant_review, $id);

        $this->load_view($result, $disease); // send the retreived information to the view page and load it
    }

    public function validate_Information() {
        $this->load->library('form_validation');

        // validate information // check whether they have following errors
        $this->form_validation->set_rules('bname', 'Biological Name', 'trim|xss_clean');
        $this->form_validation->set_rules('ename', 'English Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sname', 'Sinhala Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('oname', 'Other Names', 'trim|xss_clean');
        $this->form_validation->set_rules('region', 'Region', 'trim|required|xss_clean');
        $this->form_validation->set_rules('related_disease', 'Related diseases', 'trim|required|xss_clean');
        $this->form_validation->set_rules('charac', 'Charactersitics', 'trim|xss_clean');
        $this->form_validation->set_rules('parts', 'Plant Parts', 'trim|xss_clean');
        $this->form_validation->set_rules('similar', 'Simlar Plants to the inserted plant', 'trim|xss_clean');



        /*
         * 
         * If there is no validation erros call add_information function
         * Otherwise call load view method and automatically pass the errors
         */
        $id = $this->input->post('plant_id');

        if ($this->form_validation->run() == FALSE) {

            echo "fsdfs";
            $res = $this->plant_model->get_plant_edit_info($id);
            $disease = $this->plant_model->get_disease_name_for_plant($id);
            // create the result array to send the disease data to the view page
            $result = array($res[0]->e_name, $res[0]->b_name, $res[0]->s_name, $res[0]->other_names, $res[0]->plant_image, $res[0]->plant_region, $res[0]->similar_plants, $res[0]->charac, $res[0]->parts, $res[0]->plant_review, $id);

            $this->load_view($result, $disease); // send the retreived information to the view page and load it
        } else {

            $this->update_information($id);
        }
    }

    public function update_information($id) {

        $this->dbRet;

        if (!empty($_FILES['userfile']['name'])) {
            $this->upload_image();
        }
        $bname = $this->input->post('bname');
        $ename = $this->input->post('ename');
        $sname = $this->input->post('sname');
        $oname = $this->input->post('oname');
        $region = $this->input->post('region');
        $charac = $this->input->post('charac');
        $review = $this->input->post('review');
        $parts = $this->input->post('parts');
        $similar_plants = $this->input->post('similar');
        $finfo = $this->upload->data();
        $image = $ename . $finfo['file_ext'];
        $submitter = $this->session->userdata('email');

        if ($this->role === 3 && $this->logged_in) {

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

        $this->dbRet = $this->plant_model->edit_plant($id, $ename, $bname, $sname, $oname, $region, $charac, $review, $reviewer, $submitter, $image, $parts, $similar_plants);

        $this->plant_model->delete_plant_disease($id);
        //add related diseases for the plant
        //create and array using disease name
        //explode method creates the array
        $plnts_row = explode("\n", $_POST['related_disease']);

        //add plants once at a time

           // get the disease id using the disease name and add that disease with the plant id in the table disease_plant
             foreach ($plnts_row as $v1) {
                $disease = $this->plant_model->get_id(trim($v1));

                    $this->plant_model->add_diseases($id, $disease[0]->disease_id);

            }

        if ($this->dbRet) {
            /*
         * if process is success redirect to the corresponding page and if not show a error
         */
            ?>

            <script type="text/javascript">
                alert("Succsefully Edited Plant Information");
            </script>
            <?php

            redirect('plant/' . $id, 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");

            </script>  
            <?php

            redirect('plant_edit/' . $id, 'refresh');
        }
    }

    function upload_image() {

        $config['upload_path'] = $this->gallary_path;
        $config['allowed_types'] = "gif|jpg|png|jpeg|TIFF|BMP";
        $config['max_size'] = '1024';
        $config['overwrite'] = TRUE;
        $config['max_width'] = '1024';
        $config['max_height'] = '768';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload()) {
            $this->load_view($error = $this->upload->display_errors());
        } else {

            $finfo = $this->upload->data();

            $this->_createThumbnail($finfo['file_name']);

            $data['uploadInfo'] = $finfo;


            $data['thumbnail_name'] = $finfo['raw_name'] . '_thumb' . $finfo['file_ext'];

            //  $this->load->view('upload_success',$data);
            // You can view content of the $finfo with the code block below

            /* echo '<pre>';

              print_r($finfo);

              echo '</pre>'; */
        }
    }

    function _createThumbnail($filename) {


        $config['image_library'] = "gd2";

        $config['source_image'] = $this->gallary_path . $filename;

        $config['create_thumb'] = TRUE;

        $config['maintain_ratio'] = TRUE;

        $config['width'] = "200";

        $config['height'] = "200";

        $config['overwrite'] = TRUE;

        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {

            $this->load_view($error = $this->image_lib->display_errors(), '');
        }
        $finfo = $this->upload->data();
        rename($this->gallary_path . $finfo['file_name'], $this->gallary_path . $this->input->post('ename') . $finfo['file_ext']);
        rename($this->gallary_path . $finfo['raw_name'] . '_thumb' . $finfo['file_ext'], $this->gallary_path . $this->input->post('ename') . '_thumb' . $finfo['file_ext']);
    }

    public function load_view($result = '', $result2_disease = '') {

        $data['title'] = ucfirst('Edit Plant Information');
        $data['result'] = $result;
        $data['result2'] = $result2_disease;
        //  $data['type'] = $type;
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('herbal/edit_plant', $data);
        $this->load->view('templates/footer', $data);
    }

}
?>
