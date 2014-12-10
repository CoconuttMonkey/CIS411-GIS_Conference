<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_model extends CI_Model {

    public function __cunstruct() {
        $this->load->database();
    }
    
    public function get_attendee_emails($conf_id, $filter = NULL) {
	    $this->db->select('users.email');
			$this->db->from('attendee');
			$this->db->join('users', 'users.id = attendee.user_id');
			$this->db->join('attendee_conference_lookup', 'attendee_conference_lookup.user_id = attendee.user_id');
			
			if (isset($filter) && $filter == 'paid')
				$this->db->where(array('conference_id' => $conf_id, 'paid' => 'yes'));
			else if (isset($filter) && $filter == 'unpaid')
				$this->db->where(array('conference_id' => $conf_id, 'paid' => 'no'));
			else
				$this->db->where(array('conference_id' => $conf_id));
				
      $query = $this->db->get();
			$results = $query->result();
			
			foreach ($results as $email) {
				$final[] = $email->email;
			}
			
			return $final;
    }
    
    public function get_presenter_emails($conf_id, $filter = NULL) {
	    $this->db->select('users.email');
			$this->db->from('presenter');
			$this->db->join('users', 'users.id = presenter.user_id');
			$this->db->join('presentation', 'presentation.presentation_id = presenter.presentation_id');
			$this->db->where('presentation.conference_id', $conf_id);
			
			switch ($filter) {
				case NULL :
					break;
				case 'scheduled' :
					$this->db->where('presentation.scheduled', 'yes');
					break;
				case 'pending' :
					$this->db->where('presentation.scheduled', 'no');
					break;
				default :
					break;
			}
			
      $query = $this->db->get();
			$results = $query->result();
			
			foreach ($results as $email) {
				$final[] = $email->email;
			}
			
			return $final;
    }
    
    public function get_exhibitor_emails($conf_id, $filter = NULL) {
	    $this->db->select('users.email');
			$this->db->from('exhibitor');
			$this->db->join('users', 'users.id = exhibitor.user_id');
			$this->db->join('exhibit', 'exhibit.exhibit_id = exhibitor.exhibit_id');
			$this->db->where(array('exhibit.conference_id' => $conf_id));
			
			switch ($filter) {
				case NULL :
					break;
				case 'paid' :
					$this->db->where('exhibit.paid', 'yes');
					break;
				case 'unpaid' :
					$this->db->where('exhibit.paid', 'no');
					break;
				default :
					break;
			}
			
      $query = $this->db->get();
			$results = $query->result();
			
			foreach ($results as $email) {
				$final[] = $email->email;
			}
			
			return $final;
    }
    
    public function get_sponsor_emails($conf_id, $filter = NULL) {
	    $this->db->select('users.email');
			$this->db->from('sponsor');
			$this->db->join('users', 'users.id = sponsor.user_id');
			$this->db->where(array('conference_id' => $conf_id));
			
			switch ($filter) {
				case NULL :
					break;
				case 'paid' :
					$this->db->where('exhibit.paid', 'yes');
					break;
				case 'unpaid' :
					$this->db->where('exhibit.paid', 'no');
					break;
				default :
					break;
			}
			
      $query = $this->db->get();
			$results = $query->result();
			
			foreach ($results as $email) {
				$final[] = $email->email;
			}
			
			return $final;
    }
    
}
