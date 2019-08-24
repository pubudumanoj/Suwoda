<?php
class Reports_model extends CI_Model{
   
function disease_report_by_month( $year){
     
      $query = $this->db->query("SELECT MONTHNAME(disease_date) as 'month', COUNT(*) as 'count' FROM disease where year(disease_date)='$year' GROUP BY MONTH(disease_date)");
      
    return $query->result();
}
function plant_report_by_month( $year){
     
      $query = $this->db->query("SELECT MONTHNAME(plant_add_date) as 'month', COUNT(*) as 'count' FROM plant where year(plant_add_date)='$year' GROUP BY MONTH(plant_add_date)");
      
    return $query->result();
}
function user_registration_by_month( $year){
     
      $query = $this->db->query("SELECT MONTHNAME(logindate) as 'month', COUNT(*) as 'count' FROM user where year(logindate)='$year' AND role=3 GROUP BY MONTH(logindate)");
    
    return $query->result();
}
function physician_registration_by_month( $year){
     
      $query = $this->db->query("SELECT MONTHNAME(logindate) as 'month', COUNT(*) as 'count' FROM user where year(logindate)='$year' AND role=2 GROUP BY MONTH(logindate)");
    
    return $query->result();
}
    
  
}

?>
