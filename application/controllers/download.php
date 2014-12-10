<?php if (!defined('BASEPATH')) die();
class Download extends Main_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language','php-excel'));
		$this->load->library('breadcrumbs');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		
	}
	
	function index() {
		
	}
	
	function attendees($conference_id)
	{
		// Get data from database
		$this->db->select('users.id, users.first_name, users.last_name, users.email, attendee.address_1, attendee.address_2, attendee.city, attendee.state, attendee.zip');
		$this->db->from('attendee');
		$this->db->join('users', 'users.id = attendee.user_id');
    $query = $this->db->get();
    
    if (!$query) {
	    $this->session->set_flashdata('message', "<div class='alert alert-warning'>The requested table is empty!</div>");
	    redirect('auth/dashboard', 'refresh');
    }
    
    // Set column names
		$fields = (
			$field_array[] = array ("ID", "Name", "Email", "Address 1", "Address 2", "City", "State", "Zip")
		);
		
		// Create array of data
		foreach ($query->result() as $row)
		{
			$data_array[] = array( $row->id, $row->first_name." ".$row->last_name, $row->email, $row->address_1, $row->address_2, $row->city, $row->state, $row->zip );
		}
		
		// Export to excel
		$xls = new Excel_XML;
		$xls->addArray ($field_array);
		$xls->addArray ($data_array);
		if ($xls->generateXML ( date('Y')."_Attendees" )) {
			$this->session->set_flashdata('message', "<div class='alert alert-success'>Download Complete</div>");
			redirect('auth/dashboard','refresh');
		}
	}
	
	function presentations($conference_id, $filter = NULL)
	{
		// Load Dependencies
		$this->load->model('presentation_model');
		
		// Get data from database
		
    $query = $this->presentation_model->get_all($conference_id, $filter);
    
    if (!$query) {
	    $this->session->set_flashdata('message', "<div class='alert alert-warning'>The requested table is empty!</div>");
	    redirect('auth/dashboard', 'refresh');
    }
    
    // Set column names
		$fields = (
			$field_array[] = array ("ID", "Title", "Main Presenter", "Contact Email", "Track", "Room", "Day", "Time")
		);
		
		if ($filter == 'pending') {
			// Create array of data
			foreach ($query as $row)
			{
				$data_array[] = array( $row->presentation_id, $row->title, $row->first_name." ".$row->last_name, $row->email, $row->full_name );
			}
			
		} else if ($filter == 'scheduled') {
			// Create array of data
			foreach ($query as $row)
			{
				$data_array[] = array( $row->presentation_id, $row->title, $row->first_name." ".$row->last_name, $row->email, $row->full_name, $row->room_number." ".$row->building, $row->week_day, $row->start_time." - ".$row->end_time );
			}
			
		}
		
		// Export to excel
		$xls = new Excel_XML;
		$xls->addArray ($field_array);
		$xls->addArray ($data_array);
		if ($xls->generateXML ( date('Y')."_$filter"."Presentations" )) {
			$this->session->set_flashdata('message', "<div class='alert alert-success'>Download Complete</div>");
			redirect('auth/dashboard','refresh');
		}
	}
	
	function exhibits($conference_id, $filter = NULL)
	{
		// Load Dependencies
		$this->load->model('exhibit_model');
		
		// Get data from database
		
    $query = $this->exhibit_model->get_all($conference_id, $filter);
    
    if (!$query) {
	    $this->session->set_flashdata('message', "<div class='alert alert-warning'>The requested table is empty!</div>");
	    redirect('auth/dashboard', 'refresh');
    }
    
    // Set column names
		$fields = (
			$field_array[] = array ("ID", "Main Exhibitor", "Contact Email", "Company", "Table Location", "Paid")
		);
		
		// Create array of data
		foreach ($query as $row)
		{
			$data_array[] = array( $row->exhibit_id, $row->first_name." ".$row->last_name, $row->email, $row->company, $row->table_loc, $row->paid );
		}
		
		// Export to excel
		$xls = new Excel_XML;
		$xls->addArray ($field_array);
		$xls->addArray ($data_array);
		if ($xls->generateXML ( date('Y')."_$filter"."Presentations" )) {
			$this->session->set_flashdata('message', "<div class='alert alert-success'>Download Complete</div>");
			redirect('auth/dashboard','refresh');
		}
	}
	
	function sponsors($conference_id, $filter = NULL)
	{
		// Load Dependencies
		$this->load->model('sponsor_model');
		
		// Get data from database
		
    $query = $this->sponsor_model->get_all($conference_id, $filter);
    
    if (!$query) {
	    $this->session->set_flashdata('message', "<div class='alert alert-warning'>The requested table is empty!</div>");
	    redirect('auth/dashboard', 'refresh');
    }
    
    // Set column names
		$fields = (
			$field_array[] = array ("ID", "Contact Name", "Contact Email", "Company Name", "Company Address", "URL", "Sponsor Level", "Paid")
		);
		
		// Create array of data
		foreach ($query as $row)
		{
			$data_array[] = array( $row->sponsor_id, $row->first_name." ".$row->last_name, $row->email, $row->company_name, $row->company_address, $row->url, $row->sponsor_level, $row->paid );
		}
		
		// Export to excel
		$xls = new Excel_XML;
		$xls->addArray ($field_array);
		$xls->addArray ($data_array);
		if ($xls->generateXML ( date('Y')."_$filter"."Sponsors" )) {
			$this->session->set_flashdata('message', "<div class='alert alert-success'>Download Complete</div>");
			redirect('auth/dashboard','refresh');
		}
	}
	
	function presentation_attachment($presentation_id) 
	{
		
		$this->load->helper('download');
		$this->load->model('presentation_model');
		
		$result = $this->presentation_model->get_presentation($presentation_id);
		
		$file_type = substr(strrchr($result['presentation_attachment'],'.'),1);
		
		$name = $result['title'].".".$file_type;
		$path = site_url($result['presentation_attachment']);
		
		$data = file_get_contents( $path );
		
		//print_r($data);
		
		if ( force_download($name, $data) ) {
			$this->session->set_flashdata('message', "<div class='alert alert-success'>Download Complete</div>");
			redirect('auth/dashboard','refresh');
		}
		else {
			$this->session->set_flashdata('message', "<div class='alert alert-success'>Download Fail</div>");
			redirect('presentation/edit/'.$presentation_id,'refresh');
		}
	}
	
}