<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of information__page_control
 *
 * @author Pubudu Nawarathna
 */
class Plant_page_control extends CI_Controller {

    /**
     * @access private
     * Use to verfiy user is logged in or not.
     */
    private $logged_in;

    function __construct() {

        parent::__construct();
        $this->load->model('herbal/plant_model');
        if ($this->session->userdata('logged_in')) {
            /* check whether user is logged in or not */
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function index($plant_id) {

        /*
         * default main method
         * calls automatically when call the class
         * parameters: id
         * when id provided it is get the corresponding data for that id and send the results
         * to load method
         */

        $disease = $this->plant_model->get_disease_name_for_plant($plant_id);
        $result = $this->plant_model->view_plant_page($plant_id);

        $this->load_view($result, $disease);
    }

//    public function view_Information($type) {
//
//        $type = $this->type;
//
//        return $this->disease_model->view_info($type);
//    }

    public function load_view($result, $disease) {
        
        $data['title'] = ucfirst('Plant Page');
        $data['result'] = $result;
        $data['disease_name'] = $disease;
        //  $data['type'] = $type;
        $data['fname'] = $this->session->userdata('fname');
        $data['lname'] = $this->session->userdata('lname');
        $data['role'] = $this->session->userdata('role');
        $data['logged_in'] = $this->logged_in;
        $this->load->view('templates/header', $data);
        $this->load->view('herbal/plant_page', $data);
        $this->load->view('templates/footer', $data);
    }

    public function delete($id) {

        
       $plant = $this->get_image_file_name($id);
       $this->delete_plant_images($plant[0]->plant_image);
        $result = $this->plant_model->delete_plant_page($id);

        if ($result) {
            ?>
            <script type="text/javascript">

                alert("Successfully Deleted");


            </script>
            <?php

            redirect('plant/', 'refresh');
        } else {
            ?>
            <script type="text/javascript">

                alert("Plant not found");


            </script>
            <?php

            redirect('plant/', 'refresh');
        }
    }
    
  public function get_image_file_name($plant_id){
      return $this->plant_model->get_image_file_name($plant_id);
  }
    
    

public function delete_plant_images($file){
   
  $file_path = './assests/images/plants/';
  $path_parts = pathinfo(base_url().'/assests/images/plants/'.$file);
  $row_file = $path_parts['filename']; 
  $extension =$path_parts['extension'];
    //  if(is_file($file)){
          
        unlink($file_path.$file); // delete image file
        unlink($file_path.$row_file."_thumb.".$extension); // delete thumbnail file
    //  }      
}

}
?>
