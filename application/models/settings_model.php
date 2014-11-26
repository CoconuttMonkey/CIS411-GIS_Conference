<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_settings() {
	    
	    $this->db->select('active_conference');

			$query = $this->db->get('settings');
			$temp = $query->row_array();
			$active_conf = $temp['active_conference'];
			
      $query = $this->db->get_where('conference', array('conf_id' => $active_conf));
      $result = $query->row_array();
      
      return $result;
    }
}
