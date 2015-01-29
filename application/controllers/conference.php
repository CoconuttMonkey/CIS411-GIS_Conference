<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Conference extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->library('breadcrumbs');
		$this->load->model(array('conference_model'));

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
			redirect('conference/listing', 'refresh');
		}
	}
	
	//list conferences
	function listing($filter = NULL)
	{
		// Authenticate User
		if (!$this->ion_auth->logged_in()) 
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) 
		{
			//redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}
		else 
		{
			// Load Dependencies
			$this->load->library('table');
			
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// Load Data
			$this->data['list'] = $this->conference_model->get_all();
			
			// add breadcrumbs
			$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
			$this->breadcrumbs->push('Conferences', 'conference/listing' );

			// Load View
      $this->load->view('include/header');
      $this->load->view('templates/menubar');
			$this->load->view('conference/list_conference', $this->data);
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
			
			$this->session->set_flashdata('message', "<div class='alert alert-success'>You have successfully created a new conference!<br><strong>Now to create tracks and room numbers.</strong></div>");
			
			redirect("conference/add_track_room/".$conference_data['conf_id'], 'refresh');
			
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
				'type'  => 'date',
				'value' => $this->form_validation->set_value('start_date'),
				'class' => 'form-control',
			);
			$this->data['end_date'] = array(
				'name'  => 'end_date',
				'id'    => 'end_date',
				'type'  => 'date',
				'value' => $this->form_validation->set_value('end_date'),
				'class' => 'form-control',
			);
			$this->data['reg_open_date'] = array(
				'name'  => 'reg_open_date',
				'id'    => 'reg_open_date',
				'type'  => 'date',
				'value' => $this->form_validation->set_value('reg_open_date'),
				'class' => 'form-control',
			);
			$this->data['reg_close_date'] = array(
				'name'  => 'reg_close_date',
				'id'    => 'reg_close_date',
				'type'  => 'date',
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
		$this->load->view('conference/create_conference', $this->data);
    $this->load->view('include/footer');
	}
	
	//create new tracks
	function add_track_room($conf_id)
	{
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$conference_data = array();

		// Validate form input
		$this->form_validation->set_rules('track_acronym[0]', 'Track Acronym', 'required|max_length[5]');			
		$this->form_validation->set_rules('track_name[0]', 'Track Name', 'required');	
		$this->form_validation->set_rules('track_acronym[1]', 'Track Acronym', 'max_length[5]');			
		$this->form_validation->set_rules('track_name[1]', 'Track Name', '');	
		
		$this->form_validation->set_rules('room_number[0]', 'Room Number', 'required|max_length[5]');			
		$this->form_validation->set_rules('room_building[0]', 'Building', 'required');	
		$this->form_validation->set_rules('room_number[1]', 'Room Number', 'max_length[5]');			
		$this->form_validation->set_rules('room_building[1]', 'Building', '');

		if ($this->form_validation->run() == true)
		{
			$track_acronyms 	= $this->input->post('track_acronym');
			$track_names 			= $this->input->post('track_name');
			$track_count 			= count($track_names)-1;
			
			for ($x=0; $x<=$track_count; $x++) {
				$track_data['conference_id'] = $conf_id;
				$track_data['acronym'] 			 = $track_acronyms[$x];
				$track_data['full_name']		 = $track_names[$x];
				$this->db->insert('track', $track_data);
			}
			
			$room_numbers 		= $this->input->post('room_number');
			$room_buildings 	= $this->input->post('room_building');
			$room_count 			= (count($room_numbers)-1);
			
			for ($x=0; $x<=$room_count; $x++) {
				$room_data['conference_id'] = $conf_id;
				$room_data['room_number'] 	= $room_numbers[$x];
				$room_data['building'] 			= $room_buildings[$x];
				$this->db->insert('room', $room_data);
			}
			
			$this->session->set_flashdata('message', "<div class='alert alert-success'>You have successfully created a new conference!<br><strong>Now to upload your banner picture.</strong></div>");
			
			redirect("upload/banner/".$conf_id, 'refresh');
			
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			// Load Data
			$this->data['conf_id'] = $conf_id;
		}
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('auth/add_track_room', $this->data);
    $this->load->view('include/footer');
		}
	
	//edit conference
	function edit($conf_id) 
	{
		
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$conference_data = $this->conference_model->get_conference($conf_id);

		// Validate form input
		$this->form_validation->set_rules('conf_id', 'Conference ID', 'required|xss_clean|is_numeric|max_length[4]');			
		$this->form_validation->set_rules('conf_title', 'Title', 'required|xss_clean|max_length[100]');			
		$this->form_validation->set_rules('theme', 'Theme', 'required|xss_clean|max_length[255]');			
		$this->form_validation->set_rules('prefix', 'Title Prefix', 'required|xss_clean|max_length[50]');			
		$this->form_validation->set_rules('start_date', 'Start Date', 'required');			
		$this->form_validation->set_rules('end_date', 'End Date', 'required');			
		$this->form_validation->set_rules('reg_open_date', 'Registration Open Date', 'required');			
		$this->form_validation->set_rules('reg_close_date', 'Registration Close Date', 'required');			
		$this->form_validation->set_rules('frontpage_content', 'Front Page Content', 'required');	
		$this->form_validation->set_rules('agenda_url', 'Agenda URL', '');	
		
		if (isset($_POST) && !empty($_POST))
		{
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
					'agenda_url'					=> $this->input->post('agenda_url'),
				);
			}
		
			if ($this->form_validation->run() == true && $this->db->update('conference', $conference_data, "conf_id = $conf_id"))
			{
				
				$this->session->set_flashdata('message', "<div class='alert alert-success'>You have successfully updated the conference!</div>");
				
				redirect("conference/listing", 'refresh');
				
			}
		
		}
		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		
		// Load Data
		$this->data['conf_id'] = array(
			'name'  => 'conf_id',
			'id'    => 'conf_id',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('conf_id', $conference_data['conf_id']),
			'class' => 'form-control',
		);
		$this->data['conf_title'] = array(
			'name'  => 'conf_title',
			'id'    => 'conf_title',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('conf_title', $conference_data['title']),
			'class' => 'form-control',
		);
		$this->data['theme'] = array(
			'name'  => 'theme',
			'id'    => 'theme',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('theme', $conference_data['theme']),
			'class' => 'form-control',
		);
		$this->data['prefix'] = array(
			'name'  => 'prefix',
			'id'    => 'prefix',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('prefix', $conference_data['prefix']),
			'class' => 'form-control',
		);
		$this->data['start_date'] = array(
			'name'  => 'start_date',
			'id'    => 'start_date',
			'type'  => 'date',
			'value' => $this->form_validation->set_value('start_date', $conference_data['start_date']),
			'class' => 'form-control',
		);
		$this->data['end_date'] = array(
			'name'  => 'end_date',
			'id'    => 'end_date',
			'type'  => 'date',
			'value' => $this->form_validation->set_value('end_date', $conference_data['end_date']),
			'class' => 'form-control',
		);
		$this->data['reg_open_date'] = array(
			'name'  => 'reg_open_date',
			'id'    => 'reg_open_date',
			'type'  => 'date',
			'value' => $this->form_validation->set_value('reg_open_date', $conference_data['reg_open_date']),
			'class' => 'form-control',
		);
		$this->data['reg_close_date'] = array(
			'name'  => 'reg_close_date',
			'id'    => 'reg_close_date',
			'type'  => 'date',
			'value' => $this->form_validation->set_value('reg_close_date', $conference_data['reg_close_date']),
			'class' => 'form-control',
		);
		$this->data['frontpage_content'] = array(
			'name'  => 'frontpage_content',
			'id'    => 'frontpage_content',
			'type'  => 'textarea',
			'value' => $this->form_validation->set_value('frontpage_content', $conference_data['frontpage_content']),
			'class' => 'form-control',
		);
		$this->data['agenda_url'] = array(
			'name'  => 'agenda_url',
			'id'    => 'agenda_url',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('agenda_url', $conference_data['agenda_url']),
			'class' => 'form-control',
		);
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('conference/edit_conference', $this->data);
    $this->load->view('include/footer');
	}
	
	function withdraw($id)
	{
		// Remove Presentation from Database
		$this->conference_model->withdraw($id);
		$this->session->set_flashdata('message', "<div class='alert alert-success'>You successfully deleted the conference.</div>");
		redirect('auth/dashboard', 'refresh');
	}
	
}