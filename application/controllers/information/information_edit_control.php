<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of information__edit_control
 *
 * @author Pubudu Nawarathna
 */
class Information_edit_control extends CI_Controller {

    /**
     * @access private
     * Use to verfiy user is logged in or not.
     */
    private $logged_in;

    /**
     * @access private
     * Use to store id of the result
     */
    private $id;

    function __construct() {

        parent::__construct();
        $this->load->model('information/information_model'); // load the model class
        /* check whether user is logged in or not */
        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index($id) {

        /*
         * default main method
         * calls automatically when call the class
         * parameters: id
         * when id provided it is get the corresponding data for that id and send the results
         * to load method
         */
        $this->id = $id;
        $res = $this->information_model->get_info($id);
        $result = array($res[0]->title, $res[0]->type, $res[0]->desc, $res[0]->review, $res[0]->id);

        $this->load_view($result);
    }

    public function validate_Information() {

       
        /*
         * validdate user provided data
         * required : compulsary for submit a new data
         * xss clean: sql injection and other cross refference attacks avoided
         * trim: remove spaces if available
         */
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Information title', 'trim|required|xss_clean');
        $this->form_validation->set_rules('type', 'Information type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('desc', 'Description', 'required|xss_clean');

        /*
         * if validation sucsess call the method for submit the data
         * otherwise call the load_view method with errors
         */
        if ($this->form_validation->run() == FALSE) {

            $result = $this->get_values();

            $this->load_view($result);
        } else {

            $this->update();
        }
    }

    public function get_values() {
        
        /*
         * get user inserted values
         */
        $title = $this->input->post('title');
        $type = $this->input->post('type');
        $desc = $this->input->post('desc');
        $review = $this->input->post('review');
        $id = $this->input->post('id');

        $this->id = $id;
     /*
      * create an array using the data and return that
      */
        $result = array($title, $type, $desc, $review, $id);
        return $result;
    }

    public function update() {

        $result = $this->get_values();

        $dbRet = $this->information_model->update($result);

        /*
         * if process is success redirect to the corresponding page and if not show a error
         */
        if ($dbRet) {
            ?>
            <script type="text/javascript">
                alert("Succsefully Edited Disease Information");
            </script>
            <?php

            redirect('information/' . $result[4], 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Database error occured");

            </script>  
            <?php

            redirect('disease/' . $id, 'refresh');
        }
    }

    public function load_view($result = '') {

        $data['title'] = ucfirst('Edit Information');

        $data['result'] = $result;
        //  $data['type'] = $type;
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('information/information_edit', $data);
        $this->load->view('templates/footer', $data);
    }

}
?>
