<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sponsor_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function sponsor_count($current_conf, $filter = NULL) {
	    
			switch ($filter) {
		    case "paid":
	        $query = $this->db->get_where('sponsor', array('paid' => 'yes', 'conference_id' => $current_conf));
	        break;
		    case "unpaid":
	        $query = $this->db->get_where('sponsor', array('paid' => 'no', 'conference_id' => $current_conf));
	        break;
		    default:
					$query = $this->db->get_where('sponsor', array('conference_id' => $current_conf));
			}
			
			return $query->num_rows();
    }
    
    public function is_sponsor($id) {
	    $this->db->select('*');
	    $this->db->from('sponsor');
	    $this->db->where(array('user_id' => $id));
	    $query = $this->db->get();
	    $rows = $query->num_rows();
	    if ($rows > 0) {
		    return TRUE;
	    } else {
		    return FALSE;
	    }
    }
    
    public function get_sponsor($id) {
        if ($id != FALSE) {
			    $this->db->select('*');
					$this->db->from('sponsor');
					$this->db->where(array('sponsor_id' => $id)); 
					$this->db->join('users', 'users.id = sponsor.user_id');
	    $query = $this->db->get();
					
          return $query->row_array();
        } else {
          return FALSE;
        }
    }
    
    public function get_sponsor_by_user($user_id) {
	    $this->db->select('*');
	    $this->db->from('sponsor');
	    $this->db->where(array('user_id' => $user_id));
			$this->db->join('users', 'users.id = sponsor.user_id');
	    
	    $query = $this->db->get();
	    return $query->row_array();
	    
	    
    }
    
    public function get_all($current_conf, $filter = NULL) {
	    if ($filter == NULL) 
			{
		    $this->db->select('*');
				$this->db->from('sponsor');
				$this->db->where(array('conference_id' => $current_conf)); 
				$this->db->join('users', 'users.id = sponsor.user_id');
				$query = $this->db->get();
        return $query->result();
			} 
			elseif ($filter == "unpaid") 
			{
		    $this->db->select('*');
				$this->db->from('sponsor');
				$this->db->where(array('paid' => 'no', 'conference_id' => $current_conf)); 
				$this->db->join('users', 'users.id = sponsor.user_id');
				$query = $this->db->get();
        return $query->result();
			} 
			elseif ($filter == "paid") 
			{
		    $this->db->select('*');
				$this->db->from('sponsor');
				$this->db->where(array('sponsor.paid' => 'yes', 'sponsor.conference_id' => $current_conf)); 
				$this->db->join('users', 'users.id = sponsor.user_id');
				$query = $this->db->get();
        return $query->result();
			}
    }
}
