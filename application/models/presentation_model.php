<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presentation_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function presentation_count($current_conf, $filter = NULL) {
	    
			switch ($filter) {
		    case "scheduled":
	        $query = $this->db->get_where('presentation', array('active' => 'yes', 'conference_id' => $current_conf));
	        break;
		    case "pending":
	        $query = $this->db->get_where('presentation', array('active' => 'no', 'conference_id' => $current_conf));
	        break;
		    default:
					$query = $this->db->get_where('presentation', array('conference_id' => $current_conf));
			}
			
			return $query->num_rows();
    }
    
    public function get_presentation($id) {
        if ($id != FALSE) {
			    $this->db->select('*');
					$this->db->from('presentation');
					$this->db->where(array('presentation.presentation_id' => $id)); 
					$this->db->join('presenter', 'presenter.presentation_id = presentation.presentation_id');
					$this->db->join('users', 'users.id = presenter.user_id');
					$query = $this->db->get();
            return $query->row_array();
        } else {
            return FALSE;
        }
    }
    
    public function get_all($current_conf, $filter = NULL) {
	    // Prepare statement to select all data from presentation table
	    $this->db->select('*');
			$this->db->from('presentation');
			
			switch ($filter) {
		    case "scheduled":
		    	// Select scheduled presentations
		    	$this->db->where(array('presentation.conference_id' => $current_conf, 'presentation.active' => 'yes')); 
	        break;
		    case "pending":
		    	// Select pending presentations
		    	$this->db->where(array('presentation.conference_id' => $current_conf, 'presentation.active' => 'no')); 
	        break;
		    default:
		    	// Select all presentations
					$this->db->where('presentation.conference_id', $current_conf); 
			}
			
			$this->db->join('presenter', 'presenter.presentation_id = presentation.presentation_id');
			$this->db->join('users', 'users.id = presenter.user_id');
			$this->db->join('room', 'room.room_id = presentation.room_id');
			$this->db->join('track', 'track.track_id = presentation.track_id');
      $query = $this->db->get();
			
			return $query->result();
    }
    
    public function get_tracks($current_conf) {
	    $this->db->select('track_id, acronym, full_name');
	    $this->db->from('track');
	    $this->db->where(array('conference_id' => $current_conf));
	    $query = $this->db->get();
	    $list  = $query->result();
	    
	    foreach ($list as $track) {
		    $result[ $track->track_id ] = $track->full_name;
	    }
	    
	    return $result;
    }
    
    public function get_rooms($current_conf) {
	    $this->db->select('room_id, room_number, building');
	    $this->db->from('room');
	    $this->db->where(array('conference_id' => $current_conf));
	    $query = $this->db->get();
	    $list  = $query->result();
	    
	    foreach ($list as $room) {
		    $result[ $room->room_id ] = $room->room_number." ".$room->building;
	    }
	    
	    return $result;
    }
}
