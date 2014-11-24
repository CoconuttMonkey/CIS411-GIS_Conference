<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conference_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_conference($conf_id) {
        if ($conf_id != FALSE) {
            $query = $this->db->get_where('project', array('conf_id' => $conf_id));
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function get_all() {
      $query = $this->db->get('conference');
			
			return $query->result();
    }
}
