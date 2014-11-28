<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendee_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function attendee_count($conf_id) {
      $query = $this->db->get_where('attendee_conference_lookup', array('conference_id' => $conf_id));
			
			return $query->num_rows();
    }
    
    public function get_all($conf_id, $filter = NULL) {
				
	    if ($filter == NULL) 
	    {
		    $this->db->select('*');
				$this->db->from('attendee');
				$this->db->join('users', 'users.id = attendee.user_id');
				$this->db->join('attendee_conference_lookup', 'attendee_conference_lookup.user_id = users.id' );
				$this->db->where('attendee_conference_lookup.conference_id = '.$conf_id);
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
