<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Conference_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_conference($conf_id) {
        if ($conf_id != FALSE) {
            $query = $this->db->get_where('conference', array('conf_id' => $conf_id));
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function get_all() {
      $query = $this->db->get('conference');
			
			return $query->result();
    }
    
    public function get_ids() {
			
			$this->db->select('conf_id');
			$query = $this->db->get('conference');
			
			$list_items = $query->result();
			
			foreach ($list_items as $item) {
				$result[$item->conf_id] = $item->conf_id;
			}
			
			return $result;
    }
    
    public function get_active_conference() {
	    $this->db->select('active_conference');

			$query = $this->db->get('settings');
			$temp = $query->row_array();
			$active_conf = $temp['active_conference'];
			
      $query = $this->db->get_where('conference', array('conf_id' => $active_conf));
      $current = $query->row_array();
      
      return $current['conf_id'];
    }
}
