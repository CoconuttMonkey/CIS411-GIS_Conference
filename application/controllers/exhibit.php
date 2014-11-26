<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Exhibit extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language', 'form'));
		$this->load->library('breadcrumbs');
		$this->load->model(array('exhibit_model','conference_model'));

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
			redirect('exhibit/listing', 'refresh');
		}
	}
	
	//register a new exhibit
	function register()
	{
		
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$presentation_data = array();

		// Validate form input
		$this->form_validation->set_rules('company_profile', 'Company Profile', 'required');	
		$this->form_validation->set_rules('special_requests', 'Special Requests', '');
		
		if ($this->form_validation->run() == true)
		{
			$exhibit_data = array(
				'conference_id' 		=> $this->conference_model->get_active_conference(),
				'company_profile'		=> $this->input->post('company_profile'),
				'special_requests' 	=> $this->input->post('special_requests'),
			);
			
			$exhibitor_data = array(
				'user_id' 		=> $this->input->post('user_id'),
				'exhibit_id'	=> NULL,
				'is_main'			=> 'yes',
			);
		}
		
		if ($this->form_validation->run() == true && $this->db->insert('exhibit', $exhibit_data))
		{
			$exhibitor_data['exhibit_id'] = $this->db->insert_id();
			if ($this->form_validation->run() == true && $this->db->insert('exhibitor', $exhibitor_data))
			{
				$this->session->set_flashdata('message', "<div class='alert alert-success'>Your exhibit request has been sent<p><strong>You will be contacted by email when your exhibit is scheduled.</strong></p></div>");
				redirect('auth/dashboard','refresh');
			}
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			// Load Data
			$this->data['user_id'] 			 = $this->ion_auth->user()->row()->id;
			$this->data['conference_id'] = $this->conference_model->get_active_conference();
			$this->data['company_profile'] = array(
				'name'  => 'company_profile',
				'id'    => 'company_profile',
				'type'  => 'textarea',
				'placeholder'=>'Describe your company',
				'value' => $this->form_validation->set_value('company_profile'),
				'class' => 'form-control',
			);
			$this->data['special_requests'] = array(
				'name'  => 'special_requests',
				'id'    => 'special_requests',
				'type'  => 'textarea',
				'placeholder'=>'Do you have any special requests',
				'value' => $this->form_validation->set_value('special_requests'),
				'class' => 'form-control',
			);		
		}
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('exhibit/create_exhibit', $this->data);
    $this->load->view('include/footer');

	}
	
	//list exhibits
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
			$this->load->library('table');
			$this->load->library('breadcrumbs');
			$current_conf = $this->conference_model->get_active_conference();
			
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// Load Data
			switch ($filter) {
		    case "paid":
	        $this->data['heading'] = "Paid Exhibits";
	        $this->data['subheading'] = "This is the list of all paid exhibits.";
	        $this->data['exhibits'] = $this->exhibit_model->get_all($current_conf, "paid");
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('Exhibits', 'exhibit/listing' );
					$this->breadcrumbs->push('Paid', 'exhibit/listing/paid' );
	        break;
		    case "unpaid":
	        $this->data['heading'] = "Unpaid Exhibits";
	        $this->data['subheading'] = "This is the list of all unpaid exhibits.";
	        $this->data['exhibits'] = $this->exhibit_model->get_all($current_conf, "unpaid");
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('Exhibits', 'exhibit/listing' );
					$this->breadcrumbs->push('Unpaid', 'exhibit/listing/unpaid' );
	        break;
		    default:
		    	$this->data['heading'] = "Exhibit List";
	        $this->data['subheading'] = "This is the list of all exhibits.";
		    	$this->data['exhibits'] = $this->exhibit_model->get_all($current_conf);
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('All Exhibits', 'exhibit/listing' );
					
			}
			

			// Load View
      $this->load->view('include/header');
      $this->load->view('templates/menubar');
			$this->load->view('exhibit/list_exhibit', $this->data);
      $this->load->view('include/footer');
		}
	}
	
	//edit an exhibit
	function edit($id)
	{
		
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$exhibit_data = $this->exhibit_model->get_exhibit($id);

		// Validate form input
		$this->form_validation->set_rules('company_profile', 'Company Profile', 'required');	
		$this->form_validation->set_rules('special_requests', 'Special Requests', '');	
		$this->form_validation->set_rules('paid', 'Paid Status', '');	
		$this->form_validation->set_rules('table_loc', 'Table Location', '');
		
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() == true)
			{
				$exhibit_data = array(
					'conference_id' 		=> $this->conference_model->get_active_conference(),
					'company_profile'		=> $this->input->post('company_profile'),
					'special_requests' 	=> $this->input->post('special_requests'),
					'paid'							=> $this->input->post('paid'),
					'table_loc'					=> $this->input->post('table_loc'),
				);
				
				if ($exhibit_data['paid'] != 'yes') { $exhibit_data['paid'] = "no"; }
				
				$exhibitor_data = array(
					'user_id' 		=> $this->input->post('user_id'),
					'exhibit_id'	=> NULL,
					'is_main'			=> 'yes',
				);
			}
		  $this->db->where('exhibit_id',$id);
			if ($this->form_validation->run() == true && $this->db->update('exhibit', $exhibit_data))
			{
		  	$this->db->where('user_id',$exhibitor_data['user_id']);
				if ($this->form_validation->run() == true && $this->db->update('exhibitor', $exhibitor_data))
				{
					$this->session->set_flashdata('message', "<div class='alert alert-success'>Your changes have been made.</div>");
					redirect('auth/dashboard','refresh');
				}
				
				
			}
		}
		
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		
		// Load Data			
			$this->data['user_id'] 			 = $this->ion_auth->user()->row()->id;
			$this->data['conference_id'] = $this->conference_model->get_active_conference();
			$this->data['exhibit_id'] 	 = $id;
			$this->data['company_profile'] = array(
				'name'  => 'company_profile',
				'id'    => 'company_profile',
				'type'  => 'textarea',
				'placeholder'=>'Describe your company',
				'value' => $this->form_validation->set_value('company_profile', $exhibit_data['company_profile']),
				'class' => 'form-control',
			);
			$this->data['special_requests'] = array(
				'name'  => 'special_requests',
				'id'    => 'special_requests',
				'type'  => 'textarea',
				'placeholder'=>'Do you have any special requests',
				'value' => $this->form_validation->set_value('special_requests', $exhibit_data['special_requests']),
				'class' => 'form-control',
			);		
			$this->data['table_loc'] = array(
				'name'  => 'table_loc',
				'id'    => 'table_loc',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('table_loc', $exhibit_data['table_loc']),
				'class' => 'form-control',
			);		
			$this->data['paid'] = array(
				'name'  => 'paid',
				'id'    => 'paid',
				'type'  => 'checkbox',
				'value' => $this->form_validation->set_value('paid', $exhibit_data['paid']),
				'class' => 'form-control',
			);	
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('exhibit/edit_exhibit', $this->data);
    $this->load->view('include/footer');

	}
}