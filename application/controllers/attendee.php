<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attendee extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->library('breadcrumbs');
		$this->load->model('attendee_model');
		$this->load->model('conference_model');

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
			redirect('attendee/listing', 'refresh');
		}
	}
	
	//register a new attendee
	function register()
	{
		// Get user's ID and be sure they are not already an attendee
		$user_id = $this->ion_auth->user()->row()->id;
		if ( $this->attendee_model->attendee_exists($user_id) ) {
			$this->session->set_flashdata('message', "<div class='alert alert-danger'>You have already registered for the conference!</div>");
			redirect("auth/dashboard", 'refresh');
		}
		
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$attendee_data = array();

		// Validate form input
		$this->form_validation->set_rules('user_id', 'User', 'required|is_unique[attendee.user_id]');	
		$this->form_validation->set_rules('address_1', 'Address Line 1', 'required');	
		$this->form_validation->set_rules('address_2', 'Address Line 2', '');	
		$this->form_validation->set_rules('city', 'City', 'required');	
		$this->form_validation->set_rules('state', 'State', 'required');	
		$this->form_validation->set_rules('zip', 'Zip Code', 'required');	
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('admission_type', 'Admission Type', 'required');
		
		if ($this->form_validation->run() == true)
		{
			$attendee_data = array(
				'user_id' 				=> $this->input->post('user_id'),
				'address_1' 			=> $this->input->post('address_1'),
				'address_2' 			=> $this->input->post('address_2'),
				'city' 						=> $this->input->post('city'),
				'state' 					=> $this->input->post('state'),
				'zip' 						=> $this->input->post('zip'),
				'country' 				=> $this->input->post('country'),
				'admission_type' 	=> $this->input->post('admission_type'),
			);
		}
		
		if ($this->form_validation->run() == true && $this->db->insert('attendee', $attendee_data))
		{
			
			$this->db->insert('attendee_conference_lookup', array("user_id" => $attendee_data['user_id'], "conference_id" => $this->conference_model->get_active_conference()));
			
			
			$this->email->from('gisconference@clarion.edu', 'NW PA GIS Conference');
			$this->email->to($mail_list);
			$this->email->subject( 'NW PA GIS Conference Attendee Registration' );
			$this->email->message( '<h3>Thank you for registering for this years conference!</h3>
															<p><strong>Please send payments to:</strong><br>ATTN: Dr. Yasser Ayad<br>840 Wood Street<br>Clarion, PA 16214</p>' );	
			$this->email->send();
			
			$this->session->set_flashdata('message', "<div class='alert alert-success'>You have registered for the conference!<p><strong>Check your email for further instructions.</strong></p></div>");
			
			switch ($attendee_data["admission_type"]) {
				case 4:
					redirect("presentation/register", 'refresh');
					break;
				case 5:
					redirect("exhibit/register", 'refresh');
					break;
				default:
					redirect("auth/dashboard", 'refresh');
			}
			
			
		}
		else
		{
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			
			// Load Data
			$this->data['admission_options'] = array(
				'1'		=> '1 Day',
	      '2'  	=> 'Full',
	      '3'   => 'CUP Student / Faculty',
	      '4'		=> 'Presenter',
	      '5'		=> 'Exhibitor',
	      '6'		=> 'Complimentary',
	      '7'		=> 'By Invitation');
	    $this->data['admission_type'] = "";
	    
	    $this->data['state_options'] = array('AL'=>"Alabama",
	      'AK'=>"Alaska", 
	      'AZ'=>"Arizona", 
	      'AR'=>"Arkansas", 
	      'CA'=>"California", 
	      'CO'=>"Colorado", 
	      'CT'=>"Connecticut", 
	      'DE'=>"Delaware", 
	      'DC'=>"District Of Columbia", 
	      'FL'=>"Florida", 
	      'GA'=>"Georgia", 
	      'HI'=>"Hawaii", 
	      'ID'=>"Idaho", 
	      'IL'=>"Illinois", 
	      'IN'=>"Indiana", 
	      'IA'=>"Iowa", 
	      'KS'=>"Kansas", 
	      'KY'=>"Kentucky", 
	      'LA'=>"Louisiana", 
	      'ME'=>"Maine", 
	      'MD'=>"Maryland", 
	      'MA'=>"Massachusetts", 
	      'MI'=>"Michigan", 
	      'MN'=>"Minnesota", 
	      'MS'=>"Mississippi", 
	      'MO'=>"Missouri", 
	      'MT'=>"Montana",
	      'NE'=>"Nebraska",
	      'NV'=>"Nevada",
	      'NH'=>"New Hampshire",
	      'NJ'=>"New Jersey",
	      'NM'=>"New Mexico",
	      'NY'=>"New York",
	      'NC'=>"North Carolina",
	      'ND'=>"North Dakota",
	      'OH'=>"Ohio", 
	      'OK'=>"Oklahoma", 
	      'OR'=>"Oregon", 
	      'PA'=>"Pennsylvania", 
	      'RI'=>"Rhode Island", 
	      'SC'=>"South Carolina", 
	      'SD'=>"South Dakota",
	      'TN'=>"Tennessee", 
	      'TX'=>"Texas", 
	      'UT'=>"Utah", 
	      'VT'=>"Vermont", 
	      'VA'=>"Virginia", 
	      'WA'=>"Washington", 
	      'WV'=>"West Virginia", 
	      'WI'=>"Wisconsin", 
	      'WY'=>"Wyoming"); 
	    $this->data['state'] = 'PA';
	    
			$this->data['user_id'] = $this->ion_auth->user()->row()->id;
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
			$this->data['zip'] = array(
				'name'  => 'zip',
				'id'    => 'zip',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('zip'),
				'class' => 'form-control',
			);
			$this->data['country'] = array(
				'name'  => 'country',
				'id'    => 'country',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('country', "USA"),
				'class' => 'form-control',
			);
		}
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('attendee/create_attendee', $this->data);
    $this->load->view('include/footer');

	}
	
	//list attendees
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
			$this->load->model('attendee_model');
			$this->load->library('table');
			$this->load->library('breadcrumbs');
			
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// Load Data
			
			switch ($filter) {
		    case "paid":
	        $this->data['heading'] = "Paid Attendees";
	        $this->data['subheading'] = "This is the list of all paid attendees.";
	        $this->data['attendees'] = $this->attendee_model->get_all("paid");
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('Sponsors', 'attendee/listing' );
					$this->breadcrumbs->push('Paid', 'attendee/listing/paid' );
	        break;
		    case "unpaid":
	        $this->data['heading'] = "Unpaid Attendees";
	        $this->data['subheading'] = "This is the list of all unpaid attendees.";
	        $this->data['attendees'] = $this->attendee_model->get_all("unpaid");
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('Sponsors', 'attendee/listing' );
					$this->breadcrumbs->push('Unpaid', 'attendee/listing/unpaid' );
	        break;
		    default:
		    	$this->data['heading'] = "Attendee List";
	        $this->data['subheading'] = "This is the list of all attendees.";
		    	$this->data['attendees'] = $this->attendee_model->get_all();
					// add breadcrumbs
					$this->breadcrumbs->push('Dashboard', 'auth/dashboard' );
					$this->breadcrumbs->push('All Attendees', 'attendee/listing' );
			}

			// Load View
      $this->load->view('include/header');
      $this->load->view('templates/menubar');
			$this->load->view('attendee/list', $this->data);
      $this->load->view('include/footer');
		}
	}
	
	//edit an attendee
	function edit($id)
	{
		
		// Load Dependencies
		$tables = $this->config->item('tables','ion_auth');
		$attendee_data = $this->attendee_model->get_attendee($id);

		// Validate form input	
		$this->form_validation->set_rules('address_1', 'Address Line 1', 'required');	
		$this->form_validation->set_rules('address_2', 'Address Line 2', '');	
		$this->form_validation->set_rules('city', 'City', 'required');	
		$this->form_validation->set_rules('state', 'State', 'required');	
		$this->form_validation->set_rules('zip', 'Zip Code', 'required');	
		$this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('admission_type', 'Admission Type', 'required');
				
		if (isset($_POST) && !empty($_POST))
		{
			
			if ($this->form_validation->run() == true)
			{
				$attendee_data = array(
					'address_1' 			=> $this->input->post('address_1'),
					'address_2' 			=> $this->input->post('address_2'),
					'city' 						=> $this->input->post('city'),
					'state' 					=> $this->input->post('state'),
					'zip' 						=> $this->input->post('zip'),
					'country' 				=> $this->input->post('country'),
					'admission_type' 	=> $this->input->post('admission_type'),
				);
			}
			
			if ($this->form_validation->run() == true && $this->db->update('attendee', $attendee_data, "user_id = $id"))
			{
				
				$this->session->set_flashdata('message', "<div class='alert alert-success'>Your contact information has been updated.</div>");
				
				redirect("auth/dashboard", 'refresh');
			}
		}
			
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
		
		// Load Data
		$this->data['admission_options'] = array(
			'1'		=> '1 Day Pass',
      '2'  	=> 'Full Pass',
      '3'   => 'CUP Student / Faculty',
      '4'		=> 'Presenter',
      '5'		=> 'Exhibitor',
      '6'		=> 'Complimentary',
      '7'		=> 'By Invitation',
    );
		$this->data['admission_type'] = $this->form_validation->set_value('admission_type', $attendee_data['admission_type']);
		
    $this->data['state_options'] = array('AL'=>"Alabama",
      'AK'=>"Alaska", 
      'AZ'=>"Arizona", 
      'AR'=>"Arkansas", 
      'CA'=>"California", 
      'CO'=>"Colorado", 
      'CT'=>"Connecticut", 
      'DE'=>"Delaware", 
      'DC'=>"District Of Columbia", 
      'FL'=>"Florida", 
      'GA'=>"Georgia", 
      'HI'=>"Hawaii", 
      'ID'=>"Idaho", 
      'IL'=>"Illinois", 
      'IN'=>"Indiana", 
      'IA'=>"Iowa", 
      'KS'=>"Kansas", 
      'KY'=>"Kentucky", 
      'LA'=>"Louisiana", 
      'ME'=>"Maine", 
      'MD'=>"Maryland", 
      'MA'=>"Massachusetts", 
      'MI'=>"Michigan", 
      'MN'=>"Minnesota", 
      'MS'=>"Mississippi", 
      'MO'=>"Missouri", 
      'MT'=>"Montana",
      'NE'=>"Nebraska",
      'NV'=>"Nevada",
      'NH'=>"New Hampshire",
      'NJ'=>"New Jersey",
      'NM'=>"New Mexico",
      'NY'=>"New York",
      'NC'=>"North Carolina",
      'ND'=>"North Dakota",
      'OH'=>"Ohio", 
      'OK'=>"Oklahoma", 
      'OR'=>"Oregon", 
      'PA'=>"Pennsylvania", 
      'RI'=>"Rhode Island", 
      'SC'=>"South Carolina", 
      'SD'=>"South Dakota",
      'TN'=>"Tennessee", 
      'TX'=>"Texas", 
      'UT'=>"Utah", 
      'VT'=>"Vermont", 
      'VA'=>"Virginia", 
      'WA'=>"Washington", 
      'WV'=>"West Virginia", 
      'WI'=>"Wisconsin", 
      'WY'=>"Wyoming"); 
    $this->data['state'] = $this->form_validation->set_value('state', $attendee_data['state']);
	    
	    
		$this->data['user_id'] = $id;
		$this->data['address_1'] = array(
			'name'  => 'address_1',
			'id'    => 'address_1',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('address_1', $attendee_data['address_1']),
			'class' => 'form-control',
		);
		$this->data['address_2'] = array(
			'name'  => 'address_2',
			'id'    => 'address_2',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('address_2', $attendee_data['address_2']),
			'class' => 'form-control',
		);
		$this->data['city'] = array(
			'name'  => 'city',
			'id'    => 'city',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('city', $attendee_data['city']),
			'class' => 'form-control',
		);
		$this->data['zip'] = array(
			'name'  => 'zip',
			'id'    => 'zip',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('zip', $attendee_data['zip']),
			'class' => 'form-control',
		);
		$this->data['country'] = array(
			'name'  => 'country',
			'id'    => 'country',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('country', $attendee_data['country']),
			'class' => 'form-control',
		);
		
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
		$this->load->view('attendee/edit_attendee', $this->data);
    $this->load->view('include/footer');

	}
		
	function withdraw($id) {
    $tables = array('attendee','attendee_conference_lookup');
		$this->db->where('user_id', $id);
		$this->db->delete($tables);
		
		$this->session->set_flashdata('message', "<div class='alert alert-success'>You successfully withdrew from the conference.</div>");
		redirect('auth/dashboard', 'refresh');
	}
}