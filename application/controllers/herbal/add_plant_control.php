<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Add_plant_control extends CI_Controller {

    var $gallary_path;
    private $logged_in;
    private $dbRet;

    function __construct() {

        parent::__construct();
        $this->load->model('herbal/add_plant_model', '', TRUE);
        $this->load->helper('file');
        $this->load->library('upload');
        $this->gallary_path = './assests/images/plants/';
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {
            $this->logged_in = FALSE;
        }
    }

    public function index() {
//if ($this-> session->userdata('logged_in')) {
//           
//            echo $this->session->userdata('role');
//            
//        }

        $this->load_view('');
    }

    public function validate_information() {
       
        /**
         * @param null
         * @return null
         * 
         * Description: validate_information
         * server side validation of user input details
         * xss_clean - avoid cross reference attacks and sql injections
         * required - this field cannot be empty
         * trim - trim spaces
         * method - set_rules
         * set rule parameters $field - field name, $label - field name label, $rules - validation rules followed by |
         * 
         */
        
        
        if (empty($_FILES['userfile']['name']))
{
         
    $this->form_validation->set_rules('userfile', 'Upload Image', 'required|xss_clean');
}
        $this->load->library('form_validation');
        $this->form_validation->set_rules('bname', 'Biological Name', 'trim|xss_clean');
        $this->form_validation->set_rules('ename', 'English Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('sname', 'Sinhala Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('oname', 'Other Names', 'trim|xss_clean');
        $this->form_validation->set_rules('region', 'Region', 'trim|required|xss_clean');
        $this->form_validation->set_rules('disease', 'Related diseases', 'trim|required|xss_clean');
        $this->form_validation->set_rules('charac', 'Charactersitics', 'trim|xss_clean');
        $this->form_validation->set_rules('parts', 'Plant Parts', 'trim|xss_clean');
        $this->form_validation->set_rules('similar', 'Simlar Plants to the inserted plant', 'trim|xss_clean');
   
        /*
         * 
         * If there is no validation erros call add_New_Plant function
         * Otherwise call load view method and automatically pass the errors
         */
        if ($this->form_validation->run() == FALSE) {


            $this->load_view('');
        } else {

            $this->add_New_Plant();
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
        
        $config['overwrite'] = TRUE;
        
        $config['width'] = "200";

        $config['height'] = "200";

        $this->load->library('image_lib', $config);
        $this->image_lib->initialize($config);

        if (!$this->image_lib->resize()) {

            $this->load_view($error = $this->image_lib->display_errors(), '');
        }
        $finfo = $this->upload->data();
        rename($this->gallary_path . $finfo['file_name'], $this->gallary_path . $this->input->post('ename') . $finfo['file_ext']);
        rename($this->gallary_path . $finfo['raw_name'] . '_thumb' . $finfo['file_ext'], $this->gallary_path . $this->input->post('ename') . '_thumb' . $finfo['file_ext']);
    }

    public function add_New_Plant() {
        $this->dbRet;
        $this->upload_image();

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

        $this->dbRet = $this->add_plant_model->add_plant($ename, $bname, $sname, $oname, $region, $charac, $review, $reviewer, $submitter, $image, $parts, $similar_plants);

        $max = $this->add_plant_model->get_max();
        
            $plnts_row = explode("\n", $_POST['disease']);
            foreach ($plnts_row as $v1) {
                $id = $this->add_plant_model->get_id(trim($v1));
               
                    $this->add_plant_model->add_diseases($max[0]->plant_id, $id[0]->disease_id);
                
            }
        


        if ($this->dbRet) {
            ?>
            <script type="text/javascript">
                alert("Succsefully Added New Plant");
            </script>
            <?php

            redirect('plant', 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");

            </script>  
            <?php

            redirect('add_plant', 'refresh');
        }

        //    $this->load->library('form_validation');
        // $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
        // $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
//        if ($this->form_validation->run() == FALSE) {
//
//            $this->loadview();
//        } else {
//            $this->add_Plant();
//        }
    }

//    public function add_Plant() {
//        $this->add_Plant_model->do_upload();
//    }

    public function ajax1() {

        // $record_id = 'pl_1';
        $record_id = $this->input->post('record_id');

        //set the record ID
        $result = $this->add_plant_model->get_record($record_id);
        //  $data['result'] = $result;
        //get the record from the database
        //  $this->load->view('herbal/add_plant', $data);
        return $result;
    }

    public function load_view($result) {

        $data['title'] = ucfirst('add New Plant | Herbal Plants');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['result'] = $result;
        $this->load->view('templates/header', $data);
        $this->load->view('herbal/add_plant', $data);
        $this->load->view('templates/footer', $data);
    }

}
?>
