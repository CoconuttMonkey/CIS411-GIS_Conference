<?php if (!defined('BASEPATH')) die();
class Email extends Main_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		// Load Dependencies
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation', 'breadcrumbs'));
		$this->load->helper(array('url','language','php-excel'));
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->lang->load('auth');
		$this->load->model(array('email_model', 'conference_model'));
		
	}
	
	function index() {
		if (!$this->ion_auth->logged_in())
		{
			//redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		elseif (!$this->ion_auth->is_admin()) 
		{
			//if not admin redirect to dashboard
			redirect('auth/dashboard', 'refresh');
		}
	}
	
	function attendees($filter = NULL) {
	
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$email_data = array();
		$current_conf = $this->conference_model->get_active_conference();

		// Validate form input
		$this->form_validation->set_rules('subject', 'Subject', 'required');	
		$this->form_validation->set_rules('message_body', 'Message', 'required');	
		
		if ($this->form_validation->run() == true)
		{
			$email_data = array(
				'subject' 			=> $this->input->post('subject'),
				'message_body' 	=> $this->input->post('message_body'),
			);
			
			$attendee_mail_list = $this->email_model->get_attendee_emails($current_conf);
			
			$this->email->from('gisconference@clarion.edu', 'NW PA GIS Conference');
			$this->email->to($attendee_mail_list);
			
			$this->email->subject( $email_data['subject'] );
			$this->email->message( $email_data['message_body'] );	
		}
		
		if ($this->form_validation->run() == true && $this->email->send())
		{
			$this->session->set_flashdata('message', "<div class='alert alert-success'>Message sent!<p></p></div>");
			redirect("auth/dashboard", 'refresh');
		}
		else
		{
			// Load Data
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['email_group'] = 'Attendees';
			$this->data['subject'] = array(
				'name'  => 'subject',
				'id'    => 'subject',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('subject'),
				'class' => 'form-control',
			);
			$this->data['message_body'] = array(
				'name'  => 'message_body',
				'id'    => 'message_body',
				'type'  => 'textarea',
				'value' => $this->form_validation->set_value('message_body'),
				'class' => 'form-control',
			);
			
			// Load View
	    $this->load->view('include/header');
	    $this->load->view('templates/menubar');
	    $this->load->view('email', $this->data);
	    $this->load->view('include/footer');
	  }
	}
	
	function presenters($filter = NULL) {
	
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$email_data = array();
		$current_conf = $this->conference_model->get_active_conference();

		// Validate form input
		$this->form_validation->set_rules('subject', 'Subject', 'required');	
		$this->form_validation->set_rules('message_body', 'Message', 'required');	
		
		if ($this->form_validation->run() == true)
		{
			$email_data = array(
				'subject' 			=> $this->input->post('subject'),
				'message_body' 	=> $this->input->post('message_body'),
			);
			
			$mail_list = $this->email_model->get_presenter_emails($current_conf, $filter);
			
			$this->email->from('gisconference@clarion.edu', 'NW PA GIS Conference');
			$this->email->to($mail_list);
			
			$this->email->subject( $email_data['subject'] );
			$this->email->message( $email_data['message_body'] );	
		}
		
		if ($this->form_validation->run() == true && $this->email->send())
		{
			$this->session->set_flashdata('message', "<div class='alert alert-success'>Message sent!<p></p></div>");
			redirect("auth/dashboard", 'refresh');
		}
		else
		{
			// Load Data
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['email_group'] = $filter.' presenters';
			$this->data['subject'] = array(
				'name'  => 'subject',
				'id'    => 'subject',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('subject'),
				'class' => 'form-control',
			);
			$this->data['message_body'] = array(
				'name'  => 'message_body',
				'id'    => 'message_body',
				'type'  => 'textarea',
				'value' => $this->form_validation->set_value('message_body'),
				'class' => 'form-control',
			);
			
			// Load View
	    $this->load->view('include/header');
	    $this->load->view('templates/menubar');
	    $this->load->view('email', $this->data);
	    $this->load->view('include/footer');
	  }
	}
	
	function exhibitors($filter = NULL) {
	
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$email_data = array();
		$current_conf = $this->conference_model->get_active_conference();

		// Validate form input
		$this->form_validation->set_rules('subject', 'Subject', 'required');	
		$this->form_validation->set_rules('message_body', 'Message', 'required');	
		
		if ($this->form_validation->run() == true)
		{
			$email_data = array(
				'subject' 			=> $this->input->post('subject'),
				'message_body' 	=> $this->input->post('message_body'),
			);
			
			$mail_list = $this->email_model->get_exhibitor_emails($current_conf, $filter);
			
			$this->email->from('gisconference@clarion.edu', 'NW PA GIS Conference');
			$this->email->to($mail_list);
			
			$this->email->subject( $email_data['subject'] );
			$this->email->message( $email_data['message_body'] );	
		}
		
		if ($this->form_validation->run() == true && $this->email->send())
		{
			$this->session->set_flashdata('message', "<div class='alert alert-success'>Message sent!<p></p></div>");
			redirect("auth/dashboard", 'refresh');
		}
		else
		{
			// Load Data
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['email_group'] = $filter.' Exhibitors';
			$this->data['subject'] = array(
				'name'  => 'subject',
				'id'    => 'subject',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('subject'),
				'class' => 'form-control',
			);
			$this->data['message_body'] = array(
				'name'  => 'message_body',
				'id'    => 'message_body',
				'type'  => 'textarea',
				'value' => $this->form_validation->set_value('message_body'),
				'class' => 'form-control',
			);
			
			// Load View
	    $this->load->view('include/header');
	    $this->load->view('templates/menubar');
	    $this->load->view('email', $this->data);
	    $this->load->view('include/footer');
	  }
	}
	
	function sponsors($filter = NULL) {
	
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$email_data = array();
		$current_conf = $this->conference_model->get_active_conference();

		// Validate form input
		$this->form_validation->set_rules('subject', 'Subject', 'required');	
		$this->form_validation->set_rules('message_body', 'Message', 'required');	
		
		if ($this->form_validation->run() == true)
		{
			$email_data = array(
				'subject' 			=> $this->input->post('subject'),
				'message_body' 	=> $this->input->post('message_body'),
			);
			
			$mail_list = $this->email_model->get_sponsor_emails($current_conf, $filter);
			
			$this->email->from('gisconference@clarion.edu', 'NW PA GIS Conference');
			$this->email->to($mail_list);
			
			$this->email->subject( $email_data['subject'] );
			$this->email->message( $email_data['message_body'] );	
		}
		
		if ($this->form_validation->run() == true && $this->email->send())
		{
			$this->session->set_flashdata('message', "<div class='alert alert-success'>Message sent!<p></p></div>");
			redirect("auth/dashboard", 'refresh');
		}
		else
		{
			// Load Data
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->data['email_group'] = $filter.' Exhibitors';
			$this->data['subject'] = array(
				'name'  => 'subject',
				'id'    => 'subject',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('subject'),
				'class' => 'form-control',
			);
			$this->data['message_body'] = array(
				'name'  => 'message_body',
				'id'    => 'message_body',
				'type'  => 'textarea',
				'value' => $this->form_validation->set_value('message_body'),
				'class' => 'form-control',
			);
			
			// Load View
	    $this->load->view('include/header');
	    $this->load->view('templates/menubar');
	    $this->load->view('email', $this->data);
	    $this->load->view('include/footer');
	  }
	}
}