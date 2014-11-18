<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_project($project_id) {
        if ($project_id != FALSE) {
            $query = $this->db->get_where('project', array('project_id' => $project_id));
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function get_all() {
      $query = $this->db->get('project');
			
			return $query->result();
    }
}
