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
		$config['upload_path'] = '/uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);
		
		$data['id'] = $id;

		if (!$this->upload->do_upload())
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
}
?>