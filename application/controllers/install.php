<?php if (!defined('BASEPATH')) die();
class Install extends Main_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->library('breadcrumbs');
		$this->load->model('attendee_model', 'conference_model', 'settings_model');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	public function index()
	{	
		// Load Data
		$data['today']		= date('l d, Y');
		
		// Load Views
	  $this->load->view('include/header');
	  $this->load->view('templates/menubar');
	  $this->load->view('install/install', $data);
	  $this->load->view('include/footer');
		
	}
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
