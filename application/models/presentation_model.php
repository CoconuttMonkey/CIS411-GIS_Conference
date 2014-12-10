<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Presentation_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function presentation_count($current_conf, $filter = NULL) {
	    
			switch ($filter) {
		    case "scheduled":
	        $query = $this->db->get_where('presentation', array('scheduled' => 'yes', 'conference_id' => $current_conf));
	        break;
		    case "pending":
	        $query = $this->db->get_where('presentation', array('scheduled' => 'no', 'conference_id' => $current_conf));
	        break;
		    default:
					$query = $this->db->get_where('presentation', array('conference_id' => $current_conf));
			}
			
			return $query->num_rows();
    }
    
    public function is_main_presenter($user_id) {
	    $this->db->select('*');
	    $this->db->from('presenter');
	    $this->db->where(array('user_id' => $user_id, 'is_main' => 'yes'));
	    $query = $this->db->get();
	    $rows = $query->num_rows();
	    if ($rows > 0) {
		    return TRUE;
	    } else {
		    return FALSE;
	    }
    }
    
    public function get_presentation_by_user($user_id, $get_room) {
	    $this->db->select('*');
	    $this->db->from('presenter');
	    $this->db->where(array('user_id' => $user_id));
			$this->db->join('presentation', 'presenter.presentation_id = presentation.presentation_id');
			
			if ($get_room) {
				$this->db->join('room', 'room.room_id = presentation.room_id');
			}
	    
	    $query = $this->db->get();
	    
	    return $query->row_array();
    }
    
    public function get_room($id) {
	    $this->db->select('*');
	    $this->db->from('room');
	    $this->db->where(array('room_id' => $id));
			
	    $query = $this->db->get();
	    
	    return $query->row_array();
    }
    
    public function get_presentation($id, $get_room) {
        if ($id != NULL) {
			    $this->db->select('*');
					$this->db->from('presentation');
					$this->db->where(array('presentation.presentation_id' => $id)); 
					$this->db->join('presenter', 'presenter.presentation_id = presentation.presentation_id');
					$this->db->join('users', 'users.id = presenter.user_id');
					
					if ($get_room == TRUE) {
						$this->db->join('room', 'room.room_id = presentation.room_id');
					}
										
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
			$this->db->join('presenter', 'presenter.presentation_id = presentation.presentation_id');
			$this->db->join('users', 'users.id = presenter.user_id');
			
			switch ($filter) {
		    case "scheduled":
		    	// Select scheduled presentations
					$this->db->join('room', 'room.room_id = presentation.room_id');
					$this->db->join('track', 'track.track_id = presentation.track_id');
		    	$this->db->where(array('presentation.conference_id' => $current_conf, 'presentation.scheduled' => 'yes')); 
	        break;
		    case "pending":
		    	// Select pending presentations
					$this->db->join('track', 'track.track_id = presentation.track_id');
		    	$this->db->where(array('presentation.conference_id' => $current_conf, 'presentation.scheduled' => 'no')); 
	        break;
		    default:
		    	// Select all presentations
					$this->db->where('presentation.conference_id', $current_conf); 
			}
			
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
    
    public function withdraw($id) {
		    $tables = array('presentation', 'presenter');
				$this->db->where('presentation_id', $id);
				$this->db->delete($tables);
    }
}
