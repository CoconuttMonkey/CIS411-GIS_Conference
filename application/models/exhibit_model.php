<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exhibit_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function exhibit_count($current_conf, $filter = NULL) {
	    
			switch ($filter) {
		    case "paid":
	        $query = $this->db->get_where('exhibit', array('paid' => 'yes', 'conference_id' => $current_conf));
	        break;
		    case "unpaid":
	        $query = $this->db->get_where('exhibit', array('paid' => 'no', 'conference_id' => $current_conf));
	        break;
		    default:
					$query = $this->db->get_where('exhibit', array('conference_id' => $current_conf));
			}
			
			return $query->num_rows();
    }
    
    public function is_main_exhibitor($user_id) {
	    $this->db->select('*');
	    $this->db->from('exhibitor');
	    $this->db->where(array('user_id' => $user_id, 'is_main' => 'yes'));
	    $query = $this->db->get();
	    $rows = $query->num_rows();
	    if ($rows > 0) {
		    return TRUE;
	    } else {
		    return FALSE;
	    }
    }
    
    public function get_exhibit_by_user($user_id) {
	    $this->db->select('*');
	    $this->db->from('exhibitor');
	    $this->db->where(array('user_id' => $user_id));
			$this->db->join('exhibit', 'exhibit.exhibit_id = exhibitor.exhibit_id');
			$this->db->join('users', 'users.id = exhibitor.user_id');
	    
	    $query = $this->db->get();
	    return $query->row_array();
	    
	    
    }
    
    public function get_exhibit($id) {
        if ($id != FALSE) {
			    $this->db->select('*');
					$this->db->from('exhibit');
					$this->db->where(array('exhibit.exhibit_id' => $id)); 
					$this->db->join('exhibitor', 'exhibit.exhibit_id = exhibitor.exhibit_id');
					$this->db->join('users', 'users.id = exhibitor.user_id');
					$query = $this->db->get();
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function get_all($current_conf, $filter = NULL) {
	    // Prepare statement to select all data from presentation table
	    $this->db->select('*');
			$this->db->from('exhibit');
			
			switch ($filter) {
		    case "paid":
		    	// Select paid exhibits
		    	$this->db->where(array('exhibit.conference_id' => $current_conf, 'exhibit.paid' => 'yes')); 
	        break;
		    case "unpaid":
		    	// Select unpaid exhibits
		    	$this->db->where(array('exhibit.conference_id' => $current_conf, 'exhibit.paid' => 'no')); 
	        break;
		    default:
		    	// Select all exhibits
					$this->db->where('exhibit.conference_id', $current_conf); 
			}
			
			$this->db->join('exhibitor', 'exhibitor.exhibit_id = exhibit.exhibit_id');
			$this->db->join('users', 'users.id = exhibitor.user_id');
      $query = $this->db->get();
			
			return $query->result();
    }
}
