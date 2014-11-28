<?php

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		
		
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->model('sponsor_model');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	function index()
	{
		$this->load->view('upload_form', array('error' => ' ' ));
	}

	function sponsor_logo($id)
	{
		// Set up configuration
		$config['upload_path'] = './uploads/sponsor_logos/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		// Load Dependencies
		$this->load->library('upload', $config);
		
		// Load Data
		$data['id'] = $id;
		$data['form_name'] 	= 'upload/sponsor_logo/'.$id;
		$data['header']			= 'Sponsor Upload';

		if (!$this->upload->do_upload('upload_data'))
		{
			$data['message'] = $this->upload->display_errors();

	    $this->load->view('include/header');
	    $this->load->view('templates/menubar');
			$this->load->view('upload_form', $data);
			$this->load->view('include/footer');
		}
		else
		{
			// Load Data
			$data['upload_data'] =  $this->upload->data();
			
			// Get full logo location
			$logo = $config['upload_path'] . $data['upload_data']['file_name'];
			
			// Prepare query to update sponsor logo location
			$query = array('logo' => $logo);
			$this->db->where('sponsor_id', $id);
			
			// Update Logo Location in database
			if (!$this->db->update('sponsor', $query)) {
				$this->session->set_flashdata('message', "<div class='alert alert-error'>There was an error uploading your logo.</div>");
				redirect("auth/dashboard", 'refresh');
				
			} else {
				$this->session->set_flashdata('message', "<div class='alert alert-success'>Your logo was successfully updated.<p>Please check your email for further instructions.</p></div>");
				redirect("auth/dashboard", 'refresh');
			}
		}
	}

	function banner($id)
	{
		// Set up configuration
		$config['upload_path'] = './uploads/banners/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1920';
		$config['max_height']  = '1800';
		
		// Load Dependencies
		$this->load->library('upload', $config);
		
		// Load Data
		$data['id']   			= $id;
		$data['form_name'] 	= 'upload/banner/'.$id;
		$data['header']			= 'Banner Upload';

		if (!$this->upload->do_upload('upload_data'))
		{
			$data['message'] = $this->upload->display_errors();

	    $this->load->view('include/header');
	    $this->load->view('templates/menubar');
			$this->load->view('upload_form', $data);
			$this->load->view('include/footer');
		}
		else
		{
			// Load Data
			$data['upload_data'] =  $this->upload->data();
			
			// Get full logo location
			$banner = $config['upload_path'] . $data['upload_data']['file_name'];
			
			// Prepare query to update sponsor logo location
			$query = array('banner' => $banner);
			$this->db->where('conf_id', $id);
			
			// Update Logo Location in database
			if (!$this->db->update('conference', $query)) {
				$this->session->set_flashdata('message', "<div class='alert alert-error'>There was an error uploading your banner.</div>");
				redirect("auth/dashboard", 'refresh');
				
			} else {
				$this->session->set_flashdata('message', "<div class='alert alert-success'>Your banner was successfully uploaded.</div>");
				redirect("auth/dashboard", 'refresh');
			}
		}
	}
}
?>