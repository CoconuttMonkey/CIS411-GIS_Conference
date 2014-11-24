<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sponsor extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->model('sponsor_model');

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
			redirect('sponsor/list', 'refresh');
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
				'main_contact'  			=> $this->input->post('main_contact'),
				'company_name'    		=> $this->input->post('company_name'),
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
}