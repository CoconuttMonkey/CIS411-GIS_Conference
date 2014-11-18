<?php if (!defined('BASEPATH')) die();
class Contact extends Main_Controller {

	public function index() {
		
	  // Load page views
		$this->load->view('include/header');
		$this->load->view('templates/menubar');
		$this->load->view('contact');
		$this->load->view('include/footer');
	}
	
	public function send() {
		
		// Load Libraries and Variables
		$errors[] = array();
		
    // Check for & Load Data
		if( isset($_POST['sendmail']) ) {
			$email 	 = trim($_POST['email']);
			$name 	 = trim($_POST['name']);
			$message = trim($_POST['message']);
		}
		
	  // Load models and helpers
		$this->load->library('email');
		
	  // Load Data into email
		$this->email->from($email, $name);
		$this->email->to('m.ondo@icloud.com'); 
		$this->email->subject('Email from MattOndo.com');
		$this->email->message($message);	
		
		// Send email & load data based on send result
		if ($this->email->send()) {
			$data["sent"] 	 = true;
			$data["email"] 	 = $email;
			$data["name"] 	 = $name;
			$data["message"] = $message;
		} else {
			$data["sent"] 	 = false;
			$data["email"] 	 = $email;
			$data["name"] 	 = $name;
			$data["message"] = $message;
		}
		
	  // Load page views
		$this->load->view('include/header');
		$this->load->view('templates/menubar');
		$this->load->view('contact', $data);
		$this->load->view('include/footer');
	}
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
