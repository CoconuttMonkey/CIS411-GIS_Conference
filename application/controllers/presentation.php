<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Presentation extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language', 'form'));
		$this->load->library('breadcrumbs');
		$this->load->model(array('presentation_model','conference_model'));

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
			redirect('presentation/listing', 'refresh');
		}
	}
	
	//register a new presentation
	function register()
	{
		
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$presentation_data = array();

		// Validate form input
		$this->form_validation->set_rules('title', 'Presentation Title', 'required');	
		$this->form_validation->set_rules('abstract', 'Abstract', 'required');	
		$this->form_validation->set_rules('track_id', 'Track', 'required');	
		$this->form_validation->set_rules('week_day', 'Week Day', '');	
		$this->form_validation->set_rules('biography', 'Biography', 'required');	
		
		if ($this->form_validation->run() == true)
		{
			$presentation_data = array(
				'conference_id' 	=> $this->conference_model->get_active_conference(),
				'title' 					=> $this->input->post('title'),
				'abstract' 				=> $this->input->post('abstract'),
				'track_id' 				=> $this->input->post('track_id'),
				'week_day' 				=> $this->input->post('week_day'),
				'time_request'		=> $this->input->post('time_request'),
			);
			
			$presenter_data = array(
				'user_id' 				=> $this->input->post('user_id'),
				'presentation_id'	=> NULL,
				'biography'				=> $this->input->post('biography'),
				'is_main'						=> 'yes',
			);
		}
		
		if ($this->form_validation->run() == true && $this->db->insert('presentation', $presentation_data))
		{
			$presenter_data['presentation_id'] = $this->db->insert_id();
			if ($this->form_validation->run() == true && $this->db->insert('presenter', $presenter_data))
			{
				$this->session->set_flashdata('message', "<div class='alert alert-success'>Your request has been sent.<p><strong>You will be contacted by email when your presentation is scheduled.</strong></p></div>");
				redirect('auth/dashboard','refresh');
			}
			
			
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			// Prepare Data
			$this->data['weekday_options'] = array(
				'nopref'		=> 'No Preference',
        'Thursday'  => 'Thursday',
        'Friday'    => 'Friday',
      );
      
			$this->data['time_options'] = array(
				'No Preference'	=> 'No Preference',
        'Morning'  			=> 'Morning',
        'Afternoon'    	=> 'Afternoon',
      );
			
			$this->data['track_options'] = $this->presentation_model->get_tracks( $this->conference_model->get_active_conference() );
			$this->data['track_id']			 = "";
			
			// Load Data
			$this->data['user_id'] 			 = $this->ion_auth->user()->row()->id;
			$this->data['conference_id'] = $this->conference_model->get_active_conference();
			$this->data['title'] = array(
				'name'  => 'title',
				'id'    => 'title',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('title'),
				'class' => 'form-control',
			);
			$this->data['abstract'] = array(
				'name'  => 'abstract',
				'id'    => 'abstract',
				'type'  => 'textarea',
				'placeholder'=>'Please describe your presentation',
				'value' => $this->form_validation->set_value('abstract'),
				'class' => 'form-control',
			);
			$this->data['week_day'] = array(
				'name'  => 'week_day',
				'id'    => 'week_day',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('week_day'),
				'class' => 'form-control',
			);
			$this->data['biography'] = array(
				'name'  => 'biography',
				'id'    => 'biography',
				'type'  => 'textarea',
				'placeholder'=>'Tell us about yourself',
				'value' => $this->form_validation->set_value('biography'),
				'class' => 'form-control',
			);
			$this->data['copresenter_1'] = array(
				'name'  => 'copresenter_1',
				'id'    => 'copresenter_1',
				'type'  => 'email',
				'placeholder'=>'optional',
				'value' => $this->form_validation->set_value('copresenter_1'),
				'class' => 'form-control',
			);
			$this->data['copresenter_2'] = array(
				'name'  => 'copresenter_2',
				'id'    => 'copresenter_2',
				'type'  => 'email',
				'placeholder'=>'optional',
				'value' => $this->form_validation->set_value('copresenter_2'),
				'class' => 'form-control',
			);
			$this->data['copresenter_3'] = array(
				'name'  => 'copresenter_3',
				'id'    => 'copresenter_3',
				'type'  => 'email',
				'placeholder'=>'optional',
				'value' => $this->form_validation->set_value('copresenter_3'),
				'class' => 'form-control',
			);
		}
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('presentation/create_presentation', $this->data);
    $this->load->view('include/footer');

	}
	
	//list presentations
	function listing($filter = NULL)
	{
		// Authenticate User
		if (!$this->ion_auth->logged_in()) {
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		else {
			// Load Dependencies
			$this->load->model('sponsor_model');
			$this->load->library('table');
			$this->load->library('breadcrumbs');
			$current_conf = $this->conference_model->get_active_conference();
			
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// Load Data
			switch ($filter) {
		    case "scheduled":
	        $this->data['heading'] = "Scheduled Presentations";
	        $this->data['subheading'] = "This is the list of all active presentations.";
	        $this->data['presentations'] = $this->presentation_model->get_all($current_conf, "scheduled");
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('Presentations', 'presentation/listing/scheduled' );
	        break;
		    case "pending":
	        $this->data['heading'] = "Pending Presentations";
	        $this->data['subheading'] = "This is the list of all inactive presentations.";
	        $this->data['presentations'] = $this->presentation_model->get_all($current_conf, "pending");
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('Presentations', 'presentation/listing/pending' );
	        break;
		    default:
		    	$this->data['heading'] = "Presentation List";
	        $this->data['subheading'] = "This is the list of all presentations.";
		    	$this->data['presentations'] = $this->presentation_model->get_all($current_conf);
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('Presentations', 'presentation/listing' );
					
			}
			
			$data['admin'] = TRUE;
			if ( !$this->ion_auth->in_group('admin')) {
				$data['admin'] = FALSE;
			}
			
			// Load View
      $this->load->view('include/header');
      $this->load->view('templates/menubar');
			$this->load->view('presentation/list_presentation', $this->data);
      $this->load->view('include/footer');
		}
	}
	
	//edit a new presentation
	function edit($id)
	{
		
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$presentation_data = $this->presentation_model->get_presentation($id, FALSE);

		// Validate form input
		$this->form_validation->set_rules('title', 'Presentation Title', 'required');	
		$this->form_validation->set_rules('abstract', 'Abstract', 'required');	
		$this->form_validation->set_rules('track_id', 'Track', 'required');	
		$this->form_validation->set_rules('week_day', 'Week Day', '');	
		$this->form_validation->set_rules('biography', 'Biography', 'required');	
		
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() == true)
			{
				$presentation_data = array(
					'title' 					=> $this->input->post('title'),
					'abstract' 				=> $this->input->post('abstract'),
					'track_id' 				=> $this->input->post('track_id'),
					'room_id' 				=> $this->input->post('room_id'),
					'week_day' 				=> $this->input->post('week_day'),
					'start_time' 			=> $this->input->post('start_time'),
					'end_time' 				=> $this->input->post('end_time'),
					'scheduled' 			=> $this->input->post('scheduled'),
				);
				if ($presentation_data['scheduled'] != 'yes') { $presentation_data['scheduled'] = "no"; }
				
				$presenter_data = array(
					'user_id' 				=> $this->input->post('user_id'),
					'presentation_id'	=> $id,
					'biography'				=> $this->input->post('biography'),
				);
			}
		  $this->db->where('presentation_id',$id);
			if ($this->form_validation->run() == true && $this->db->update('presentation', $presentation_data))
			{
		  	$this->db->where('user_id',$presenter_data['user_id']);
				if ($this->form_validation->run() == true && $this->db->update('presenter', $presenter_data))
				{
					$this->session->set_flashdata('message', "<div class='alert alert-success'>Your changes have been made.</div>");
					redirect('auth/dashboard','refresh');
				}
				
				
			}
		}
		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
		// Prepare Data
		$this->data['weekday_options'] = array(
			'nopref'		=> 'No Preference',
      'Thursday'  => 'Thursday',
      'Friday'    => 'Friday',
    );
		$this->data['week_day'] = $presentation_data['week_day'];
		
		
		$this->data['track_options'] = $this->presentation_model->get_tracks( $presentation_data['conference_id'] );
		$this->data['track_id']			 = $presentation_data['track_id'];
		
		$this->data['attachment']		 = $presentation_data['presentation_attachment'];
		
		
		$this->data['room_options'] = $this->presentation_model->get_rooms( $presentation_data['conference_id'] );
		$this->data['room_id']			= $presentation_data['room_id'];
		
		// Load Data
		$this->data['user_id'] 			 	 = $this->ion_auth->user()->row()->id;
		$this->data['presentation_id'] = $presentation_data['presentation_id'];
		$this->data['title'] = array(
			'name'  => 'title',
			'id'    => 'title',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('title', $presentation_data['title']),
			'class' => 'form-control',
		);
		$this->data['abstract'] = array(
			'name'  => 'abstract',
			'id'    => 'abstract',
			'type'  => 'textarea',
			'placeholder'=>'Please describe your presentation',
			'value' => $this->form_validation->set_value('abstract', $presentation_data['abstract']),
			'class' => 'form-control',
		);
		$this->data['biography'] = array(
			'name'  => 'biography',
			'id'    => 'biography',
			'type'  => 'textarea',
			'placeholder'=>'Tell us about yourself',
			'value' => $this->form_validation->set_value('biography', $presentation_data['biography']),
			'class' => 'form-control',
		);
		$this->data['scheduled'] = array(
			'name'  => 'scheduled',
			'id'    => 'scheduled',
			'type'  => 'checkbox',
			'value' => $this->form_validation->set_value('scheduled', $presentation_data['scheduled']),
			'class' => 'form-control',
		);
		$this->data['start_time'] = array(
			'name'  => 'start_time',
			'id'    => 'start_time',
				'type'  => 'time',
			'value' => $this->form_validation->set_value('start_time', $presentation_data['start_time']),
			'class' => 'form-control',
		);
		$this->data['end_time'] = array(
			'name'  => 'end_time',
			'id'    => 'end_time',
				'type'  => 'time',
			'value' => $this->form_validation->set_value('end_time', $presentation_data['end_time']),
			'class' => 'form-control',
		);
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('presentation/edit_presentation', $this->data);
    $this->load->view('include/footer');

	}
	
	function withdraw($id)
	{
		// Remove Presentation from Database
		$this->presentation_model->withdraw($id);
		$this->session->set_flashdata('message', "<div class='alert alert-success'>You successfully withdrew your presentation.</div>");
		redirect('auth/dashboard', 'refresh');
	}
}