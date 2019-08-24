<?php
class Autocomplete_model extends CI_Model{
   
      function get_field($options = array())
    {
	    $this->db->select('*');
	    $this->db->like('name', $options['keyword'], 'after');
   		$query = $this->db->get('field_info');
		return $query->result();
    }
      function get_plant($options = array())
    {
	    $this->db->select('*');
	    $this->db->like('e_name', $options['keyword'], 'after');
   		$query = $this->db->get('plant');
		return $query->result();
    }
      function get_disease($options = array())
    {
	    $this->db->select('*');
	    $this->db->like('disease_name', $options['keyword'], 'after');
   		$query = $this->db->get('disease');
		return $query->result();
    }
    
    function comment_like($like1,$unlike1,$comment_id1){
    $like = $like1;
    $unlike = $unlike1;
    $comment_id = $comment_id1;
   
       $data = array(
            'like' => $like,
            'unlike' => $unlike
        );

        $this->db->where('id', $comment_id);
        return $dbRet = $this->db->update('comment', $data);
}

function user_non_like($comment_id, $user){
     
   
       $data = array(
            
           'decision' => 'n'
            
        );

        $this->db->where('comment_id', $comment_id);
        $this->db->where('user', $user);
        return $dbRet = $this->db->update('user_like_comment', $data);
}

function user_like_decision( $comment_id, $user,  $decision){
     
     $data = array(
            'user' => $user,
           'decision' => $decision,
         'comment_id' =>$comment_id
            
        );
     $data2 = array(
           
           'decision' => $decision,
        
            
        );

        
         $this->db->insert('user_like_comment', $data);
         
         $this->db->where('comment_id', $comment_id);
        $this->db->where('user', $user);
         $this->db->update('user_like_comment', $data2);
}
 
  
}

?>
