<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_settings() {
	    
	    // Get all the settings
			$query = $this->db->get('settings');
			$result['settings'] = $query->row_array();
			
			$this->db->select('conf_id');
      $query = $this->db->get('conference');
      $conf_list = $query->result();
      
      foreach ($conf_list as $conf):
      	$result['conf_list'] = $conf->conf_id;
      endforeach;
      
          return $result;
    }
}
