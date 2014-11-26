<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendee_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function attendee_count() {
      $query = $this->db->get('attendee');
			
			return $query->num_rows();
    }
    
    public function get_all($filter = NULL) {
				
	    if ($filter == NULL) 
	    {
		    $this->db->select('*');
				$this->db->from('attendee');
				$this->db->join('users', 'users.id = attendee.user_id');
	      $query = $this->db->get();
				return $query->result();
			} 
			elseif ($filter == "unpaid") 
			{
          $query = $this->db->get_where('attendee', array('active' => 'no'));
          return $query->result();
			} 
			elseif ($filter == "paid") 
			{
          $query = $this->db->get_where('attendee', array('active' => 'yes'));
          return $query->result();
			}
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
