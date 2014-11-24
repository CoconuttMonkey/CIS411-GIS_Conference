<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Conference extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	//redirect
	function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) //remove this elseif if you want to enable this for non-admins
		{
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else
		{
			//redirect them to the conference list page
			redirect('conference/list', 'refresh');
		}
	}
	
	//list conferences
	function listing($filter = NULL)
	{
		// Authenticate User
		if (!$this->ion_auth->logged_in()) {
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) {
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else {
			// Load Dependencies
			$this->load->model('conference_model');
			$this->load->library('table');
			
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// Load Data
			$this->data['list'] = $this->conference_model->get_all();

			// Load View
      $this->load->view('include/header');
      $this->load->view('templates/menubar');
			$this->load->view('list_conference', $this->data);
      $this->load->view('include/footer');
		}
	}
	
	//create a new conference
	function setup_new_conference()
	{
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$conference_data = array();

		// Validate form input
		$this->form_validation->set_rules('conf_id', 'Conference ID', 'required|xss_clean|is_numeric|max_length[4]|is_unique[conference.conf_id]');			
		$this->form_validation->set_rules('conf_title', 'Title', 'required|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('theme', 'Theme', 'required|xss_clean|max_length[255]');			
		$this->form_validation->set_rules('prefix', 'Title Prefix', 'required|xss_clean|max_length[50]');			
		$this->form_validation->set_rules('start_date', 'Start Date', 'required');			
		$this->form_validation->set_rules('end_date', 'End Date', 'required');			
		$this->form_validation->set_rules('reg_open_date', 'Registration Open Date', 'required');			
		$this->form_validation->set_rules('reg_close_date', 'Registration Close Date', 'required');			
		$this->form_validation->set_rules('frontpage_content', 'Front Page Content', 'required');	
		
		if ($this->form_validation->run() == true)
		{
			$conference_data = array(
				'conf_id' 						=> $this->input->post('conf_id'),
				'title'  							=> $this->input->post('conf_title'),
				'theme'    						=> $this->input->post('theme'),
				'prefix'    					=> $this->input->post('prefix'),
				'start_date'      		=> $this->input->post('start_date'),
				'end_date'      			=> $this->input->post('end_date'),
				'reg_open_date'      	=> $this->input->post('reg_open_date'),
				'reg_close_date'      => $this->input->post('reg_close_date'),
				'frontpage_content'		=> $this->input->post('frontpage_content'),
			);
		}
		
		if ($this->form_validation->run() == true && $this->db->insert('conference', $conference_data))
		{
			
			$this->session->set_flashdata('message', "<div class='alert alert-success'>You have successfully created a new conference!</div>");
			
			redirect("conference/add_tracks/".$conference_data['conf_id'], 'refresh');
			
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			// Load Data
			$this->data['conf_id'] = array(
				'name'  => 'conf_id',
				'id'    => 'conf_id',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('conf_id'),
				'class' => 'form-control',
			);
			$this->data['conf_title'] = array(
				'name'  => 'conf_title',
				'id'    => 'conf_title',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('conf_title'),
				'class' => 'form-control',
			);
			$this->data['theme'] = array(
				'name'  => 'theme',
				'id'    => 'theme',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('theme'),
				'class' => 'form-control',
			);
			$this->data['prefix'] = array(
				'name'  => 'prefix',
				'id'    => 'prefix',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('prefix'),
				'class' => 'form-control',
			);
			$this->data['start_date'] = array(
				'name'  => 'start_date',
				'id'    => 'start_date',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('start_date'),
				'class' => 'form-control',
			);
			$this->data['end_date'] = array(
				'name'  => 'end_date',
				'id'    => 'end_date',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('end_date'),
				'class' => 'form-control',
			);
			$this->data['reg_open_date'] = array(
				'name'  => 'reg_open_date',
				'id'    => 'reg_open_date',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('reg_open_date'),
				'class' => 'form-control',
			);
			$this->data['reg_close_date'] = array(
				'name'  => 'reg_close_date',
				'id'    => 'reg_close_date',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('reg_close_date'),
				'class' => 'form-control',
			);
			$this->data['frontpage_content'] = array(
				'name'  => 'frontpage_content',
				'id'    => 'frontpage_content',
				'type'  => 'textarea',
				'value' => $this->form_validation->set_value('frontpage_content'),
				'class' => 'form-control',
			);
		}
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('auth/create_conference', $this->data);
    $this->load->view('include/footer');
	}
	
	//register a new attendee
	function register_attendee()
	{
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$attendee_data = array();

		// Validate form input
		// $this->form_validation->set_rules('frontpage_content', 'Front Page Content', 'required');	
		
		if ($this->form_validation->run() == true)
		{
			$conference_data = array(
				'conf_id' 						=> $this->input->post('conf_id'),
			);
		}
		
		if ($this->form_validation->run() == true && $this->db->insert('attendee', $attendee_data))
		{
			
			$this->session->set_flashdata('message', "<div class='alert alert-success'>You have successfully created a new conference!</div>");
			
			redirect("conference/add_track_room/".$conference_data['conf_id'], 'refresh');
			
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			// Load Data
			$this->data['address_1'] = array(
				'name'  => 'address_1',
				'id'    => 'address_1',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('address_1'),
				'class' => 'form-control',
			);
			$this->data['address_2'] = array(
				'name'  => 'address_2',
				'id'    => 'address_2',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('address_2'),
				'class' => 'form-control',
			);
			$this->data['city'] = array(
				'name'  => 'city',
				'id'    => 'city',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('city'),
				'class' => 'form-control',
			);
			$this->data['state'] = array(
				'name'  => 'state',
				'id'    => 'state',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('state'),
				'class' => 'form-control',
			);
			$this->data['zip'] = array(
				'name'  => 'zip',
				'id'    => 'zip',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('zip'),
				'class' => 'form-control',
			);
			$this->data['admission_type'] = array(
				'name'  => 'admission_type',
				'id'    => 'admission_type',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('admission_type'),
				'class' => 'form-control',
			);
		}
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('create_attendee', $this->data);
    $this->load->view('include/footer');

	}
	
	//create new tracks
	function add_track_room($conf_id)
	{
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$conference_data = array();

		// Validate form input
		$this->form_validation->set_rules('track1_acronym', 'Track Acronym', 'required');			
		$this->form_validation->set_rules('track1_name', 'Track Name', 'required');	
		$this->form_validation->set_rules('track2_acronym', 'Track Acronym', 'required');			
		$this->form_validation->set_rules('track2_name', 'Track Name', 'required');	
		$this->form_validation->set_rules('track3_acronym', 'Track Acronym', 'required');			
		$this->form_validation->set_rules('track3_name', 'Track Name', 'required');	
		$this->form_validation->set_rules('track4_acronym', 'Track Acronym', 'required');			
		$this->form_validation->set_rules('track4_name', 'Track Name', 'required');	
		
		$this->form_validation->set_rules('room1_number', 'Room Number', 'required');			
		$this->form_validation->set_rules('room1_name', 'Building', 'required');	
		$this->form_validation->set_rules('room2_number', 'Room Number', 'required');			
		$this->form_validation->set_rules('room2_name', 'Building', 'required');	
		$this->form_validation->set_rules('room3_number', 'Room Number', 'required');			
		$this->form_validation->set_rules('room3_name', 'Building', 'required');	
		$this->form_validation->set_rules('room4_number', 'Room Number', 'required');			
		$this->form_validation->set_rules('room4_name', 'Building', 'required');	
		
		if ($this->form_validation->run() == true)
		{
			$track_data = array(
				'conference_id' 	=> $conf_id,
				'acronym'  				=> $this->input->post('acronym'),
				'full_name'    		=> $this->input->post('full_name'),
			);
			$room_data = array(
				'conference_id' 	=> $conf_id,
				'room_number'  		=> $this->input->post('room_number'),
				'building'   			=> $this->input->post('room_building'),
			);
		}
		
		if ($this->form_validation->run() == true && $this->db->insert('track', $track_data) && $this->db->insert('room', $room_data))
		{
			
			$this->session->set_flashdata('message', "<div class='alert alert-success'>You have successfully created a new conference!</div>");
			
			redirect("auth/dashboard", 'refresh');
			
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			// Load Data
			$this->data['conf_id'] = $conf_id;
			$this->data['track1_acronym'] = array(
				'name'  => 'track1_acronym',
				'id'    => 'track1_acronym',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('track1_acronym'),
				'class' => 'form-control',
			);
			$this->data['track1_name'] = array(
				'name'  => 'track1_name',
				'id'    => 'track1_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('track1_name'),
				'class' => 'form-control',
			);
			$this->data['track2_acronym'] = array(
				'name'  => 'track2_acronym',
				'id'    => 'track2_acronym',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('track2_acronym'),
				'class' => 'form-control',
			);
			$this->data['track2_name'] = array(
				'name'  => 'track2_name',
				'id'    => 'track2_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('track2_name'),
				'class' => 'form-control',
			);
			$this->data['track3_acronym'] = array(
				'name'  => 'track3_acronym',
				'id'    => 'track3_acronym',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('track3_acronym'),
				'class' => 'form-control',
			);
			$this->data['track3_name'] = array(
				'name'  => 'track3_name',
				'id'    => 'track3_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('track3_name'),
				'class' => 'form-control',
			);
			$this->data['track4_acronym'] = array(
				'name'  => 'track4_acronym',
				'id'    => 'track4_acronym',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('track4_acronym'),
				'class' => 'form-control',
			);
			$this->data['track4_name'] = array(
				'name'  => 'track4_name',
				'id'    => 'track4_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('track4_name'),
				'class' => 'form-control',
			);
			
			
			$this->data['room1_number'] = array(
				'name'  => 'room1_number',
				'id'    => 'room1_number',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('room1_number'),
				'class' => 'form-control',
			);
			$this->data['room1_building'] = array(
				'name'  => 'room1_building',
				'id'    => 'room1_building',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('room1_building'),
				'class' => 'form-control',
			);
			$this->data['room2_number'] = array(
				'name'  => 'room2_number',
				'id'    => 'room2_number',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('room2_number'),
				'class' => 'form-control',
			);
			$this->data['room2_building'] = array(
				'name'  => 'room2_building',
				'id'    => 'room2_building',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('room2_building'),
				'class' => 'form-control',
			);
			$this->data['room3_number'] = array(
				'name'  => 'room3_number',
				'id'    => 'room3_number',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('room3_number'),
				'class' => 'form-control',
			);
			$this->data['room3_building'] = array(
				'name'  => 'room3_building',
				'id'    => 'room3_building',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('room3_building'),
				'class' => 'form-control',
			);
			$this->data['room4_number'] = array(
				'name'  => 'room4_number',
				'id'    => 'room4_number',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('room4_number'),
				'class' => 'form-control',
			);
			$this->data['room4_building'] = array(
				'name'  => 'room4_building',
				'id'    => 'room4_building',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('room4_building'),
				'class' => 'form-control',
			);
		}
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('auth/add_track_room', $this->data);
    $this->load->view('include/footer');
		}
}