<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_settings() {

			$query = $this->db->get('settings');
      $result = $query->row_array();
      
      return $result;
    }
}
