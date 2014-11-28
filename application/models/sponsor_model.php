<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sponsor_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_sponsor($conf_id, $id) {
        if ($id != FALSE) {
            $query = $this->db->get_where('sponsor', array('sponsor_id' => $id, 'conference_id' => $conf_id));
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function get_all($conf_id, $filter = NULL) {
	    if ($filter == NULL) 
	    {
	      $query = $this->db->get_where('sponsor', array('conference_id' => $conf_id));
				return $query->result();
			} 
			elseif ($filter == "unpaid") 
			{
          $query = $this->db->get_where('sponsor', array('paid' => 'no', 'conference_id' => $conf_id));
          return $query->result();
			} 
			elseif ($filter == "paid") 
			{
          $query = $this->db->get_where('sponsor', array('paid' => 'yes', 'conference_id' => $conf_id));
          return $query->result();
			}
    }
}
