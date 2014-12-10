<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendee_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function attendee_count($current_conf) {
      $query = $this->db->get_where('attendee_conference_lookup', array('conference_id' => $current_conf));
			
			return $query->num_rows();
    }
    
    public function get_all($filter = NULL) {
				
	    if ($filter == NULL) 
	    {
		    $this->db->select('*');
				$this->db->from('attendee');
				$this->db->join('users', 'users.id = attendee.user_id');
				$this->db->join('admission_type', 'admission_type.id = attendee.admission_type');
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
    
    public function get_attendee($id) {
	    
		    $this->db->select('*');
				$this->db->from('attendee');
				$this->db->where(array('user_id' => $id));
	      $query = $this->db->get();
				return $query->row_array();
    }
}
