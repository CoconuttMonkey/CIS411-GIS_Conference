<?php if (!defined('BASEPATH')) die();
class Frontpage extends Main_Controller {

   public function index()
	{	
		// Load dependencies
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->model(array('conference_model', 'settings_model'));
		
		// Prepare Data
		$current	  = $this->conference_model->get_active_conference();
		$settings 	= $this->conference_model->get_conference($current);
		$start_date = date_create($settings['start_date']);
		$end_date 	= date_create($settings['end_date']);
		
		
		// Load Data
		$data = array();	
		$data["title"]		= $settings['title'];
		$data["prefix"]		= $settings['prefix'];
		$data["theme"] 		= $settings['theme'];
		$data["date"]			= date_format($start_date, 'F jS')." - ".date_format($end_date, 'F jS Y');
		$data["banner"]		= $settings['banner'];
		$data["content"] 	= $settings['frontpage_content'];
		
		
		
		// Load Views
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
    $this->load->view('frontpage', $data);
    $this->load->view('include/footer');
	}
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
