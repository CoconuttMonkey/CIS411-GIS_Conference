<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sponsor_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_sponsor($id) {
        if ($id != FALSE) {
            $query = $this->db->get_where('sponsor', array('sponsor_id' => $id));
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function get_all($filter = NULL) {
	    if ($filter == NULL) 
	    {
	      $query = $this->db->get('sponsor');
				return $query->result();
			} 
			elseif ($filter == "unpaid") 
			{
          $query = $this->db->get_where('sponsor', array('paid' => 'no'));
          return $query->result();
			} 
			elseif ($filter == "paid") 
			{
          $query = $this->db->get_where('sponsor', array('paid' => 'yes'));
          return $query->result();
			}
    }
}
