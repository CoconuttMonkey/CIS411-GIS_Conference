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
    
    public function get_sponsor($id) {
        if ($id != FALSE) {
            $query = $this->db->get_where('sponsor', array('sponsor_id' => $id));
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function get_all($current_conf, $filter = NULL) {
	    if ($filter == NULL) 
	    {
	      $query = $this->db->get_where('sponsor', array('conference_id' => $current_conf));
				return $query->result();
			} 
			elseif ($filter == "unpaid") 
			{
          $query = $this->db->get_where('sponsor', array('paid' => 'no', 'conference_id' => $current_conf));
          return $query->result();
			} 
			elseif ($filter == "paid") 
			{
          $query = $this->db->get_where('sponsor', array('paid' => 'yes', 'conference_id' => $current_conf));
          return $query->result();
			}
    }
}
