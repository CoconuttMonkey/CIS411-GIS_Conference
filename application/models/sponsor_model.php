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
    
    public function get_all() {
      $query = $this->db->get('sponsor');
			
			return $query->result();
    }
}
