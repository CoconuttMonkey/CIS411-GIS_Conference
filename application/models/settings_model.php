<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_all() {
      $query = $this->db->get_where('settings', array('id' => '0'));
      return $query->row_array();
    }
}
