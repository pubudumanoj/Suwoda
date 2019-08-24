<?php
class Autocomplete_Model extends CI_Model
{
    function GetAutocomplete($options = array())
    {
	    $this->db->select('*');
	    $this->db->like('title', $options['keyword'], 'after');
   		$query = $this->db->get('information');
		return $query->result();
    }
}
?>
