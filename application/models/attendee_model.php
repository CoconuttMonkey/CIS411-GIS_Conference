<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendee_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_all() {
      $query = $this->db->get('attendee');
			
			return $query->result();
    }
    
    public function attendee_exists($id) {
	    
	    $query = $this->db->get_where('attendee', array('user_id' => $id));
	    if ($query->num_rows() > 0){
	        return TRUE;
	    }
	    else{
	        return FALSE;
	    }
    }
}
