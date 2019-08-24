<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Disease_model
 *
 * @author Pubudu Nawarathna
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class booking_model extends CI_Model {

    private $logged_in;
    private $role;

    public function __construct() {
        parent::__construct();

        if ($this->session->userdata('logged_in')) {
            $this->logged_in = TRUE;
            $this->role = $this->session->userdata('role');
        } else {

            $this->logged_in = FALSE;
        }
    }

    public function check_default_set() {
        $physician = $this->session->userdata('email');
        $query = $this->db->get_where('booking_default', array('physician_id' => $physician));
        return $query->result();
    }

    public function check_default_set_physician($mail) {
        $physician = $mail;

        $this->db->select("*");
        $this->db->from("booking_default");
        $this->db->join('user', 'user.email = booking_default.physician_id');
        $this->db->join('medical_center_of_physician', 'medical_center_of_physician.physician_id = booking_default.physician_id');
        $this->db->join('medical_center', 'medical_center.center_id= medical_center_of_physician.center_id');
        $this->db->where('booking_default.physician_id', $physician);
        $query = $this->db->get();

        //$query = $this->db->get_where('booking_default', array('physician_id' => $physician));
        return $query->result();
    }

    public function get_custom_booking_details($mail, $date) {

        
        $query = $this->db->get_where('booking_setup', array('physician_id' => $mail, 'booking_date' => $date));
        if (count($query->result())==1) {
           
            return $query->result();
        }
 else {
     
       return FALSE;
 }
      
    }

    public function get_booking_count($mail) {

//        $this->db->select("booking_date, count(*) as 'count' ");
//        $this->db->from("booking");
//        $this->db->where('physician', $mail);
//        $this->db->where('booking_date >', date("Y-m-d H:i:s"));
//        $this->db->group_by("booking_date");
//        $this->db->order_by("booking_date", 'ASC');
//        $query = $this->db->get();
//        return $query->result();

        $query = $this->db->query(" SELECT COUNT(booking.booking_date) as 'count', booking_setup.start_time, booking.booking_date,booking_setup.max_patients FROM booking  LEFT JOIN booking_setup  on booking.booking_date =booking_setup.booking_date and booking.physician=booking_setup.physician_id and booking.physician='$mail' GROUP BY booking.booking_date ORDER BY booking.booking_date ASC");
        return $query->result();
    }

    public function get_booking_count_only($mail, $date) {


        $this->db->select("booking_date, count(*) as 'count' ");
        $this->db->from("booking");
        $this->db->where('physician', $mail);
        $this->db->where('booking_date >', $date);
        $this->db->group_by("booking_date");
        $this->db->order_by("booking_date", 'ASC');
        $query = $this->db->get();
        
        if (count($query->result())==1) {
              return $query->result();
        }
 else {
            return FALSE;
 }
      
    }

    public function add_booking($patient_name, $patient_contact_no, $booking_date, $number, $physician) {

        $query = $this->db->get_where('booking', array('contact_no' => $patient_contact_no, 'booking_date' => $booking_date));

        if ((count($query->result())) == 1) {
            return FALSE;
        } else {

            $date = date('Y-m-d H:i:s');
            $data = array(
                'booking_date' => $booking_date,
                'patient_name' => $patient_name,
                'contact_no' => $patient_contact_no,
                'number' => $number,
                'physician' => $physician,
                'user' => $this->session->userdata('email'),
                'booking_time' => $date
            );

            return $this->db->insert('booking', $data);
        }
    }

    public function add_default_booking_schedule($start_time, $max_patients, $work_on_weekends) {

        $data = array(
            'start_time' => $start_time,
            'max_patients' => $max_patients,
            'week_end' => $work_on_weekends,
            'physician_id' => $this->session->userdata('email')
        );

        return $this->db->insert('booking_default', $data);
    }

    public function add_custom_booking_schedule($date, $start_time, $max_patients) {

        $data = array(
            'booking_date' => $date,
            'max_patients' => $max_patients,
            'start_time' => $start_time,
            'physician_id' => $this->session->userdata('email')
        );

        return $this->db->insert('booking_setup', $data);
    }

    public function edit_default_booking_schedule($start_time, $max_patients, $work_on_weekends) {

        $physician_id = $this->session->userdata('email');
        $data = array(
            'start_time' => $start_time,
            'max_patients' => $max_patients,
            'week_end' => $work_on_weekends
        );

        $this->db->where('physician_id', $physician_id);
        return $dbRet = $this->db->update('booking_default', $data);
    }

    public function edit_custom_booking_schedule($date, $start_time, $max_patients) {

        $physician_id = $this->session->userdata('email');
        $data = array(
            'max_patients' => $max_patients,
            'start_time' => $start_time,
        );

        $this->db->where('booking_date', $date);
        $this->db->where('physician_id', $physician_id);
        return $dbRet = $this->db->update('booking_setup', $data);
    }

    public function is_custom_date_exit($date) {
        $physician_id = $this->session->userdata('email');
        $query = $this->db->get_where('booking_setup', array('physician_id' => $physician_id, 'booking_date' => $date));
        return $query->result();
    }

}

?>
