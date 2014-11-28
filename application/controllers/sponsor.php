<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sponsor extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation','breadcrumbs'));
		$this->load->helper(array('url','language'));
		$this->load->model(array('sponsor_model','conference_model'));

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
		else
		{
			//redirect them to the conference list page
			redirect('sponsor/listing', 'refresh');
		}
	}
	
	//create a new sponsor
	function create_sponsor()
	{
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$sponsor_data = array();

		// Validate form input	
		$this->form_validation->set_rules('main_contact', 'Main Contact', 'required|valid_email|user_email_exists');			
		$this->form_validation->set_rules('company_name', 'Company Name', 'required|xss_clean|max_length[255]');			
		$this->form_validation->set_rules('company_address', 'Company Address', 'required|xss_clean');					
		$this->form_validation->set_rules('url', 'End Date', 'URL');			
		$this->form_validation->set_rules('sponsor_level', 'Sponsor Level', 'required');			
		
		if ($this->form_validation->run() == true)
		{
			
			$sponsor_data = array(
				'conference_id'				=> $this->conference_model->get_active_conference();
				'main_contact'  			=> $this->input->post('main_contact'),
				'company_name'    		=> $this->input->post('company_name'),
				'company_address'    	=> $this->input->post('company_address'),
				'url'      						=> $this->input->post('url'),
				'sponsor_level'      	=> $this->input->post('sponsor_level'),
			);
		}
		
		if ($this->form_validation->run() == true && $this->db->insert('sponsor', $sponsor_data))
		{
			
			$this->session->set_flashdata('message', "<div class='alert alert-success'>You have successfully registered as a sponsor!</div>");
			
			redirect("upload/sponsor_logo/".$this->db->insert_id(), 'refresh');
			
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			// Load Data
			$this->data['main_contact'] = array(
				'name'  => 'main_contact',
				'id'    => 'main_contact',
				'type'  => 'email',
				'value' => $this->form_validation->set_value('main_contact'),
				'class' => 'form-control',
			);
			$this->data['company_name'] = array(
				'name'  => 'company_name',
				'id'    => 'company_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('company_name'),
				'class' => 'form-control',
			);
			$this->data['company_address'] = array(
				'name'  => 'company_address',
				'id'    => 'company_address',
				'type'  => 'textarea',
				'rows'	=> '3',
				'value' => $this->form_validation->set_value('company_address'),
				'class' => 'form-control',
			);
			$this->data['url'] = array(
				'name'  => 'url',
				'id'    => 'url',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('url'),
				'class' => 'form-control',
			);
			$this->data['paid'] = array(
				'name'  => 'paid',
				'id'    => 'paid',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('paid'),
				'class' => 'form-control',
			);
			$this->data['sponsor_level'] = array(
				'name'  => 'sponsor_level',
				'id'    => 'sponsor_level',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('sponsor_level'),
				'class' => 'form-control',
			);
		}
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('sponsor/create_sponsor', $this->data);
    $this->load->view('include/footer');
	}	
	
	//list sponsors
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
			
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// Load Data
			switch ($filter) {
		    case "paid":
	        $this->data['heading'] = "Paid Sponsors";
	        $this->data['subheading'] = "This is the list of all active sponsors.";
	        $this->data['sponsors'] = $this->sponsor_model->get_all($conf_id, "paid");
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('Sponsors', 'sponsor/listing' );
					$this->breadcrumbs->push('Paid', 'sponsor/listing/paid' );
	        break;
		    case "unpaid":
	        $this->data['heading'] = "Unpaid Sponsors";
	        $this->data['subheading'] = "This is the list of all inactive sponsors.";
	        $this->data['sponsors'] = $this->sponsor_model->get_all($conf_id, "unpaid");
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('Sponsors', 'sponsor/listing' );
					$this->breadcrumbs->push('Unpaid', 'sponsor/listing/unpaid' );
	        break;
		    default:
		    	$this->data['heading'] = "Sponsor List";
	        $this->data['subheading'] = "This is the list of all sponsors.";
		    	$this->data['sponsors'] = $this->sponsor_model->get_all($conf_id);
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('All Sponsors', 'sponsor/listing' );
					
			}
			

			// Load View
      $this->load->view('include/header');
      $this->load->view('templates/menubar');
			$this->load->view('sponsor/list', $this->data);
      $this->load->view('include/footer');
		}
	}
	
	//edit a sponsor
	
	function edit($id)
	{
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$sponsor = $this->sponsor_model->get_sponsor($id);
		
		// Validate form input	
		$this->form_validation->set_rules('main_contact', 'Main Contact', 'required|valid_email|user_email_exists');			
		$this->form_validation->set_rules('company_name', 'Company Name', 'required|xss_clean|max_length[255]');			
		$this->form_validation->set_rules('company_address', 'Company Address', 'required|xss_clean');					
		$this->form_validation->set_rules('url', 'End Date', 'URL');			
		$this->form_validation->set_rules('sponsor_level', 'Sponsor Level', 'required');			
		
		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() == true)
			{
					$data = array(
						'main_contact'  			=> $this->input->post('main_contact'),
						'company_name'    		=> $this->input->post('company_name'),
						'company_address'    	=> $this->input->post('company_address'),
						'url'      						=> $this->input->post('url'),
						'sponsor_level'      	=> $this->input->post('sponsor_level'),
						'paid'								=> $this->input->post('paid'),
					);
			
					if ($data['paid'] != 'yes') { $data['paid'] = "no"; }
			}
			
			if ($this->form_validation->run() == true && $this->db->update('sponsor', $data, "sponsor_id = $id"))
			{
				
				$this->session->set_flashdata('message', "<div class='alert alert-success'>Sponsor Updated</div>");
				
				//redirect them to the conference list page
				redirect('sponsor/edit/'.$id, 'refresh');
			}
		}
			$this->data["sponsor"] = $sponsor;
			
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			// Load Data
			$this->data['id'] = $id;
			$this->data['main_contact'] = array(
				'name'  => 'main_contact',
				'id'    => 'main_contact',
				'type'  => 'email',
				'value' => $this->form_validation->set_value('main_contact', $sponsor['main_contact']),
				'class' => 'form-control',
			);
			$this->data['company_name'] = array(
				'name'  => 'company_name',
				'id'    => 'company_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('company_name', $sponsor['company_name']),
				'class' => 'form-control',
			);
			$this->data['company_address'] = array(
				'name'  => 'company_address',
				'id'    => 'company_address',
				'type'  => 'textarea',
				'rows'  => '3',
				'value' => $this->form_validation->set_value('company_address', $sponsor['company_address']),
				'class' => 'form-control',
			);
			$this->data['url'] = array(
				'name'  => 'url',
				'id'    => 'url',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('url', $sponsor['url']),
				'class' => 'form-control',
			);
			$this->data['paid'] = array(
				'name'  => 'paid',
				'id'    => 'paid',
				'type'  => 'checkbox',
				'value' => $this->form_validation->set_value('paid', $sponsor['paid']),
				'class' => 'form-control',
			);
			$this->data['sponsor_level'] = array(
				'name'  => 'sponsor_level',
				'id'    => 'sponsor_level',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('sponsor_level', $sponsor['sponsor_level']),
				'class' => 'form-control',
			);
			
		// Prepare Breadcrumbs
		// load Breadcrumbs
		$this->load->library('breadcrumbs');
		
		// add breadcrumbs
		$this->breadcrumbs->push('Dashboard', site_url('auth/dashboard') );
		$this->breadcrumbs->push('Sponsors', site_url('sponsor/listing') );
		$this->breadcrumbs->push($sponsor['company_name'], site_url('section/page') );
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('sponsor/edit_sponsor', $this->data);
    $this->load->view('include/footer');
	}
	
}