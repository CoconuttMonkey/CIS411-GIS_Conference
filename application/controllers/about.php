<?php if (!defined('BASEPATH')) die();
class About extends Main_Controller {

   public function index()
	{
		// Load dependencies
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));
		$this->load->model('conference_model');
		
		$conf_id = $this->conference_model->get_active_conference();
		$conference = $this->conference_model->get_conference($conf_id);
		
		// Load Data
		$this->data['agenda_url'] = $conference['agenda_url'];
		
		// Load view
    $this->load->view('include/header');
    $this->load->view('templates/menubar');
    $this->load->view('about', $this->data);
    $this->load->view('include/footer');
	}
   
}

/* End of file frontpage.php */
/* Location: ./application/controllers/frontpage.php */
